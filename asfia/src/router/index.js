import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginViewVue from '@/views/LoginView.vue'
import LandingViewVue from '@/views/LandingView.vue'
import axios from 'axios'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginViewVue
    },
    {
        path: '/landing',
        name: 'landing',
        component: LandingViewVue
    }
  ]
})

//beforeEach will hook into each navigation to and from a route in this application
router.beforeEach((to, from) => {

    if(to.name === 'login') {
        return true
    }

    if(!localStorage.getItem('token')) {
        return {
            name: 'login'
        }
    }

    checkTokenAuthenticity()
})

const checkTokenAuthenticity = () => {
    axios.get('http://localhost/api/user', {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
    })
    .then((response) => {})
    .catch((error) => {
      localStorage.removeItem('token')
      router.push({
        name: 'login'
      })
    })
}
export default router
