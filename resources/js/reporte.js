import './1bootstrap';
import { createApp } from 'vue';
import AppReporte from '../src/Reporte.vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

createApp(AppReporte).use(VueSweetalert2).mount('#app');
