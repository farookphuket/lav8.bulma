<template>
  <div>
        
        <guest-nav v-show="isGuestUser"></guest-nav>
        <member-nav v-show="isUserLogin"></member-nav>
      <router-view></router-view>
  </div>
</template>

<script>
import GuestNav from './GuestNav.vue'
import MemberNav from './MemberNav.vue'
export default {
    name:"App",
             components:{
                 GuestNav,
                 MemberNav,
             },
             data(){
                 return{
                     isOpen:false,
                     isUserLogin:false,
                     isGuestUser:true,
                 }
             },
             mounted(){
                    this.checkAuth()
             },
             methods:{
                 burgerToggle(){
                    // nav-main 
                    this.isOpen = !this.isOpen
                 },
                 checkAuth(){
                     if(this.$cookies.get('token') != null){
                         this.isGuestUser = false
                         this.isUserLogin = true
                     }
                 },
             },
};
</script>
