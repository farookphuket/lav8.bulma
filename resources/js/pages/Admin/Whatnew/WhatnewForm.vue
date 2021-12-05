<template>
    <div>
        <div class="card">
            <div class="card-content">
                <form action="">
                    <div class="field">

                        <div class="control">
                            <input v-model="wForm.wn_title" class="input" 
                            type="text" placeholder="Title..." ref="title"
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

                        <div class="column ">

                            <div class="field is-grouped is-grouped-right pb-4">

                                <div class="buttons ">
                                    <button class="button is-outlined 
                                    is-primary" type="submit" 
                                    @click.prevent="saveWn(editId)">Post</button>
                                    <button class="button is-danger is-outlined" 
                                    @click.prevent="$emit('closeForm')">
                                        <font-awesome-icon icon="times-circle"></font-awesome-icon>
                                    </button>
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
    props:["editId"],
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
watch:{
          "editId":function(x){
              this.getEditData(x)
          }
      },
methods:{
            getEditData(x){
                if(x == 0) return
                this.wForm.is_public = false 
                this.$refs.title.focus()
                let url = `/api/admin/whatnew/${x}`
                axios.get(url)
                .then(res=>{
                    let rForm = res.data.whatnew 
                    this.wForm.wn_title = rForm.wn_title 
                    this.wForm.wn_body = rForm.wn_body 
                    if(rForm.is_public != 0) this.wForm.is_public = true
                        })
                

            },
            saveWn(id){
                let url = `/api/admin/whatnew`
                let fData = new FormData()
                    fData.append('wn_title',this.wForm.wn_title)
                    fData.append('wn_body',this.wForm.wn_body)
                    fData.append('is_public',this.wForm.is_public)

                    if(id){
                        url = `/api/admin/whatnew/${id}`
                        fData.append("_method","PUT")
                    }
                    axios.post(url,fData,{
                        headers:{"Authorization":`Basic ${this.tk}`}
                            }) 
                .then(res=>{
                    //console.log(res.data)
                    this.res_status = res.data.msg
                    setTimeout(()=>{

                        this.getClear()
                            },3200)

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

                this.$emit('getWhatnew')
            },
        },
}
</script>
