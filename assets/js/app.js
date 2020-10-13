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

const filter = function(text, length, clamp) {
   clamp = clamp || '';
   const node = document.createElement('div');
   node.innerHTML = text;
   const content = node.textContent;
   return content.length > length ? content.slice(0, length) + clamp : content;

};
Vue.filter('truncate', filter);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
