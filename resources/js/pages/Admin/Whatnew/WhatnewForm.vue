<template>
    <div>
        <div class="card">
            <div class="card-content">
                <form action="">
                    <div class="field">

                        <div class="control">
                            <input v-model="wForm.wn_title" class="input" 
                            type="text" placeholder="Title..."
                            >
                        </div>
                    </div>


                    <div class="field">

                        <div class="control">
                            <jodit-editor height=450 
                            v-model="wForm.wn_body"></jodit-editor>
                        </div>
                    </div>


                    <div class="columns">
                        <div class="column">
                            <div v-html="res_status">{{res_status}}</div>
                        </div>
                        <div class="column">
                            <div class="field">
                              <div class="control">
                                <label class="is-checkbox is-info is-rounded">
                                  <input type="checkbox" v-model="wForm.is_public">
                                    <span  class="icon is-large checkmark">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <span>
                                        Public Post
                                    </span>

                                </label>
                              </div>
                            </div>
                        </div>

                        <div class="column">

                            <div class="field is-grouped is-grouped-right">

                                <div class="buttons ">
                                    <button class="button is-outlined 
                                    is-primary" type="submit" 
                                    @click.prevent="saveWn">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</template>
<script>
import JoditEditor from 'jodit-vue'
export default{
    name:"WhatnewForm",
             data(){
                 return{
                    wForm:new Form({
                        wn_title:'',
                        wn_body:'',
                        is_public:0,
                    }),
                    res_status:'',
                    tk:'',
                 }
             },
             mounted(){
                 this.tk = this.$cookies.get("token")
             },
methods:{
            saveWn(){
                let url = `/api/admin/whatnew`
                let fData = this.wForm
                    axios.post(url,fData,{
                        headers:{"Authorization":`Basic ${this.tk}`}
                            }) 
                .then(res=>{
                    //console.log(res.data)
                    this.res_status = res.data.msg
                    setTimeout(()=>{this.$emit('getWhatnew')},3200)
                    this.getClear()
                        })
                .catch(err=>{
                    //console.log(err.response.data)
                    this.res_status = `<span class="tag is-medium is-danger">
                    ${Object.values(err.response.data.errors).join()}
                    </span>`
                        })

            },
            getClear(){
                this.wForm.reset()
                this.res_status = ''
            },
        },
}
</script>
