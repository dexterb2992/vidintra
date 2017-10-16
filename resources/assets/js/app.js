require('./bootstrap');

import Vue from 'vue';

import App from './App.vue';
import router from './router';

window.app = new Vue({
	el: '#root',
	template: `<app></app>`,
	components: { App },
	router
})


