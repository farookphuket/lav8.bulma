<template>

    <section class="section">
            <nav class="breadcrumb" aria-label="breadcrumbs">
              <ul>
                <li class="is-active">
                    <a href="/admin/home">Home</a>
                </li>
              </ul>
            </nav>
            <whatnew></whatnew>
    </section>
</template>

<script>
import Whatnew from './Whatnew/Whatnew.vue'
export default{
    name:"AdminDashboard",
             components:{
                 Whatnew,
             },
             data(){return{
                 tk:''
             }},
             mounted(){
                 this.tk = this.$cookies.get('token')
                 this.checkPassSport()
             },
methods:{
            checkPassSport(){
                let url = `/api/checkpasssport`
                    axios.post(url,{
                        headers:{"Authorization":`Basic ${this.tk}`}
                            })
                .then(res=>{
                    let rD = res.data 
                    if(rD.user_obj == null){
                        location.href='/login'
                        return
                    }
                        })
            }
        },
}
</script>
