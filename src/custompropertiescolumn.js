/* eslint-disable */
import Vue from 'vue'
import { translate, translatePlural } from '@nextcloud/l10n'

import CustomPropertiesColumnBody from './views/filestable/CustomPropertiesColumnBody'
import CustomPropertiesColumnHead from './views/filestable/CustomPropertiesColumnHead'
import CustomPropertiesColumnFoot from './views/filestable/CustomPropertiesColumnFoot'
// import { mount } from '@vue/test-utils'

let pathname = location.pathname;
window.addEventListener("click", function() {
	if (location.pathname != pathname) {
		pathname = location.pathname;
		console.log('pathname changed!');
		// code
		// aaa()
	}
});




let mList = document.getElementById('fileList'),
	options = {
		childList: true
	},
	observer = new MutationObserver(mCallback);

function mCallback(mutations) {
	for (let mutation of mutations) {
		if (mutation.type === 'childList') {
			console.log('Mutation Detected: A child node has been added or removed.');
			renderCustomPropertiesColumn()
		}
	}
}

observer.observe(mList, options);


window.addEventListener('DOMContentLoaded', () => {
	// aaa()
})

async function renderCustomPropertiesColumn() {
	if (OCA.Files) {
		Vue.prototype.t = translate
		Vue.prototype.n = translatePlural

		// add column into header
		let countCPColumnHead = $('#headerCustomProperties').length
		if(countCPColumnHead===0) {
			const CPColumnHead = Vue.extend(CustomPropertiesColumnHead)
			const component = new CPColumnHead().$mount()
			$('#filestable thead tr').append(component.$el)
		}

		// add column into foot
		let countCPColumnFoot = $('#footCustomProperties').length
		if(countCPColumnFoot===0) {
			const CPColumnFoot = Vue.extend(CustomPropertiesColumnFoot)
			const component = new CPColumnFoot().$mount()
			$('#filestable tfoot tr').append(component.$el)
		}

		// add column with data about custom properties

		setTimeout(() => {
			let nodes = document.querySelectorAll('#fileList tr')
			console.log('nodes', nodes)
			nodes.forEach(el => {
				console.log(el.attributes)
				let count = $('.customProperties', el).length
				console.log('count', count)
				if (count === 0) {
					const CPColumnBody = Vue.extend(CustomPropertiesColumnBody);
					const fileInfo = {
						name: el.dataset.file,
						path: el.dataset.path,
					}
					const component = new CPColumnBody({
						propsData: {
							msg: 'HI :)' + el.dataset.id,
							fileInfo: fileInfo
						}
					})

					component.updateFileInfo(fileInfo).then(
						component.$mount()
					)
					el.append(component.$el)
				}
			})

		}, 2000);
	}
}
