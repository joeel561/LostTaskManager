global.axios = require('axios');

import Vue from 'vue';
import App from './components/App';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import Multiselect from 'vue-multiselect';
import Task from './components/element/TaskComponent';
import HeadlineComponent from './components/layout/HeadlineComponent';
import Sidebar from './components/layout/SidebarComponent';
const detailRoute = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import Vue2Editor from "vue2-editor";

import router from './routes';

Routing.setRoutingData(detailRoute);
global.Routing = Routing;
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
Vue.use(Vue2Editor);

const app = new Vue({
   el: '#app',
   router,
   components: { HeadlineComponent, Sidebar, Multiselect, Task },
   render: h => h(App)
});

export default app;
