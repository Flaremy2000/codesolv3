import './1bootstrap';
import { createApp } from 'vue';
import Appchpss from '../src/chpss.vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

createApp(Appchpss).use(VueSweetalert2).mount('#app');
