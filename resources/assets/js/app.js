import './bootstrap';
import './media';

import { createApp } from 'vue';

const app = createApp({});

// window.Vue = require('vue');

import MediaComponent from './components/MediaComponent.vue';
app.component('media-component', MediaComponent);

app.mount('#app');

// const app = new Vue({
//     el: '#app'
// });
