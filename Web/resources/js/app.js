import './bootstrap';

import '@fortawesome/fontawesome-free/css/all.css';

import { createApp } from 'vue';
import * as VueRouter from "vue-router";

import Index from "./components/Index.vue";
import TestComponent from "./components/TestComponent.vue";
import HomeComponent from "./components/HomeComponent.vue";
import AfterRegComponent from "./components/AfterRegComponent.vue";
import SearchComponent from "./components/AfterRegComponent.vue";
import ChatComponent from "./components/ChatComponent.vue"


const routes = [
    { path: '/test', component: TestComponent},
    { path: '/', component: HomeComponent},
    { path: '/home', component: HomeComponent},
    { path: '/afterreg', component: AfterRegComponent},
    { path: '/chat/:chat_type/:chat_id', component: HomeComponent}, //opens a chat, chat_type can be user/group/bot, chat_id is an id of user/group/bot
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
app.component('SearchComponent', SearchComponent);
app.component('ChatComponent', ChatComponent);

app.mount('#app');
