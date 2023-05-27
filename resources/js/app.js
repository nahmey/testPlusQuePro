import './bootstrap';
import { createApp } from 'vue';

import '../css/styles.css';

import App from '@/layout/App.vue';
import routes from '@/routes';
import helpers from '@/helpers';

const app = createApp(App);

app
.use(routes)
.use(helpers, app)
.mount('#app');
