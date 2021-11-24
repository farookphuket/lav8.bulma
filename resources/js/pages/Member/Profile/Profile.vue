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
            <div class="column is-4">
                <div class="content">
                    <h2 class="title has-text-centered">{{show_u_name}}'s profile</h2>
                    <h3 class="subtitle">edit my profile</h3>
                    <div class="msg">
                        <p>
                            edit my profile.
                        </p>
                    </div>
                </div>
            </div>

            <div class="column is-8">
               <profile-form @getMyInfo="getMyInfo($event)"></profile-form>
            </div>
        </div>

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
                   // console.log(res.data)
                    this.show_u_name = res.data.name

                        })
                .catch(err=>{
                    //console.log(err.response.status)
                    if(err.response.status == 401){
                        location.href='/login'
                    }
                        })
            },
        },
}
</script>
