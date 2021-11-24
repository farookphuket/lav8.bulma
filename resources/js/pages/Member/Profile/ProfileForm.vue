<template>
<div class="container">
    <form action="">
        <div class="field">
            <label class="label" for="">Name</label>
            <div class="control">
                <input id="" class="input" type="text" 
                name="" v-model="pForm.name">
            </div>
        </div>

        <div class="field">
            <label class="label" for="">Email</label>
            <div class="control">
                <input  class="input" type="email" 
                name="email" v-model="pForm.email">
            </div>
        </div>

        <div class="field">
            <label class="label" for="">New Password</label>
            <div class="control">
                <input v-model="pForm.new_pass" class="input" type="password" 
                placeholder="~~~~~~">

                <p class="tag mt-2 is-medium is-warning">
                    if you do not want to change your password just leave this 
                        field blank!
                </p>
            </div>

        </div>

        
        
            <div class="columns">
                <div class="column is-8">
                    <div v-html="res_status">{{res_status}}</div>
                </div>
                <div class="column is-4">
                    <div class="buttons has-addons is-right">

                        <button class="button is-link" 
                        type="submit" 
                        @click.prevent="check">Save</button>
                    </div>
                </div>
            </div>
    </form>

    <!-- modal confirm START -->
    <div class="modal" :class="{'is-active':active}">
      <div class="modal-background"></div>
      <div class="modal-content">
        <!-- Any other Bulma elements you want -->

        <div class="box">
            <div class="field">
                <label class="label" for="">Confirm Password</label>
                <div class="control">
                    <input v-model="pForm.conf_pass" class="input" type="password" 
                    placeholder="* Please confirm your current password" 
                    ref="conf_pass"
                    @keyup.enter.prevent="sendKey">

                    <p class="tag mt-2 is-medium is-danger">
                        please Enter your current password in order to save the 
                        change.
                    </p>
                </div>
            </div>

            <span class="tag is-medium has-text-centered" v-html="res_status">
                {{res_status}}
            </span>
            <div class="buttons is-right">
                <button class="button is-primary is-outlined" 
                @click.prevent="sendKey">
                    send
                </button>

                <button class="button is-danger is-outlined" 
                @click.prevent="active=''">
                    cancel
                </button>
            </div>
        </div>

      </div>
      <button class="modal-close is-large" aria-label="close" 
      @click.prevent="active=''"></button>
    </div>

    <!-- modal confirm END -->
</div>

</template>
<script>
export default{
    name:"ProfileForm",
    props:["mydata","user_id"],
    data(){
        return{
            tk:'',
            res_status:'',
            active:'',
            res_error:0,
            pForm:new Form({
                name:'',
                email:'',
                new_pass:'',
                conf_pass:''
                          }),
        }
    },
    mounted(){
        this.tk = this.$cookies.get('token')
        this.getInfoData()
    },
methods:{
            getInfoData(){
                let url = `/api/member/profile/${window.user_id}`
                    axios.get(url,{
                        headers:{'Authorization':`Basic ${this.tk}`}
                            })
                .then(res=>{
                    //console.log(res.data)
                    let rData = res.data.user 
                    this.pForm.name = rData.name
                    this.pForm.email = rData.email
                        })

            },
            check(){
                this.active = 'is-active'
                setTimeout(()=>{
                    this.$refs.conf_pass.focus()
                        },500)
            },
            sendKey(){
                this.res_error = 0
                let url = `/api/member/check-confirm-key`
                let fData = {conf_pass:this.pForm.conf_pass}
                axios.post(url,fData,{
                    headers:{'Authorization':`Basic ${this.tk}`}
                        })
                .then(res=>{
                    //console.log(res.data)
                    this.res_status = res.data.msg
                    this.active = ''
                    this.res_error = parseInt(res.data.error)
                    if(this.res_error != 0){
                        this.check()
                        return
                    } 
                    this.profileSave()
                    //console.log(this.res_error) 

                        })
                .catch((err)=>{
                    //console.log(Object.values(err.response.data.errors).join())
                    this.res_status = `<span class="tag is-medium is-danger">
                    ${Object.values(err.response.data.errors).join()}
                    </span>`
                        })
            },
            profileSave(){
                this.res_status = ''
                let url = `/api/member/profile/${window.user_id}`
                    this.pForm.submit('put',url,{
                        headers:{'Authorization':`Basic ${this.tk}`}
                            })
                .then((res)=>{
                    //console.log(res.msg)
                    this.res_status = res.msg
                    setTimeout(()=>{
                        this.renew()
                            },3200)
                        })
                .catch((err)=>{
                    this.res_status = `<span class="tag is-medium is-danger">
                    ${Object.values(err).join()}</span>`
                        })
            },
            renew(){
                this.res_status = ''
                this.getInfoData()
                this.$emit('getMyInfo') 
            },
        },
}
</script>
