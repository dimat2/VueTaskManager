<template>
  <div>
      <h1>Home</h1>
      <form class="row">
        <input type="text" v-model="task" placeholder="Add new task" class="columns small-7">
        <input type="date" @blur="addTask" v-model="due" class="columns small-5">
      </form>
      <div class="row">
        <div class="column small-12">
          <div class="row">
            <i class="fi-check column small-2" @click="toggleCompleted" title="Kész feladatok elrejtése / megmutatása"></i>
            <div class="column small-10 text-right">
              <i class="fi-checkbox" title="nyitott">{{nyitott}} </i>
              <i class="fi-flag" title="lejárt">{{lejart}}</i>
            </div>
          </div>
        </div>
      </div>
      <ul>
        <li v-for="task in tasks" :key="task.id" :class="{ completed: task.completed }"
          v-show="!task.completed || (showCompleted && task.completed)">
          <div class="row">
            <span class="columns small-1"><input @click="changeCompleted(task.id)" type="checkbox" :checked="task.completed"></span>
            <span class="columns small-9">{{ task.name }}</span>
            <i class="fi-pencil col small-1"></i>
            <i class="fi-trash col-small-1"></i>
          </div>
          <div class="row">
            <span class="columns small-6"><i class="fi-calendar"></i>{{ task.created }}</span>
            <span class="columns small-6 text-right"><i class="fi-flag"></i>{{ task.due }}</span>
          </div>
        </li>
      </ul>
  </div>
</template>

<script>
  import axios from 'axios'

  export default {
    name: "home",
    components: {

    },
    data() {
      return {
        task: "",
        due: (new Date).toISOString().split('T')[0],
      }
    },
    computed: {
      nyitott: function() {
        return this.tasks.filter(t => !t.completed).length
      },
      lejart: function() {
        return this.tasks.filter(t => !t.completed && t.due < new Date().toISOString()).length
      },
      tasks: function() {
        return this.$store.state.tasks
      },
      showCompleted: function() {
        return this.$store.state.showCompleted
      }
    },
    created() {
    },
    methods: {
      addTask() {
        const task = {
          name: this.task,
          due: this.due,
          completed: false
        }
        axios.post(process.env.VUE_APP_API_URL, task)
          .then(res => this.tasks.push(res.data))
          .catch(err => console.log(err))
      },
      changeCompleted(id) {
        let task = this.tasks.find(task => task.id == id)
        task.completed = !task.completed
        axios.put(process.env.VUE_APP_API_URL, task)
          .then(res => console.log(res))
          .catch(err => console.log(err))
      },
      toggleCompleted() {
        this.$store.state.showCompleted = !this.$store.state.showCompleted
      }
    }
  }
</script>

<style scoped>
  .completed {
    text-decoration: line-through;
    color: #4fc08d;
    border: none;
  }
  .completed:hover {
    background: white;
    color: #4fc08d;
  }
  h1 {
    background: #4fc08d;
    color: white;
    padding: 1rem;
    text-align: center;
  }
  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    font-size: 1.5rem;
    color: #333;
  }
  li {
    margin: 1rem;
    position: relative;
    top: 0.5rem;
    border-bottom: 1px solid #4fc08d;;
    padding: 10px 10px;
  }
  li:hover {
    background: #4fc08d;
    color: white;
    transition: 05.s;
  }
  form {
    display: flex;
  }
  input[type=text] {
    flex-grow: 3;
    font-size: 1.5rem;
    height: 2.5rem;
  }
</style>