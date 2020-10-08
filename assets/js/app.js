global.axios = require('axios');

import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import Home from './components/HomeComponent';
import Headline from './components/HeadlineComponent';
import Login from './components/LoginComponent';

new Vue({
   el: '#app',
   components: { Home, Login, Headline }
});

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);