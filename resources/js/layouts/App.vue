<template>
  <div>
        
        <guest-nav v-show="isGuestUser"></guest-nav>
        <member-nav v-show="showMemberNav"></member-nav>
        <admin-nav v-show="showAdminNav"></admin-nav>
      <router-view></router-view>
        <footer class="footer">
            <visitor></visitor>

        </footer>
  </div>
</template>

<script>
import GuestNav from './GuestNav.vue'
import MemberNav from './MemberNav.vue'
import AdminNav from './AdminNav.vue'
import Visitor from '../pages/Visitor.vue'

export default {
    name:"App",
             components:{
                 GuestNav,
                 MemberNav,
                 AdminNav,
                 Visitor,
             },
             data(){
                 return{
                     isOpen:false,
                     isUserLogin:false,
                     isGuestUser:true,
                     isAdminUser:false,
                     showMemberNav:false,
                     showAdminNav:false,
                     tk:'',

                 }
             },
             mounted(){
                    
                    this.tk = this.$cookies.get('token')
                    this.checkAuth()
             },
watch:{

      },
             methods:{

                 burgerToggle(){
                    // nav-main 
                    this.isOpen = !this.isOpen
                 },
                 checkAuth(){
                    //console.log(this.$cookies.get('token'))
                    this.showMemberNav = false 
                    this.showAdminNav = false

                    let url = `/api/checkpasssport`
                    axios.post(url,{
                        headers:{'Authorization':`Basic ${this.tk}`},
                            })
                    .then(res=>{
                       //console.log(res.data)
                        let rD = res.data
                        if(rD.user_obj != null){

                            this.isUserLogin = true 
                            this.showMemberNav = true
                            this.isGuestUser = false
                                if(rD.user_obj.is_admin != 0){
                                    this.showMemberNav = false
                                    this.showAdminNav = true 
                                    this.isAdminUser = true
                                }
                            }else{

                                this.isGuestUser = true

                            } 

                        })
                 },
             },
};
</script>
