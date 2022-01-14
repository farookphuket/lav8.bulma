<template>
    <div>
        <div>
            <form action="">
                <div class="field">
                   <div class="control">
                        <input v-model="tForm.t_title" 
                        class="input" type="text" name="">
                   </div>
                </div>

                <div class="field">
                   <div class="control">
                        <input v-model="tForm.t_method" 
                        class="input" type="text" name="">
                   </div>
                </div>

                <div class="field">
                   <div class="control">
                        <jodit-editor 
                        v-model="tForm.t_excerpt" 
                        height="450"></jodit-editor>
                   </div>
                </div>


                <div class="field">
                   <div class="control">
                        <jodit-editor 
                        v-model="tForm.t_body" 
                        height="450"></jodit-editor>
                   </div>
                </div>

                <!-- div.columns status,button START -->
                <div class="columns">
                    <div class="column is-4">
                        <div v-html="res_status">{{res_status}}</div>
                    </div>
                    <div class="column is-8">
                        <div class="field is-pulled-right">
                            <button class="button is-primary" 
                            type="submit" 
                            @click.prevent="saveT(editId)">
                                <font-awesome-icon icon="check"></font-awesome-icon>
                            </button>
                        </div>

                    </div>
                </div>
                <!-- div.columns status,button END -->

            </form>
        </div>
    </div>
</template>
<script>
import JoditEditor from 'jodit-vue'
export default{
    name:"TemplateForm",
    props:["editId"],
     data(){return{
         res_status:'',
        tForm:new Form({
            t_title:'',
            t_method:'',
            t_excerpt:'',
            t_body:'',

        }),

     }},
watch:{
          "editId":function(x){
              this.getEditData(x)
          }
      },
methods:{
            getEditData(x){
                alert(x)
            },
            saveT(id){
                let url = `/api/admin/template`
                let fData = new FormData()
                fData.append('t_title',this.tForm.t_title)
                fData.append('t_method',this.tForm.t_method)
                fData.append('t_excerpt',this.tForm.t_excerpt)
                fData.append('t_body',this.tForm.t_body)

                if(id && id != 0){
                    fData.append("_method","PUT")
                    url = `/api/admin/template/${id}`
                }

                axios.post(url,fData)
                    .then(res=>{
                        this.res_status = res.data.msg
                        setTimeout(()=>{
                            this.$emit('getTemplate')
                                },2500)
                            })
                .catch(err=>{
                    this.res_status = `<span class="tag is-medium 
                    is-danger">
                    ${Object.values(err.response.data.errors).join()}
                    </span>`
                        })
            },
        },
}
</script>
