<template>
	<div>
		<template v-for="(property, index) in properties">
			<PropertySelectInput
				v-if="property.propertytype == 'json-dict'"
				:key="index"
				:disabled="disabled"
				:property="property"
				@change="$emit('propertyChanged', $event)" />
			<PropertyLinkInput
				v-else-if="isType(property.propertytype, 'url')"
				:key="index"
				:disabled="disabled"
				:property="property"
				@blur="$emit('propertyChanged', $event)" />
			<PropertyTextInput
				v-else
				:key="index"
				:disabled="disabled"
				:property="property"
				@blur="$emit('propertyChanged', $event)" />
		</template>
	</div>
</template>

<script>

import PropertyTextInput from './input/PropertyTextInput'
import PropertyLinkInput from './input/PropertyLinkInput'
import PropertySelectInput from './input/PropertySelectInput'

export default {
	name: 'PropertyList',
	components: {
		PropertyLinkInput,
		PropertyTextInput,
		PropertySelectInput
	},
	props: {
		properties: {
			type: Array,
			required: true,
		},
		disabled: {
			type: Boolean,
			default: false,
		},
	},
	data: () => ({
	}),
	methods: {
		isType(typeOfProperty, ...types) {
			return types.includes(typeOfProperty)
		},
	},
}
</script>
