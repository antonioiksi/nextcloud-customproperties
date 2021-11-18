<template>
	<th id="headerCustomProperties" class="customProperties"><span class="columntitle">{{ name }}</span></th>
</template>
<script>
const CustomPropertiesColumnHead = {
	props: ['text'],
	data() {
		return {
			name: t('customproperties', 'Properties'),
		}
	}
}

export default CustomPropertiesColumnHead
</script>
<style>
table th#headerCustomProperties {
  min-width: 300px;
}

</style>
