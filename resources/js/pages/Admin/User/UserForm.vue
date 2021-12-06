<template>
    <div class="mb-4">
       <form action="" >
            <div class="field">
                <div class="control">
                    <input v-model="uForm.name" class="input" type="text" name="" 
                    placeholder="user name...">
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input v-model="uForm.email" class="input" type="email" name="" 
                    placeholder="user email...">
                </div>
            </div>
            
            <div class="field">
                <div class="control">
                    <input v-model="uForm.password" class="input" type="password" name="" 
                    placeholder="~~~~~~">
                </div>
            </div>
                <div class="columns">

                    <!-- res_status,role START -->
                        <div class="column">
                            <div class="field is-pulled-left">
                                <div class="pl-2" v-html="res_status">{{res_status}}</div>
                            </div>
                            <div class="field is-pulled-right">
                              <div class="control">
                              <label class="is-checkbox is-warning is-rounded" 
                              v-for="r in user_roles">
                                  <input type="checkbox" v-model="user_select_roles" 
                                  :value="r.id" name="user_roles">
                                    <span  class="icon is-medium checkmark">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <span>
                                        {{r.role_name}}
                                    </span>

                                </label>
                                <button class="button is-outlined is-info" 
                                type="submit" 
                                @click.prevent="saveU(editId)">
                                    <font-awesome-icon icon="check"></font-awesome-icon>
                                </button>
                                <button class="button is-danger is-outlined" 
                                @click.prevent="$emit('closeForm')">
                                    <font-awesome-icon icon="hand-middle-finger"></font-awesome-icon>
                                </button>
                              </div>

                            </div>
                        </div>
            <!-- res_status,role START -->

            
                </div>

       </form>
    </div>
</template>
<script>
export default{
    name:"UserForm",
    props:['editId'],
             data(){return{
                 res_status:'',
                 user_roles:[],
                 user_select_roles:[],
                uForm:new Form({
                    name:'',
                    email:'',
                    password:'',

                }),
             }},
             mounted(){
                this.getRole()
             },
    watch:{
        "editId":function(x){
            this.getEditData(x)
        }
    },
methods:{
    getEditData(x){
        if(x != 0){
            this.uForm.reset()
            this.res_status = ''
            this.user_select_roles = []
            let url = `/api/admin/user/${x}`
            axios.get(url)
                .then(res=>{
                    let rData = res.data.user 
                    this.uForm.name = rData.name
                    this.uForm.email = rData.email

                    rData.role.forEach((val)=>{
                        this.user_select_roles.push(val.id)
                        console.log(val.id)

                    })


                })
        }
    },
            getRole(){

                let url = `/api/admin/getrole`
                axios.get(url)
                .then(res=>{
                //    console.log(res.data)
                    this.user_roles = res.data.role
                        })
            },
    /*
            this method not working when submit with 2 roles
            saveUser(id){
                let url = '/api/admin/user'
                let fData = new FormData()
                fData.append("user_roles",this.user_select_roles)
                fData.append("name",this.uForm.name)
                fData.append("email",this.uForm.email)
                fData.append("password",this.uForm.password)

                if(id && id != 0){
                    url = `/api/admin/user/${id}`
                    fData.append("_method","PUT")
                }
                axios.post(url,fData,)
                    .then(res=>{
                        this.res_status = res.data.msg
                        this.clearForm()
                        setTimeout(()=>{
                            this.$emit('getUser')
                        },2500)
                            })
                .catch(err=>{
                    this.res_status = `<span class="tag is-medium is-danger">
                    ${Object.values(err.response.data.errors).join()} 
                    </span>`
                        })
            },
    */
    saveU(id){
        let data = {
           user_roles:this.user_select_roles,
            name:this.uForm.name,
            email:this.uForm.email,
            password:this.uForm.password
        }
        let url = `/api/admin/user`
        if(id && id != 0){
            url = `/api/admin/user/${id}`
            axios.put(url,data)
                .then(res=>{
                    //console.log(res.data)
                    this.res_status = res.data.msg
                    
                    setTimeout(()=>{
                        this.clearForm()
                        this.$emit('getUser')
                    },750)
                })
                .catch(err=>{
                    this.res_status = `<span class="tag is-medium is-danger">
                        ${Object.values(err.response.data.errors).join()}
                    </span>`
                })
        }else{
            axios.post(url,data)
                .then(res=>{
                    //console.log(res.data)
                    this.res_status = res.data.msg
                    setTimeout(()=>{
                        this.clearForm()
                        this.$emit('getUser')
                    },750)
                })
                .catch(err=>{
                    this.res_status = `<span class="tag is-medium is-danger">
                        ${Object.values(err.response.data.errors).join()}
                    </span>`
                })
        }
    },
    clearForm(){
        this.res_status = ''
        this.uForm.reset()
        this.user_select_roles = []

    },
        },

}
</script>
