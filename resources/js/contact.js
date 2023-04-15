import './1bootstrap';
import { createApp } from 'vue';
import AppContact from '../src/Contact.vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

createApp(AppContact).use(VueSweetalert2).mount('#app');
