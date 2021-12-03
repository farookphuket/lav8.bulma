<template>
    <div>
        <div class="card">

            <div class="card-content">

            <form action="">

                <div class="field">
                    <label for="" class="label">Title</label>
                    <div class="control">
                        <input v-model="wnForm.wn_title" class="input" 
                        placeholder="title..."
                        type="text" name="" ref="wn_title">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="">what in your mind</label>
                    <div class="control" >
                        <jodit-editor 
                        v-model="wnForm.wn_body" 
                        height=450></jodit-editor>
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-8">
                        <div class="content" v-html="res_status">
                            {{res_status}}
                        </div>
                    </div>
                    <div class="column is-4">
                        <div class="field">

                              <div class="control">
                                <label class="is-checkbox is-info is-rounded">
                                  <input type="checkbox" v-model="wnForm.is_public">
                                    <span  class="icon is-large checkmark">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <span>
                                        Public Post
                                    </span>

                                </label>


                        <div class="is-pulled-right">

                            <button class="button is-link is-outlined" 
                            type="submit"
                            @click.prevent="saveWn(editId)">
                                <font-awesome-icon icon="check-circle">
                                </font-awesome-icon>
                            </button>

                            <button class="button is-outlined is-danger" 
                            @click.prevent="$emit('formToggle')">
                                <font-awesome-icon icon="hand-middle-finger">
                                </font-awesome-icon>
                            </button>
                        </div>
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
                     isShow:'',
                     res_status:"",
                    wnForm:new Form({
                        wn_body:'',
                        wn_title:'',
                        is_public:'',
                        }),
                    }
             },
             methods:{
                         saveWn(id){
                             let url = `/api/member/whatnew`
                             let fData = new FormData()
                             fData.append('wn_title',this.wnForm.wn_title)
                             fData.append('wn_body',this.wnForm.wn_body)
                             fData.append('is_public',this.wnForm.is_public)

                             if(id){
                                 fData.append("_method","PUT")
                                 url = `/api/member/whatnew/${id}`
                             }
                            axios.post(url,fData)
                                .then(res=>{
                                    console.log(res.data)
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
