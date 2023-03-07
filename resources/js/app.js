/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import '../sass/app.scss';

import { createApp } from 'vue/dist/vue.esm-bundler';
import axios from 'axios';
import VueAxios from 'vue-axios';
import Auth from './auth.js';
import router from './router.js';


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('master-content', require('./components/MasterContent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
const app = createApp({});

app.use(router);
app.config.globalProperties.$auth = Auth;

import MasterContent from './components/MasterContent.vue';
import AlertResponse from './components/AlertResponse.vue';

app.config.globalProperties.$filters = {
    handleEmail: function(value) {
        return value.substring(0, 10) + ' .... ';
    }
}

app.component('MasterContent', MasterContent);
app.component('AlertResponse', AlertResponse);
app.mount('#app');