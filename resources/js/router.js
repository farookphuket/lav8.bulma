import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './pages/Home.vue';
import About from './pages/About.vue';
import Post from './pages/Post.vue';
import PostView from './pages/PostView.vue'
import Login from './pages/Login.vue';
import Logout from './pages/Logout.vue'
import Register from './pages/Register.vue';
import UserHasConfirm from './pages/UserHasConfirmed.vue'
import UserConfirmationFail from './pages/UserConfirmationFail.vue'
import MemberProfile from './pages/Member/Profile/Profile.vue'
import Visitor from './pages/Visitor.vue'

// member 
import MemHome from './pages/Member/Home.vue'
import MPost from './pages/Member/Post/Post.vue'

// admin 
import AdminHome from './pages/Admin/Home.vue'
import AdminPost from './pages/Admin/Post/Post.vue'
import AdminUser from './pages/Admin/User/User.vue'
import AdminCategory from './pages/Admin/Category/Category.vue'


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
            path: '/post',
            name: 'post',
            component: Post
        },

        {
            path: '/:slug',
            name: 'PostView',
            component: PostView
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
            path: '/member/post',
            name: 'MPost',
            component: MPost,

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

        {
            path: '/admin/post',
            name: 'AdminPost',
            component: AdminPost
        },

        {
            path: '/admin/user',
            name: 'AdminUser',
            component: AdminUser
        },

        {
            path: '/admin/category',
            name: 'AdminCategory',
            component: AdminCategory
        },


        {
            path:'*',
            redirect:'/login'
        },
    ]
});


router.beforeEach((to,from,next)=>{

    document.title = to.name
    next()
})

export default router;
