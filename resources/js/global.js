import './1bootstrap';
import Login from '../src/Login.vue';
import { createApp } from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

createApp(Login).use(VueSweetalert2).mount('#login');
