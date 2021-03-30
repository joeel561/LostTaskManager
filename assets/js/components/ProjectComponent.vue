<template>
  <div class="col-md-12">
    <div>
      <div class="row">
        <sidebar></sidebar>
      </div>
      <div class="row">
        <div class="col-md-12">
          <headline-component title="Project"></headline-component>
          <div class='detail-project-wrapper'>
              <div class='project-information' v-if='project !== null'>
                  <h2>{{project.name}}</h2>
                  <p> {{project.description}}</p>
                  <div class='d-flex'>
                    <h5 class='mr-3'>Project Member:</h5>
                    <div class='project-user-assigned' v-for="user in project.assignedUsers" :key='user.username'>
                      <span class='mr-2'>{{user.username}}</span>
                    </div>
                  </div>
              </div>
              <div class='project-task-wrapper'>
                <h2>Tasks</h2>
                <div class='task'>
                  <b-form  @submit.stop.prevent>
                  <b-form-input class="nes-input" placeholder="Add todo..." :state="validation" v-on:keyup.enter="createNewTask" v-model='newTaskName'> </b-form-input>
                    <b-form-invalid-feedback :state="validation">
                      Your task name is too long.
                    </b-form-invalid-feedback>
                  </b-form>
                    <b-list-group>
                      <b-list-group-item v-for="(task, index) in project.allLocatedTasks" :key="task.id">
                        <b-form-checkbox class="nes-checkbox" v-model="task.done">
                          <del v-if="task.done">{{ task.name }}</del>
                          <span v-else>{{ task.name }}</span>
                          <b-form-select v-model="selected" :options="options" class='ml-auto'></b-form-select>
                          <b-button variant="link" v-on:click.prevent="removeTodo(task.id, index)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1a1a1a" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <line x1="18" y1="6" x2="6" y2="18" />
                              <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                          </b-button>
                        </b-form-checkbox>
                      </b-list-group-item>
                  </b-list-group>
                </div>
              </div>
              <div class='project-inbox-wrapper'>
                <h2>Inbox</h2>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name:"Project",
  props: ['projectid'],
  data: function () {
    return {
      newTaskName: '',
      selected: null,
      options: [
        { value: null, text: 'Add tag'},
        { value: 'waiting', text: 'Waiting'},
        { value: 'in-progress', text: 'In progess'},
        { value: 'approved', text: 'Approved'},

      ],
      project: null
    };
  },

  created() {
    axios.get(`/projects/${this.projectid}`, {headers: {'X-Requested-With':'XMLHttpRequest'}}).then((res) => {
      this.project = res.data;
    });
  },

  computed: {
    validation() {
      return this.newTaskName.length <= 100
    }
  },

  methods: {
    removeTodo(id, index) {
    	axios.delete(`/projects/${this.project.id}/deleteTask`, {
        data: {id: id}
      })
      this.$delete( this.project.allLocatedTasks,index);
    },
    createNewTask() {
      axios
        .post(`/projects/${this.project.id}/tasks`, { 
          name: this.newTaskName 
        })
        .then(res => {
          this.project.allLocatedTasks.push(res.data);
        });
        this.newTaskName = '';
    }
  },
};
</script>