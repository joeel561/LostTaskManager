<template>
  <div class='detail-project-wrapper information-panel'>
      <div class='project-information pl-4 pr-4 pl-md-0 pr-md-0' v-if='project !== null'>
          <h2>{{project.name}}</h2>
          <p> {{project.description}}</p>

          <div class='d-flex'>
            <h5 class='mr-3'>Deadline:</h5>
            <p>{{timestamp|formatDeadline}} </p>
          </div>
          <div class='d-flex'>
            <h5 class='mr-3'>Project Member:</h5>
            <div class='project-user-assigned' v-for="user in project.assignedUsers" :key='user.username'>
              <span class='mr-2'>{{user.username}}</span>
            </div>
          </div>
      </div>
      <div class='project-task-wrapper' v-if="project.allLocatedTasks">
        <h2 class='pl-4 pr-4 pl-md-0 pr-md-0'>Tasks</h2>
        <div class='task'>
          <b-form  @submit.stop.prevent>
          <b-form-input class="nes-input  pl-4 pr-4 pl-md-0 pr-md-0" placeholder="Add todo..." :state="validation" v-on:keyup.enter="createNewTask" v-model='newTaskName'> </b-form-input>
            <b-form-invalid-feedback :state="validation">
              Your task name is too long.
            </b-form-invalid-feedback>
          </b-form>
            <b-list-group>
              <b-list-group-item v-for="(task, index) in project.allLocatedTasks" :key="task.id">
                <b-form-checkbox class="nes-checkbox" v-model="task.done">
                  <del v-if="task.done">{{ task.name }}</del>
                  <span v-else>{{ task.name }}</span>
                  <div class='select-tag--box' v-bind:class='task.tag'>
                    <b-form-select v-model="newTaskTag[index]" :options="options" value-field='text' text-field="text" v-on:change='editTag($event, task.id, index)'></b-form-select>
                    <div class='selected-tag' v-if='task.tag'>{{task.tag }}</div>
                    <div class='selected-tag select-box-default-text' v-else> Select</div>
                  </div> 
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
  </div>
</template>

<script>
export default {
  name:"Project",
  data: function () {
    return {
      newTaskName: '',
      newTaskTag:[],
      options: [
        { text: 'Waiting'},
        { text: 'In progress'},
        { text: 'Approved'},
      ],
      project: '',
      timestamp: '',
    };
  },

  props: ['id'],

  created() {
    axios.get(`/projects/list/${this.id}`).then((res) => {
      this.project = res.data;
      this.timestamp = res.data.date.timestamp;
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
      this.$delete(this.project.allLocatedTasks,index);
    },
    createNewTask() {
      axios
        .post(`/projects/${this.project.id}/tasks`, { 
          name: this.newTaskName,
        })
        .then(res => {
          this.project.allLocatedTasks.push(res.data);
        });
        this.newTaskName = '';
    },
    editTag(e, taskId, index) {
      
      this.$set(this.project.allLocatedTasks, index, Object.assign({},
      this.project.allLocatedTasks[index], {tag : e}))
      axios
        .patch(`/projects/${this.project.id}/editTag`, { 
          tag: e,
          taskId: taskId
        });
    }
  },
};
</script>