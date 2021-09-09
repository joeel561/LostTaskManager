<template>
  <div class='d-flex justify-content-between flex-lg-row flex-column'>
    <div class='col-12 col-lg-4'>
      <headline-component title="Hello" classes='h1'></headline-component>
      <p class='dashboard-welcome--text'>Welcome back to your Task Manager, we missed u!</p>
      <div class='dashboard-project--listing'>
        <headline-component title="Projects" classes='h2'></headline-component>
        <projectsListing v-bind:maxLimit='6'></projectsListing>
      </div>
      </div>
      <div class='col-12 col-lg-7 dashboard-project--detail'>
        <project v-bind:id='1'></project>
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

    };
  },             
};
</script>