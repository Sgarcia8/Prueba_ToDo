import './bootstrap';

import { createApp } from 'vue';
import App from './components/App.vue'
import router from './router';
import axios from 'axios';

const app = createApp(App);
app.use(router);
app.mount('#app');