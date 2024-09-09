<template>
    <div class="container mt-5 d-flex  ">

            <div class="w-50 mx-4">
                <h1 class="text-center mb-4">Task List</h1>
                <ul class="list-group mb-4">
                    <li v-for="task in tasks" :key="task.id" class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">{{ task.title }}</h5>
                            <p class="mb-1">{{ task.description }}</p>
                            <small class="text-muted">Assigned to: {{ task.user }}</small>
                        </div>
                        <div>
                            <button class="btn btn-success btn-sm mr-2" @click="completeTask(task.id)">Complete</button>
                            <button class="btn btn-danger btn-sm" @click="deleteTask(task.id)">Delete</button>
                        </div>
                    </li>
                </ul>
                <form @submit.prevent="addTask" class="card card-body">
                    <div class="form-group">
                        <input v-model="newTask.title" class="form-control" placeholder="Task Title" required>
                    </div>
                    <div class="form-group">
                        <input v-model="newTask.description" class="form-control" placeholder="Task Description" required>
                    </div>
                    <div class="form-group">
                        <input v-model="newTask.email" class="form-control" placeholder="Assigned User" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Add Task</button>
                </form>
                <div v-if="errorMessage" class="error-message mt-4 text-danger">
                    {{ errorMessage }}
                </div>
            </div>

            <div class="mx-4">
                <div class="d-flex flex-column">
                    <label for="completedSelect" class="form-label">Filter</label>
                    <select v-model="completed" id="completedSelect" class="form-select form-select-sm">
                        <option selected value="all">all</option>
                        <option value="1">Completed</option>
                        <option value="0">No completed</option>
                    </select>
                </div>
                <table class="table table-bordered mt-5">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="task in tasksList" :key="task.id" >
                        <td>{{ task.id }}</td>
                        <td>{{ task.title }}</td>
                        <td>{{ task.description }}</td>
                        <td>{{ task.user }}</td>
                        <td>{{ task.completed ? 'Completed' : 'Not Completed' }}</td>
                        <td> <button   @click="setTask(task)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            update
                        </button>
                        </td>

                    </tr>

                    </tbody>
                </table>
            </div>


        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Heading</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form @submit.prevent="updateTask" class="card card-body">
                            <div class="form-group">
                                <input v-model="selectedTask.title" class="form-control" placeholder="Task Title" required>
                            </div>
                            <div class="form-group">
                                <input v-model="selectedTask.description" class="form-control" placeholder="Task Description" required>
                            </div>
                            <div class="form-group">
                                <input v-model="selectedTask.email" class="form-control" placeholder="Assigned User" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Add Task</button>
                        </form>
                    </div>
                    <div v-if="errorMessage" class="error-message text-center text-danger">
                        {{ errorMessage }}
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

    </div>

</template>

<script>
import {mapActions, mapState} from 'vuex';


export default {
    data() {
        return {
            newTask: {
                title: '',
                description: '',
                email: '',
            },
            token:'',
            completed:'all',
            taskId:0,
            selectedTask: {}

        };
    },
    computed: {
        ...mapState(['tasks','errorMessage','tasksList']) // Simplificado para mapState
    },
    methods: {
        ...mapActions(['fetchTasks', 'addTask', 'completeTask', 'deleteTask','filterTasks','updateTask']),
        addTask() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!this.newTask.title || !this.newTask.description || !this.newTask.email) {
                alert('Both title and description are required');
                return;
            }

            if(!emailRegex.test(this.newTask.email)){
                alert('Email invalid');
                return;
            }

            // Se utiliza la acción 'addTask' y luego se limpia el formulario
            this.$store.dispatch('addTask', this.newTask).then(() => {
                this.$store.dispatch('fetchTasks')
                this.newTask.title = '';
                this.newTask.description = '';
                this.newTask.user = '';


            }).catch(error => {
                console.error('Error adding task:', error);
            });
        },
        completeTask(taskId) {
            // Se utiliza la acción 'completeTask'

            this.$store.dispatch('completeTask',  taskId).then(()=>{
                this.$store.dispatch('fetchTasks')
                document.getElementById('')
            }).catch(error => {
                console.error('Error completing task:', error);
            });
        },
        deleteTask(taskId) {
            // Se utiliza la acción 'deleteTask'
            this.$store.dispatch('deleteTask', taskId).then(error => {
                this.$store.dispatch('fetchTasks')
            }).catch(error => {
                console.error('Error completing task:', error);
            });
        },
        setTask(task){
            this.selectedTask = { ...task };
            console.log( task.title )
        },
        updateTask(){
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!this.selectedTask.title || !this.selectedTask.description || !this.selectedTask.email) {
                alert('Both title and description are required');
                return;
            }

            this.$store.dispatch('updateTask', this.selectedTask ).then(() => {
                  $('#myModal').modal('hide');
                this.$store.dispatch('fetchTasks')
            }).catch(error => {
                console.error('Error adding task:', error);
            });

        }
    },
    mounted() {
          ///this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          this.$store.dispatch('fetchTasks')
    },
    watch: {
        completed(newVal, oldVal) {
            if(newVal === 'all')    this.$store.dispatch('fetchTasks')
            else{
                this.$store.dispatch('filterTasks',newVal)
            }

        }
    }
};
</script>
