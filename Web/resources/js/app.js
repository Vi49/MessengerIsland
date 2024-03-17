import './bootstrap';

import '@fortawesome/fontawesome-free/css/all.css';

import { createApp } from 'vue';
import * as VueRouter from "vue-router";

import Index from "./components/Index.vue";
import TestComponent from "./components/TestComponent.vue";
import HomeComponent from "./components/HomeComponent.vue";
import AfterRegComponent from "./components/AfterRegComponent.vue";


const routes = [
    { path: '/test', component: TestComponent},
    { path: '/', component: HomeComponent},
    { path: '/home', component: HomeComponent},
    { path: '/afterreg', component: AfterRegComponent},
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/'),
    routes
})

const app = createApp({});

app.use(router)

app.component('Index', Index);
app.component('TestComponent', TestComponent);
app.component('HomeComponent', HomeComponent);
app.component('AfterRegComponent', AfterRegComponent);

app.mount('#app');
