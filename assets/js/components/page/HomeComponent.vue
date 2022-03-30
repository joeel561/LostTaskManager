<template>
  <div class='d-flex justify-content-between flex-lg-row flex-column' v-if='projects.length > 0'>
    <div class='col-12 col-lg-4'>
      <headline-component title="Hello Buddy :3" classes='h1'></headline-component>
      <p class='dashboard-welcome--text'>Welcome back to your Task Manager</p>
        <div class='dashboard-project--listing'>
          <headline-component title="Projects" classes='h2'></headline-component>
          <projectsListing v-bind:maxLimit='6'></projectsListing>
        </div>
    </div>
    <div class='col-12 col-lg-7 dashboard-project--detail'>
      <project v-bind:id='1'></project>
    </div>
  </div>
      <div v-else class="d-flex justify-content-center flex-lg-row flex-column">
        <div class='col-12 text-center dashboard-welcome-wrapper'>
          <headline-component title="Hello Buddy :3" classes='h1'></headline-component>
          <p class='dashboard-welcome--text mb-lg-5  mb-3 col-md-6 '>Welcome to your Task Manager, if this is your first Sign In please create a new Project to see all details on this page. Thank you for testing my Project Manager Tool I'm looking forward to your feedback!</p>
          <h3 align="center" class="text-white mt-lg-5 mb-3 mb-lg-5">You don't have any projects yet please create some here.</h3>
          <b-button>
            <router-link to="/projects" class='home-btn'> Create new project</router-link>
          </b-button>
          <b-button class='dashboard-chat-btn'>
            <router-link to="/chat" class='home-btn'> Get me to the chat!</router-link>
          </b-button>
          <b-button>
            <router-link to="/notes" class='home-btn'> Create new notes</router-link>
          </b-button>
        </div>
      </div>
</template>

<script>
import projectsListing from '../element/ProjectsListing';
import project from '../element/ProjectDetail';
export default {
  name:"Home",
  components: {
    projectsListing,
    project
  },
  data: function () {
    return {
      projects: [],
      

    };
  },  
  
  created() {
    axios.get("/projects/list").then((res) => {
      this.projects = res.data;
    });
  },           
};
</script>