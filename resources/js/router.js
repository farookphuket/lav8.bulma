import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './pages/Home.vue';
import About from './pages/About.vue';
import Post from './pages/Post.vue';
import Login from './pages/Login.vue';
import Logout from './pages/Logout.vue'
import Register from './pages/Register.vue';
import UserHasConfirm from './pages/UserHasConfirmed.vue'
import UserConfirmationFail from './pages/UserConfirmationFail.vue'
import MemberProfile from './pages/Member/Profile/Profile.vue'
import Visitor from './pages/Visitor.vue'

// member 
import MemHome from './pages/Member/Home.vue'


// admin 
import AdminHome from './pages/Admin/Home.vue'



Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/about',
            name: 'about',
            component: About
        },

        {
            path: '/posts',
            name: 'posts',
            component: Post
        },

        {
            path: '/login',
            name: 'login',
            component: Login
        },


        {
            path: '/logout',
            name: 'logout',
            component: Logout
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },

        {
            path: '/user-has-confirmed',
            name: 'userHasConfirmed',
            component: UserHasConfirm
        },

        {
            path: '/user-confirmation-fail',
            name: 'userConfirmationFail',
            component: UserConfirmationFail
        },

        {
            path: '/visitor',
            name: 'visitor',
            component: Visitor
        },
        {
            path: '/member/home',
            name: 'MemberDashboard',
            component: MemHome,

        },

        {
            path: '/member/profile',
            name: 'MemberProfile',
            component: MemberProfile
        },


        {
            path: '/admin/home',
            name: 'AdminDashboard',
            component: AdminHome
        },
    ]
});


router.beforeEach((to,from,next)=>{

    document.title = to.name
    next()
})

export default router;
