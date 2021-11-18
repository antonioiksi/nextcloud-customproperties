<template>
	<td class="customProperties">
		<ul>
			<template v-for="item in this.properties.knownProperties">
				<li v-if="item.propertyvalue && item.propertyvalue.length > 0" :key="item.propertyname"> <b>{{ item.propertylabel }}</b>: {{ item.propertyvalue }}</li>
			</template>
		</ul>
	</td>
</template>

<script>
/* eslint-disable no-console,no-tabs */

import { getCurrentUser } from '@nextcloud/auth'
import { generateRemoteUrl, generateUrl } from '@nextcloud/router'
import axios from '@nextcloud/axios'
import { isEmptyObject, xmlToTagList } from '../sidebar/utils'

export default {
	name: 'CustomPropertiesColumnBody',
	props: {
		fileInfo: {
			type: Object,
			default: () => {},
		},
	},
	data() {
		return {
			uid: getCurrentUser().uid,
			loading: true,
			fileInfo_: this.fileInfo,
			properties: {
				knownProperties: [],
				otherProperties: [],
			},

		}
	},
	async mounted() {
		// console.log('fileInfo', this.fileInfo)
		await this.update()
	},
	methods: {
		async updateFileInfo(fileInfo) {
			this.fileInfo_ = fileInfo
			await this.update()
		},
		async update() {
			console.log('fileInfo_', this.fileInfo_)
			this.properties.knownProperties = []
			this.properties.otherProperties = []
			if (!isEmptyObject(this.fileInfo)) {
				this.loading = true

				// eslint-disable-next-line no-unused-vars
				const properties = await this.retrieveProps(this.fileInfo_)
				console.log('properties', properties)
				const customProperties = await this.retrieveCustomProperties()

				const customPropertyNames = customProperties.map(cp => `${cp.prefix}:${cp.propertyname}`)

				this.properties.knownProperties = customProperties.map(cp => {
					const property = properties.find(p => `${cp.prefix}:${cp.propertyname}` === p.propertyname)
					return {
						...property,
						...cp,
					}
				})
				console.log('this.properties.knownProperties', this.properties.knownProperties)

				this.properties.otherProperties = properties
					.filter(property => {
						return !customPropertyNames.includes(property.propertyname)
					})
					.map(property => {
						return {
							propertylabel: property.propertyname,
							...property,
						}
					})

				this.loading = false
			}
		},
		async retrieveCustomProperties() {
			try {
				const customPropertiesUrl = generateUrl('/apps/customproperties/customproperties')
				const customPropertiesResponse = await axios.get(customPropertiesUrl)
				return customPropertiesResponse.data
			} catch (e) {
				console.error(e)
				return []
			}
		},
		async retrieveProps() {
			try {
				const uid = getCurrentUser().uid
				const path = `/files/${uid}/${this.fileInfo_.path}/${this.fileInfo_.name}`.replace(/\/+/ig, '/')
				const url = generateRemoteUrl('dav') + path
				const result = await axios.request({
					method: 'PROPFIND',
					url,
					data: '<d:propfind xmlns:d="DAV:"></d:propfind>',
				})
				return xmlToTagList(result.data)
			} catch (e) {
				console.error(e)
				return []
			}
		},
	}

}
</script>

<style lang="scss">

#fileList .customProperties {
  min-width: 300px;

  .text {
    float: left;
    padding: 15px 0;
  }
}

</style>
