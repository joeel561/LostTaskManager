<template>
  <div class="no-projects" v-if="projects">
    <div class='project-overview--header d-flex'>
      <div class='col-md-10'>
        <headline-component title="Projects" classes='h1'></headline-component>
      </div>
      <div class="d-flex justify-content-end col-md-2">
        <b-button  @click="modalShow = !modalShow" v-b-modal.modal-prevent-closing>New Project</b-button>
      </div>
    </div>
    <div v-if="projects.length > 0" class='project-overview--listing'>
      <projectsListing></projectsListing>
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
</template>

<script>
import projectsListing from '../element/ProjectsListing';

export default {
  name:"ProjectOverview",
  components: {
    projectsListing
  },
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