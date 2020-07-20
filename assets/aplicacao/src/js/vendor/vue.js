import Vue from 'vue/dist/vue.esm.browser.min.js'; //'./vue.js';

const vueApp = new Vue({
	el: '#formularioParaContato',
	data: {
		tituloDoFormulario: 'Entre em contato com a Netshow.me!',
	},
});

export { vueApp };