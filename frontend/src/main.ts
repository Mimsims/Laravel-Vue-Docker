import { createApp } from 'vue'
import './style.css'
import App from './App.vue'

import { createRouter, createWebHistory } from 'vue-router'
import type { RouteRecordRaw } from 'vue-router'

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        name: 'Characters',
        component: () => import('./components/Characters.vue'),
        meta: {
            title: 'Characters',
        },
    },
    {
        path: '/characters/:id',
        name: 'Character :id',
        component: () => import('./components/CharacterDetails.vue'),
        meta: {
            title: 'Character :id',
        },
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

createApp(App).use(router).mount('#app')
