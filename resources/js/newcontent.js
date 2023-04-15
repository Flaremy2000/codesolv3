import './1bootstrap';
import NewsContent from '../src/NewsContent.vue';
import { createApp } from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

createApp(NewsContent).use(VueSweetalert2).mount('#app');
