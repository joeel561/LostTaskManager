
import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../components/page/HomeComponent';
import ProjectOverview from '../components/page/ProjectOverviewComponent';
import Project from '../components/element/ProjectDetail';
import Notes from '../components/page/NotesComponent';
import Chat from '../components/page/ChatComponent';

Vue.use(VueRouter);

const routes = [
    {   path: '/',
        name: 'default',
        component: Home 
    },
    {   path: '/home',
        name: 'home',
        component: Home 
    },
    {   path: '/projects',
        name: 'projects',
        component: ProjectOverview 
    },
    {   path: '/projects/:id', 
        name: 'project',
        component: Project ,
        props: true
    },
    {   path: '/notes',
        name: 'notes',
        component: Notes 
    },
    {   path: '/chat',
        name: 'chat',
        component: Chat 
    },

 ]


const router = new VueRouter({
    mode: 'history',
    routes 
})

export default router