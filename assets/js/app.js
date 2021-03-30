global.axios = require('axios');

import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import Multiselect from 'vue-multiselect';
import Home from './components/HomeComponent';
import Project from './components/ProjectComponent';
import HeadlineComponent from './components/HeadlineComponent';
import Login from './components/LoginComponent';
import Sidebar from './components/SidebarComponent';
const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);
global.Routing = Routing;0 
Vue.component('multiselect', Multiselect);
Vue.component('headline-component', HeadlineComponent);
Vue.component('sidebar', Sidebar);

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

const app = new Vue({
   el: '#app',
   components: { Home, Login, Project, HeadlineComponent, Sidebar, Multiselect }
});

export default app;
