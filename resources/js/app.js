require('./bootstrap');

import Vue from 'vue';

import router from './routes.js';
import AppComponent from './components/AppComponent.vue'

const app = new Vue({
    components: { AppComponent },
    router
}).$mount('#app')