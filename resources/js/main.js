import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'
import Login from './components/Auth/Login.vue'
import Register from './components/Auth/Register.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    // Add other routes as needed
  ]
})

const app = createApp(App)
app.use(router)
app.mount('#app') 