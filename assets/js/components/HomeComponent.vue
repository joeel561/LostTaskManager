<template>
  <div class="col-md-8 col-md-offset-2">
    <div class="no-projects" v-if="projects">
      <div class="row">
        <div class="col-sm-12">
          <b-button v-b-modal.projectCreate>New Project</b-button>
        </div>
      </div>
      <div v-if="projects.length > 0">
        <b-container class='projects-row'>
            <b-row>
              <b-col  cols='2' class='project-column'
                v-for="project in projects"
                :key="project.id">
                {{ project.name | truncate(2, '')}}
                {{ project.name  | truncate(20, '..')}}
              </b-col>
            </b-row>
        </b-container>
      </div>

      <div v-else>
        <h3 align="center">You need to create a new project</h3>
      </div>

      <!-- Create Project Modal -->
      <b-modal id="projectCreate" title="Create new project">
        <div class='module-box'>
          <label> Title: </label>
          <input
            v-model="newProjectName"
            type="text"
            class="form-control"
            id="project-name"
            placeholder="Project Name"
          />
        </div>
        <div class='module-box'>
          <label for='date-picker'> Deadline: </label>
          <b-form-datepicker id="date-picker" v-model="newDate" size="sm" locale="en" :date-format-options="{ year: 'numeric', month: 'short', day: '2-digit', weekday: 'short' }" class="mb-2"></b-form-datepicker>
        </div>
        <div class='module-box'>
          <label> User: </label>
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
            <g>
              <path fill="none" d="M0 0h22v22H0V0z"/>
              <ellipse cx="8.25" cy="6.417" fill="none" stroke="rgb(79,79,79)" stroke-dasharray="0 0 0 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" rx="3.667" ry="3.667"/>
              <path fill="none" stroke="rgb(79,79,79)" stroke-dasharray="0 0 0 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.75 19.25v-1.83333333C2.75 15.39162258 4.39162258 13.75 6.41666667 13.75h3.66666666C12.10837742 13.75 13.75 15.39162258 13.75 17.41666667V19.25"/>
              <g>
                <path fill="none" stroke="rgb(79,79,79)" stroke-dasharray="0 0 0 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 10h4"/>
                <path fill="none" stroke="rgb(79,79,79)" stroke-dasharray="0 0 0 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 8v4"/>
              </g>
            </g>
          </svg>

        </div>
        <div class='module-box'>
          <label> Description: </label>
            <b-form-textarea
              id="textarea"
              v-model="newDescription"
              placeholder="Enter something..."
              rows="3"
              max-rows="6"
          ></b-form-textarea>
        </div>


        <div class="modal-footer">
          <button
            data-dismiss="modal"
            v-bind:disabled="newProjectName == ''"
            @click="createNewProject"
            type="submit"
            class="btn btn-default btn-success"
          >
            Create
          </button>
        </div>
      </b-modal>
    </div>

  </div>
</template>

<script>
export default {
  data: function () {
    return {
      projects: null,
      newDate: '',
      newDescription: '',
      newProjectName: "",
    };
  },

  created() {
    axios.get("/projects").then((res) => {
      this.projects = res.data;
    });
  },

  methods: {
    /**
     * create new project
     */
    createNewProject() {
      axios
        .post("/projects/create", { name: this.newProjectName, description: this.newDescription, date:this.newDate })
        .then((res) => {
          this.projects.push(res.data);
        });
    },
  },
};
</script>