<template>
	<button
		class="button"
		type="button"
		@click="reindexFiles($event)"
		v-text="t('customproperties', 'Reindex files')"
		:disabled="loading" />
</template>

<script>
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'

export default {
	name: 'ReindexFilesButton',
	data() {
		return {
			loading: false,
		}
	},
	methods: {
		async reindexFiles(event) {
			const url = generateUrl('/apps/customproperties/customproperties/reindexFiles')
			showSuccess(this.t('customproperties', 'File indexing started.'), { timeout: 3000 })
			try {
				this.loading = true
				const res = await axios.get(url)
				// eslint-disable-next-line no-console
				console.log(res.data)
				showSuccess(this.t('customproperties', 'All files are indexed.'))
			} catch (e) {
				console.error(e)
				showError(t('customproperties', 'File indexing error.'))
			}
			this.loading = false
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
