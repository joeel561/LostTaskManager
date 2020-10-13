<template>
    <!-- Create Task Modal -->
    <b-modal id="taskCreate" title="Create Task" ok-title='Submit'>
            <div class='module-box'>
            <label> Title: </label>
            <input
                v-model="newTaskName"
                type="text"
                class="form-control"
                id="username"
                placeholder="What are you working on?"
            />
            </div>
            <div class='module-box'>
            <label for='date-picker'> Deadline: </label>
            <b-form-datepicker id="date-picker" v-model="newTaskDeadline" size="sm" locale="en" :date-format-options="{ year: 'numeric', month: 'short', day: '2-digit', weekday: 'short' }" class="mb-2"></b-form-datepicker>
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
                v-model="newTaskDescription"
                placeholder="Enter something..."
                rows="3"
                max-rows="6"
            ></b-form-textarea>
            </div>
        
        <button
        @click="createNewTask(selectedProject)"
        class="btn btn-default btn-success"
        >Save</button>
    </b-modal>
</template>

<script>
export default {
  data: function () {
    return {
      newTaskName: "",
      newTaskDeadline: '',
      newTaskDescription: ''
    };
  },

  created() {
    axios.get("/projects").then((res) => {
      this.projects = res.data;
    });
  },

  methods: {
    createNewTask(project) {
      axios
        .post(`/projects/${project.id}/tasks`, { name: this.newTaskName })
        .then((res) => {

        });

      this.newTaskName = "";
    }
  },
};
</script>