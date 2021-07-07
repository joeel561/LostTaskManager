<template>
  <div>
    <headline-component title="Hello" classes='h1'></headline-component>
    <p class='dashboard-welcome--text'>Welcome back to your Task Manager, we missed u!</p>
    <div class='row'>
      <div class='col-md-6 dashboard-project--listing'>
        <headline-component title="Projects" classes='h2'></headline-component>
        <projectsListing v-bind:maxLimit='6'></projectsListing>
      </div>
    </div>
  </div>
</template>

<script>
import projectsListing from '../element/ProjectsListing';
export default {
  name:"Home",
  components: {
    projectsListing
  },
  data: function () {
    return {

    };
  },             
};
</script>