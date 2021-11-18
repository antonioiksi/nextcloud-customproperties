<template>
	<div class="customproperty-form-group red">
		<label :for="'property_'+property_.propertyname">{{ property_.propertylabel }}</label>
		<div class="customproperty-input-group">
			<select v-model="property_.propertyvalue" class="customproperty-form-control" @change="onChange($event)">
				<option v-for="(select, index) in options" :key="index">{{ select.name  }}</option>
			</select>
		</div>
	</div>
</template>

<script>
/* eslint-disable */

import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

export default {
	name: 'PropertySelectInput',
	model: {
		prop: 'property',
	},
	mounted() {
		// eslint-disable-next-line no-console
		console.log('mounted')

		// // eslint-disable-next-line no-console
		// console.log(this.property)
		// const dataJson = () => import('../json/data.json')
		//
		// dataJson().then(function(data) {
		// 	// eslint-disable-next-line no-console
		// 	console.log('dataJson', data)
		// })
	},
	props: {
		property: {
			type: Object,
			required: true,
		},
		disabled: {
			type: Boolean,
			default: false,
		},
	},
	data() {
		return {
			property_: this.property,
			options: []
		}
	},
	created() {
		console.log('created')
		this.loadOptions()
	},

	methods: {
		blur() {
			this.$emit('blur', this.property_)
		},
		onChange(event) {
			// eslint-disable-next-line no-console
			console.log(event.target.value)
			this.$emit('change', this.property_)
		},
		async loadOptions() {
			this.options = [
				{
					"name": "",
				},
			]
			// const linkJsonOptions = 'http://192.168.56.5:8000/resources/json-customproperties/default.json'
			const linkJsonOptionsDefault = generateUrl(`/resources/json-customproperties/default.json`).replace('/index.php','')
			const linkJsonOptions = generateUrl(`/resources/json-customproperties/${this.property.propertyname}.json`).replace('/index.php','')
			try {
				console.log(linkJsonOptions)
				const { data } = await axios.get(linkJsonOptions)
				console.log('data', data)
				this.options = this.options.concat(data)
				
			} catch (e) {
				console.error('Failure!');
				console.error(e.response.status);
				const { data } = await axios.get(linkJsonOptionsDefault)
				// Object.assign(this.options, ...data)
				this.options = this.options.concat(data)
			}
		}
	},
}
</script>
