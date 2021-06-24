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
              <b-list-group>
                      <b-list-group-item v-for="task in project.tasks" :key="task.id">
                        <b-form-checkbox class="nes-checkbox" v-model="task.done">
                          <del v-if="task.done">{{ task.text }}</del>
                          <span v-else>{{ task.text }}</span>
                          <b-form-select v-model="selected" :options="options" class='ml-auto'></b-form-select>
                          <b-button variant="link" v-on:click="removeTodo(task.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1a1a1a" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <line x1="18" y1="6" x2="6" y2="18" />
                              <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                          </b-button>
                        </b-form-checkbox>
                      </b-list-group-item>
                  </b-list-group>
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
};
</script>