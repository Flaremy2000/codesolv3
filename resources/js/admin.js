import './1bootstrap';
import { createApp } from 'vue';
import AppAdmin from '../src/Admin.vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
createApp(AppAdmin).use(VueSweetalert2).mount('#app');
