<template>
  <div>
        
        <guest-nav v-show="isGuestUser"></guest-nav>
        <member-nav v-show="isUserLogin"></member-nav>
      <router-view></router-view>
        <footer class="footer">
            <div class="tiles is-ancestor">
                <div class="tile is-horizontal">

                    <div class="tile">
                        <div class="content has-text-centered">
                            <visitor></visitor>
                        </div>
                    </div>

                </div>
            </div>
        </footer>
  </div>
</template>

<script>
import GuestNav from './GuestNav.vue'
import MemberNav from './MemberNav.vue'
import Visitor from '../pages/Visitor.vue'

export default {
    name:"App",
             components:{
                 GuestNav,
                 MemberNav,
                 Visitor,
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
