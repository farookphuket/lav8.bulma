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

                    <div class="tile is-parent is-6">
                        <div class="content is-6">
                            <h2>Company</h2>
                            <div class="box">
                                <p>company limited</p>
                            </div>
                        </div>
                        
                    </div>

                    <div class="tile is-2">
                        <div class="content">
                            <h2 class="has-text-centered">
                                contact
                            </h2>
                            <div class="tags">
                                <p>
                                name
                                <span class="tag is-info">
                                    farook 
                                </span>
                                </p>
                                <p>
                                e-mail
                                <span class="tag is-info">
                                email@me.com
                                </span></p>
                            </div>
                            <ol class="tags is-roman">
                                <li class="tag is-info">
                                name farok
                                </li>

                                <li class="tag is-info">
                                e-mail farok
                                </li>
                            </ol>
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
                    let url = `/api/checkpasssport`
                    axios.post(url,{
                        headers:{'Authorization':`Basic ${this.tk}`},
                            })
                    .then(res=>{
                       //console.log(res.data)
                        let rD = res.data
                        if(rD.user == false){
                            this.isGuestUser = true
                            }else{
                                this.isUserLogin = true 
                                this.isGuestUser = false
                            } 
                        })
                 },
             },
};
</script>
