import Vue from "vue"
import Vuex from "vuex"
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    tasks: [],
    showCompleted: true
  },
  mutations: {
    setTasks: (state, tasks) => {
      state.tasks = tasks
    }
  },
  actions: {
    getTasks: ({commit}) => {
      axios.get(process.env.VUE_APP_API_URL)
        .then(res => commit("setTasks", res.data))
        .catch(err => console.log(err))
    }
  },
  modules: {}
});
