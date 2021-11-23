/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue'


import router from './router';
import App from './layouts/App.vue';

import 'jodit/build/jodit.min.css'
import JoditVue from 'jodit-vue'

Vue.use(JoditVue)

window.axios = require('axios');

import moment from 'moment';

// ============== 27 June 2021 ================================================
import Form from './core/Form';
import CustomText from './core/CustomText';

window.Form = Form;
window.CustomText = CustomText;


// date 10 Jan 2021 start using vue-cookies
import VueCookies from 'vue-cookies';
Vue.use(VueCookies)


import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
Vue.component('font-awesome-icon', FontAwesomeIcon)

import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const {default : Axios } = require('axios');


const app = new Vue({
    router,
    el: '#app',
    render: h => h(App),
});
