import Vue from 'vue'
import VueRouter from 'vue-router'

import store from './store'

Vue.use(VueRouter)

import DashboardComponent from './components/DashboardComponent.vue'
import LoginComponent from './components/LoginComponent.vue'
import RegisterComponent from './components/RegisterComponent.vue'
import LogoutComponent from './components/LogoutComponent.vue'

const routes = [
    {
        path: '/',
        redirect: { name: 'login' }
    },
    {
        path: '/dashboard-admin',
        name: 'dashboard',
        component: DashboardComponent,
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        name: 'login',
        component: LoginComponent
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterComponent
    },
    {
        path: '/logout',
        name: 'logout',
        component: LogoutComponent
    }
]


const router = new VueRouter({
    routes
})

router.beforeEach((to, from, next) => {

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        // redirect to login page
        next({ name: 'login' })
        return
    }

    // if logged in redirect to dashboard
    if(to.path === '/login' && store.state.isLoggedIn) {
        next({ name: 'dashboard' })
        return
    }

    if(to.path === '/register' && store.state.isLoggedIn) {
        next({ name: 'dashboard' })
        return
    }

    next()
})

export default router