<template>
    <div class="box">
        <form action="">
            <div class="field">

                <label class="label" for="">E-mail</label>
                <div class="control">
                    <input class="input" type="text" 
                    v-model="lForm.email"
                    name="email" placeholder="Email...">
                </div>
            </div>

            <div class="field">

                <label class="label" for="">Password</label>
                <div class="control">
                    <input class="input" type="password" 
                   v-model="lForm.password" 
                    name="password" placeholder="~~~~~~">
                </div>
            </div>


            <div class="columns">
                <div class="column is-8">
                    <div v-html="res_status">{{res_status}}</div>
                </div>
                <div class="column is-4">
                    <div class="is-grouped is-grouped-right">

                        <button class="button is-link" 
                        type="submit" 
                        @click.prevent="goLogin">Login</button>
                        <button class="button is-link is-outlined is-light" 
                        >
                            <router-link :to="{name:'home'}">Cancel</router-link>
                        </button>
                    </div>
                </div>
            </div>
            <!-- status START -->
            <!-- status END -->
        </form>
    </div>
</template>



<script>
export default{
    name:"LoginForm",
             data(){
                 return{
                     res_status:'',
                     token:'',
                     role_user:'',
                     err:false,
                    lForm:new Form({
                        email:'',
                        password:''
                    }),
                 }
             },
             mounted(){
                 this.getOld()
             },
methods:{
            goLogin(){
                this.res_status = ''
                let url = `/api/login`
                this.lForm.submit('post',url)
                .then((res)=>{
                    this.res_status = res.msg
                    this.token = res.token 
                    this.$cookies.set('token',res.token)
                    this.role_user = res.role
                    if(res.error != false){
                     //   console.log(res)
                        return
                    }
                    location.href=res.url

                    
                        })
                .catch((err)=>{
                    this.res_status = `<span class="tag is-medium is-danger">
                    ${Object.values(err).join()}
                    </span>`
                        })
            },
            getOld(){
                //console.log(this.$cookies.get('token'))
            },
        },
}
</script>
