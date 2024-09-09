import Vue from 'vue';
import Vuex from 'vuex';
import TaskList from './components/TaskList.vue';
import store from './store';
import axios from 'axios';

Vue.use(Vuex);
// Configuración global de Axios
console.log(window.myToken.csrfToken)
axios.defaults.baseURL = 'http://127.0.0.1:8000'; // Cambia esto a tu URL base si es necesario
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CSRF-TOKEN'] = window.myToken.csrfToken;
const app = new Vue({
    el: '#app',
    store, // Agrega el store a la instancia de Vue
    components: { TaskList },
});
