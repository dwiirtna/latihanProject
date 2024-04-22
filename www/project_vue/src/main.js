import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';
// import Swal from 'sweetalert2'

//bootstrap
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap/dist/js/bootstrap.min";

//swall2
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const app = createApp(App)
app.config.globalProperties.$axios = axios;
app.use(VueSweetalert2);
app.use(router)

app.mount('#app')
