<template>
    <div class="box">
        <form action="">
            <div class="mb-4" v-show="isError">
                <div v-html="res_status">{{res_status}}</div>
            </div>
            <div class="field">
                <label class="label" for="">E-mail</label>
                <div class="control">
                    <input class="input" type="text" 
                    v-model="lForm.email" ref="email"
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

                <div class="column">
                    <div v-show="isSuccess">
                        <div v-html="res_status">{{res_status}}</div>
                    </div>
                </div>
                <div class="column is-9">
                    <div class="field is-pulled-right">

                        <button class="button is-link is-outlined is-rounded" 
                        type="submit" 
                        @click.prevent="goLogin">
                        <span class="mr-2">
                            <font-awesome-icon icon="sign-in-alt"></font-awesome-icon>
                        </span>
                        Login

                        </button>
                        <button class="button is-danger is-outlined is-rounded" 
                        >
                            <router-link :to="{name:'home'}">
                                <font-awesome-icon icon="times"></font-awesome-icon>
                            </router-link>
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
                     isError:false,
                     isSuccess:false,
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
                this.isSuccess = false
                let url = `/api/login`
                this.lForm.submit('post',url)
                .then((res)=>{
                    this.res_status = res.msg
                    this.token = res.token 
                    this.$cookies.set('token',res.token)
                    this.role_user = res.role
                    this.isSuccess = true
//                    console.log(res)
                    if(res.error != false){
 //                       console.log(res)
                        return
                    }
                    location.href=res.url

                    
                })
                .catch((err)=>{
                    this.res_status = `<span class="tag is-medium is-danger">
                    ${Object.values(err).join()}
                    </span>`
                    this.isError = true 
                    setTimeout(()=>{
                        this.res_status = ''
                        this.isError = false
                        this.$refs.email.focus()
                            },3200)
                        })
            },
            getOld(){
                //console.log(this.$cookies.get('token'))
            },
        },
}
</script>
