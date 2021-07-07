
import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../components/page/HomeComponent';
import ProjectOverview from '../components/page/ProjectOverviewComponent';
import Project from '../components/page/ProjectComponent';
import Notes from '../components/page/NotesComponent';

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
        component: Project 
    },
    {   path: '/notes',
        name: 'notes',
        component: Notes 
    }
 ]


const router = new VueRouter({
    routes 
})

export default router