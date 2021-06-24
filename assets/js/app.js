global.axios = require('axios');

import Vue from 'vue';
import VueRouter from 'vue-router';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import Multiselect from 'vue-multiselect';
import App from './components/App';
import Home from './components/HomeComponent';
import ProjectOverview from './components/ProjectOverviewComponent';
import Project from './components/ProjectComponent';
import HeadlineComponent from './components/HeadlineComponent';
import Login from './components/LoginComponent';
import Register from './components/RegisterComponent';
import Sidebar from './components/SidebarComponent';
import Notes from './components/NotesComponent';
const detailRoute = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import Vue2Editor from "vue2-editor";

const routes = [
   { path: '/', component: Home },
   { path: '/projects', component: ProjectOverview },
   { path: '/notes', component: Notes },
   { path: '/projects/:id', component:Project },
   { path: '/login', component: Login},
   { path: '/register', component: Register}
]

Routing.setRoutingData(detailRoute);
global.Routing = Routing;
Vue.component('multiselect', Multiselect);
Vue.component('headline-component', HeadlineComponent);
Vue.component('sidebar', Sidebar);

const router = new VueRouter({
   routes 
})


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
Vue.use(VueRouter);
const app = new Vue({
   el: '#app',
   router,
   components: { Home, Login,  ProjectOverview,Project, HeadlineComponent, Sidebar, Multiselect, Notes },
   render: h => h(App)
});

export default app;
