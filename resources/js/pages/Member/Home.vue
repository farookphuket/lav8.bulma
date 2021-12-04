<template>
    <div>
        <section class="hero is-success is-fullheight">
          <div class="hero-body">

          </div>
        </section>
        <section class="section mt-4">
            <div class="mt-6">
                <whatnew></whatnew>
            </div>
        </section>

    </div>
</template>

<script>
import Whatnew from './Whatnew.vue'
export default {
   name:"MemberDashboard",
            components:{
                Whatnew,
            },
            data(){return{
                tk:''
            }},
            mounted(){
                this.checkPassSport()
            },
            methods:{
                checkPassSport(){
                    let url = `/api/checkpasssport`
                    axios.post(url)
                    .then(res=>{
                        //console.log(res.data)
                        if(res.data.user == false){
                            location.href='/'
                        }
                    })
                },
            },
}
</script>
