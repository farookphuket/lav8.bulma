<template>

<section class="section">
        <nav class="breadcrumb" aria-label="breadcrumbs">
          <ul>
            <li><a href="/member/home">Home</a></li>
            <li class="is-active">
                <a href="#" aria-current="page">Profile</a>
            </li>
          </ul>
        </nav>
        
        <div class="columns">
            <div class="column is-5">
                <div class="content">
                    <h2 class="title has-text-centered">{{show_u_name}}'s profile</h2>
                    <h3 class="subtitle">edit my profile</h3>
                    <div class="msg">
                        <p>
                            edit my profile.
                        </p>
                        <ul class="mt-2">
                            <li>Change my name</li>
                            <li>Change my email</li>
                            <li>Change my password</li>
                        </ul>
                    </div>
                </div>
                <div class="field">
                    <div class="box">

                        <h2 class="title has-text-centered">
                            Delete Account
                        </h2>
                        <p class="mb-4">
                            <span class="is-medium warning">
                                Warning !
                            </span> this action cannot be undo! once you have click 
                            the "delete" button your account and all the thing 
                            that you have been done such as post,comment etc. 
                            will be erase so please make sure that you have 
                            backup your important data.
                        </p>
                       <a class="button is-block is-danger is-outlined" 
                          @click.prevent="delMyAccount(user_id)"
                           :disabled='isDisabled'>
                            <font-awesome-icon icon="user-times"></font-awesome-icon> 
                            delete my account
                       </a>
                    </div>

                </div>
            </div>

            <div class="column is-6">
               <profile-form @getMyInfo="getMyInfo($event)"></profile-form>
            </div>
        </div>

        <!-- modal START -->

        <div class="modal" :class="{'is-active':isModalShow}">
          <div class="modal-background"></div>
          <div class="modal-content">
              <div class="box">
                    <div v-html="res_status">{{res_status}}</div>
              </div>

          </div>
          <button class="modal-close is-large" aria-label="close" 
          @click.prevent="isModalShow = false"></button>
          <div class="columns">
              <div class="column">
                <div class="field is-pulled-right">
                    <button class="button is-success is-outlined" 
                    @click.prevent="isModalShow = ''">
                        <font-awesome-icon icon="check"></font-awesome-icon>
                    </button>

                </div>
              </div>
          </div>
        </div>
        <!-- modal END -->
</section>
</template>

<script>
import ProfileForm from './ProfileForm.vue'
export default{
    name:"MemberProfile",
             data(){
                 return{
                     myData:'',
                     show_u_name:'',
                     user_id:'',
                     tk:'',
                     is_admin:'',
                     isDisabled:false,
                     isModalShow:'',
                     res_status:'',

                 }
             },
             components:{
                 ProfileForm,
             },
             mounted(){
                 //console.log(this.$cookies.get('token'))
                 this.tk = this.$cookies.get('token')
                 this.getMyInfo()
             },
methods:{

            getMyInfo(){
                this.myData = {}
                let url = `/api/member/profile`
                    axios.get(url,{
                             headers:{'Authorization':`Basic ${this.tk}`}
                            })
                .then(res=>{

                    let rData = res.data

//                    console.log(rData.is_admin)
                    if(rData.is_admin != 0){
                        this.isDisabled = true
                    }
                    this.user_id = window.user_id
                    this.show_u_name = res.data.name

                        })
                .catch(err=>{
                    //console.log(err.response.status)
                    if(err.response.status == 401){
                        location.href='/login'
                    }
                        })
            },
    delMyAccount(user_id){
        if(confirm(`Delete your account ${user_id}?`) == true){
            let url = `/api/member/register/${user_id}`
            axios.delete(url)
                .then(res=>{
                    this.res_status = res.data.msg

                })
            this.isModalShow = 'is-active'
            setTimeout(()=>{
                location.reload()
            },3500)
        }
        return
    },
        },
}
</script>
