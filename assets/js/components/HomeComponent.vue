<template>
  <div class="col-md-12">
    <div class="no-projects" v-if="projects">
      <div class="row">
        <sidebar></sidebar>
      </div>
      <div class="row">
        <div class="col-md-10">
          <headline-component title="Dashboard"></headline-component>
        </div>
      </div>
      <div v-if="projects.length > 0">
        <b-container class="projects-row">
          <b-row>
            <b-col
              cols="4"
              lg="2"
              v-for="project in projects"
              :key="project.id"
              >
              <b-link v-bind:href="getUrl(project.id)">
                <div class="project-column">
                  <h3>{{ project.name | truncate(2, "") }}</h3>
                  <span>{{ project.name | truncate(20, "..") }}</span>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-arrow-narrow-right"
                    width="44"
                    height="44"
                    viewBox="0 0 24 24"
                    stroke-width="1"
                    stroke="#2c3e50"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <line x1="15" y1="16" x2="19" y2="12" />
                    <line x1="15" y1="8" x2="19" y2="12" />
                  </svg>
                </div>
              </b-link>
            </b-col>
          </b-row>
        </b-container>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name:"Home",
  data: function () {
    return {
      projects: null,
      newDate: "",
      newDescription: "",
      newProjectName: "",
      newUser: "",
      nameState: null,
      DateState: null,
      userState: null,
      users: [],
      user: {},
      descriptionState: null,
      modalShow: false,
      allUsers: null,
      usernames: null,
    };
  },

  created() {
    axios.get("/projects/list").then((res) => {
      this.projects = res.data;
    });
    axios.get("/users").then((res) => {
      this.users = res.data;
    });
  },

  methods: {
    getUrl(id) {
      return Routing.generate("project_detail", {id:id});  
    },
  },
};
</script>