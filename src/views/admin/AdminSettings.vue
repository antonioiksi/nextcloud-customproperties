<template>
	<section class="section">
		<h2>{{ t('customproperties', 'Custom Propertiesssss') }}</h2>
		<p class="settings-hint">
			{{
				t('customproperties', 'Custom Properties defined here are available to all users. They are shown in "Properties" tab in sidebar view. They can be accessed via WebDAV. Deleting properties will not wipe property values.')
			}}
		</p>
		<br>
		<p class="settings-hint">
			{{
				t('customproperties', 'For creating new JSON Dict put the json file with options into the folder "resources/json-customproperties", !IMPORTANT: file name must be match with property name. For example, property with name company must have file company.json ')
			}}
		</p>
		<div>
			<CreateCustomPropertyForm @createProperty="createProperty" />

			<hr>
			<template v-if="properties.length > 0">
				<template v-for="property in properties">
					<EditCustomPropertyForm :key="property.id"
						:property="property"
						@deleteProperty="deleteProperty"
						@updateProperty="updateProperty" />
				</template>
			</template>
			<EmptyPropertiesPlaceholder v-else />
		</div>
		<hr>
		<div>
			<ReindexFilesButton />
		</div>
	</section>
</template>

<script>
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'
import '@nextcloud/dialogs/styles/toast.scss'
import CreateCustomPropertyForm from '../../components/customPropertyForm/CreateCustomPropertyForm'
import EditCustomPropertyForm from '../../components/customPropertyForm/EditCustomPropertyForm'
import EmptyPropertiesPlaceholder from '../../components/emptypropertiesplaceholder/EmptyPropertiesPlaceholder'
import ReindexFilesButton from './ReindexFilesButton.vue'

export default {
	name: 'AdminSettings',
	components: {
		EmptyPropertiesPlaceholder,
		EditCustomPropertyForm,
		CreateCustomPropertyForm,
		ReindexFilesButton
	},
	data() {
		return {
			icon: 'icon-info',
			loading: true,
			name: t('customproperties', 'Properties'),
			properties: [],
		}
	},
	computed: {
		id() {
			return this.name.toLowerCase().replace(/ /g, '-')
		},
		activeTab() {
			return this.$parent.activeTab
		},
	},
	created() {
		this.getDataFromApi()
	},
	methods: {
		async getDataFromApi() {
			const url = generateUrl('/apps/customproperties/customproperties')
			const res = await axios.get(url)
			this.properties = res.data
		},
		async deleteProperty(id) {
			const url = generateUrl(`/apps/customproperties/customproperties/${id}`)
			await axios.delete(url)
			await this.getDataFromApi()
			showSuccess(this.t('customproperties', 'Custom Property has been deleted!'))
		},
		async updateProperty(customProperty) {
			const url = generateUrl('/apps/customproperties/customproperties')
			await axios.post(url, { customProperty })
			await this.getDataFromApi()
			showSuccess(this.t('customproperties', 'Custom Property has been changed!'))
		},
		async createProperty(customProperty) {
			const url = generateUrl('/apps/customproperties/customproperties')
			try {
				await axios.put(url, { customProperty })
				await this.getDataFromApi()
				showSuccess(this.t('customproperties', 'New Custom Property has been added!'))
			} catch (e) {
				console.error(e)
				showError(t('customproperties', 'Error saving property, please check constraints.'))
			}
		},
	},
}
</script>

<style lang="scss" scoped>
.customproperty-empty {
  border: 1px solid var(--color-border-dark);
  padding: .5rem 1rem;
  color: #ccc;
}
</style>
