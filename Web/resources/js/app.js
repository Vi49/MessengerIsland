import './bootstrap';

import { createApp } from 'vue';
import * as VueRouter from "vue-router";

import Index from "./components/Index.vue";
import TestComponent from "./components/TestComponent.vue";

const routes = [
    { path: '/test', component: TestComponent}
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/'),
    routes
})

const app = createApp({});

app.use(router)

app.component('Index', Index);
app.component('TestComponent', TestComponent);

app.mount('#app');
