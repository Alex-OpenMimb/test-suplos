import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios'; // Asegúrate de tener axios instalado

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        tasks: [], // Estado inicial para las tareas
        errorMessage:'',
        tasksList:''
    },
    mutations: {
        SET_TASKS(state,tasks){
            state.tasksList = tasks;
        },
        ADD_TASK(state, task) {
            state.tasks.push(task);
        },
        SET_ERROR_MESSAGE(state, msm){
            state.errorMessage = msm
        },
        UPDATE_TASK(state, updatedTask) {
            const index = state.tasks.findIndex(t => t.id === updatedTask.id);
            if (index !== -1) {
                Vue.set(state.tasks, index, updatedTask);
            }
        },
        DELETE_TASK(state, taskId) {
            state.tasks = state.tasks.filter(t => t.id !== taskId);
        }
    },
    actions: {
        fetchTasks({commit} ){
            axios.get(`/tasks`)
                .then( response =>{
                    let tasks = response.data.response
                    commit('SET_TASKS', tasks);

                }).catch(error => {

                console.error("Error adding task:", error);
            });
        },
        filterTasks( {commit},status ){
            axios.get(`/tasks/${status}`)
                .then( response =>{
                    let tasks = response.data.response
                    commit('SET_TASKS', tasks);

                }).catch(error => {

                console.error("Error adding task:", error);
            });
        },
        addTask({ commit }, task) {
            axios.post('/tasks', task)
                .then(response => {

                    if( response.data.status ){
                        let task = response.data.response[0]
                        commit('ADD_TASK', task);
                    }else{
                        let msm = response.data.response
                        commit('SET_ERROR_MESSAGE', msm )
                        console.log(response.data.response)
                    }

                })
                .catch(error => {

                    console.error("Error adding task:", error);
                });
        },completeTask({ commit }, id){
              axios.put(`/task/complete/${id}`).then(response=>{
                      console.log(response.data)
                  })
        },
        updateTask({ commit }, task) {

            axios.put(`/task/${task.id}`, task)
                .then(response => {
                    if( !response.data.status ){
                        let msm = response.data.response
                        commit('SET_ERROR_MESSAGE', msm )

                    }
                })
                .catch(error => {
                    console.error("Error updating task:", error);
                });
        },
        deleteTask({ commit }, taskId) {
            axios.delete(`/task/${taskId}`)
                .then(() => {
                    commit('DELETE_TASK', taskId);
                })
                .catch(error => {
                    console.error("Error deleting task:", error);
                });
        }
    },
    getters: {
        tasks: state => state.tasks,
        errorMessage: state => state.errorMessage,

    }
});
