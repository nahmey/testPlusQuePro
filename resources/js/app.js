import './bootstrap';
import { createApp } from 'vue';

import '../css/styles.css';

import App from '@/layout/App.vue';
import routes from '@/routes';
import helpers from '@/helpers';

import Notifications from '@kyvg/vue3-notification';
import LoadingCardOverlay from '@/components/utilities/LoadingCardOverlay.vue';

const app = createApp(App);

app
.use(routes)
.use(helpers, app)
.use(Notifications)
.component('loading-card-overlay', LoadingCardOverlay)
.mount('#app');
