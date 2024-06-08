import 'bootstrap'
import {createApp} from 'vue/dist/vue.esm-bundler.js';
import Home from './components/Home.vue';
import './bootstrap'; //burası eklendi bootstrap için

import '../sass/app.scss' //burası eklendi bootstrap için

const app = createApp({});

app.component('home-component', Home);

app.mount("#app");