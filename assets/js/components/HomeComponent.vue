<template>
  <div class="col-md-12">
    <div class="no-projects" v-if="projects">
      <div class="row">
        <sidebar></sidebar>
      </div>
      <div class="row">
        <div class="col-md-10">
          <headline-component title="Projects"></headline-component>
        </div>
        <div class="d-flex justify-content-end col-md-2">
          <b-button  @click="modalShow = !modalShow" v-b-modal.modal-prevent-closing>New Project</b-button>
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

      <div v-else>
        <h3 align="center">You need to create a new project</h3>
      </div>

      <!-- Create Project Modal -->
      <b-modal
        id="modal-prevent-closing"
        ref="modal"
        title="Create new project"
        @show="resetModal"
        @hidden="resetModal"
        @ok="handleOk"
        v-model="modalShow"
      >
        <form ref="form" @submit.stop.prevent="handleSubmit">
          <b-form-group
            :state="nameState"
            label="Name"
            label-for="name-input"
            invalid-feedback="Name is required"
          >
            <b-form-input
              id="project-name"
              v-model="newProjectName"
              :state="nameState"
              required
              class="form-control"
            ></b-form-input>
          </b-form-group>
          <b-form-group
            :state="DateState"
            label="Deadline"
            label-for="date-input"
            invalid-feedback="Date is required"
          >
            <b-form-datepicker
              id="date-picker"
              :state="DateState"
              v-model="newDate"
              size="sm"
              locale="en"
              :date-format-options="{
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                weekday: 'short',
              }"
              class="mb-2"
            ></b-form-datepicker>
          </b-form-group>
          <b-form-group
            :state="userState"
            label="User"
            label-for="user-input"
            invalid-feedback="User is required"
          >
            <multiselect v-model="newUser" :options="users" :multiple="true" :taggable="true" tag-position="bottom" label='username' track-by="username" @tag="addTag"></multiselect>
          </b-form-group>
          <b-form-group
            :state="descriptionState"
            label="Description"
            label-for="description-input"
            invalid-feedback="Description is required"
          >
            <b-form-textarea
              id="textarea"
              v-model="newDescription"
              placeholder="Enter something..."
              rows="3"
              max-rows="6"
            ></b-form-textarea>
          </b-form-group>
        </form>
      </b-modal>
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
    axios.get("/projects").then((res) => {
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
    addTag (newTag) {
      const tag = {
        username: newTag
      }
      this.users.push(tag)
      this.newUser.push(tag)
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState,
        this.DateState,
        this.userState,
        (this.descriptionState = valid);
      return valid;
    },
    resetModal() {
      this.newProjectName = "";
      this.newDate = "";
      this.newDescription = "";
      this.newUser = "";
      (this.nameState = null),
      (this.DateState = null),
      (this.userState = null),
      (this.descriptionState = null)
    },
    handleOk(bvModalEvt) {
      bvModalEvt.preventDefault();


      this.handleSubmit();
    },
    handleSubmit() {
      if (!this.checkFormValidity()) {
        return;
      }
      this.$nextTick(() => {
        this.modalShow = false;
      });
      axios
        .post("/projects/create", {
          name: this.newProjectName,
          description: this.newDescription,
          date: this.newDate,
          user: this.newUser
        })
        .then((res) => {
          this.projects.push(res.data);
        });
    },
  },
};
</script>