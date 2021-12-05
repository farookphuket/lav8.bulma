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
                                  :value="r.id">
                                    <span  class="icon is-medium checkmark">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <span>
                                        {{r.role_name}}
                                    </span>

                                </label>
                                <button class="button is-outlined is-info" 
                                type="submit" 
                                @click.prevent="saveUser(editId)">
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
methods:{
            getRole(){

                let url = `/api/admin/getrole`
                axios.get(url)
                .then(res=>{
                //    console.log(res.data)
                    this.user_roles = res.data.role
                        })
            },
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
                            })
                .catch(err=>{
                    this.res_status = `<span class="tag is-medium is-danger">
                    ${Object.values(err.response.data.errors).join()} 
                    </span>`
                        })
            },
        },

}
</script>
