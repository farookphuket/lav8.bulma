<template>
    <div>
        <div class="card">
            <div class="card-content">
                <form action="">
                    <div class="field">
                        <div class="control">
                            <input v-model="pForm.p_title" class="input" 
                            type="text" ref="p_title" @keyup.prevent="getSlug"
                            placeholder="Title...">

                            <p class="mt-4">{{theSlug.thaiSlug(pForm.p_title)}}</p>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <jodit-editor 
                            v-model="pForm.p_excerpt" height=450></jodit-editor>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <jodit-editor 
                            v-model="pForm.p_body" height=450></jodit-editor>
                        </div>
                    </div>

                    <div class="columns">

                        <div class="column is-9">
                            <div class="tags">
                                <span class="tag is-medium is-rounded is-info">
                                    <input id="" type="checkbox" name=""> 
                                    <span class="ml-2">tag 1</span>
                                </span>
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="field">
                                <label class="label" for="">New Tag</label>
                                <div class="control">
                                    <input v-model="pForm.new_tag" 
                                    class="input" type="text" name="" 
                                    placeholder="Enter new tag..."
                                    ref="new_tag">
                                </div>
                            </div>
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
                                  <input type="checkbox" v-model="pForm.p_is_public">
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
                                    @click.prevent="savePost(editId)">Post</button>
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
    name:"PostForm",
    props:["editId"],
    data(){return{
        res_status:'',

        theSlug:new CustomText(),
        pForm:new Form({
           p_title:'',
           slug:'',
           p_excerpt:'',
           p_body:'',
           p_is_public:0,
            new_tag:'',   
        }),
    }},
    mounted(){


    },
    methods:{
         savePost(id){
             this.res_status = ''
             let url = `/api/admin/post`
             let fData = new FormData()
             fData.append("p_title",this.pForm.p_title)
             fData.append("slug",this.pForm.slug)
             fData.append("p_excerpt",this.pForm.p_excerpt)
             fData.append("p_body",this.pForm.p_body)
             fData.append("p_is_public",this.pForm.p_is_public)
             if(id){
                 url = `/api/admin/post/${id}`
                 fData.append("_method","PUT")
             }
             axios.post(url,fData)
                 .then(res=>{
                     console.log(res.data)
                     this.res_status = res.data.msg 
                     setTimeout(()=>{
                         this.getClear()
                             },3200)
                         })
             .catch(err=>{
                 this.res_status = `<span class="tag is-medium is-danger">
                    ${Object.values(err.response.data.errors).join()}
                 </span>`
                     })
         },
         getSlug(){
            this.pForm.slug = this.theSlug.thaiSlug(this.$refs.p_title.value)
         },
         getClear(){
             this.res_status = ''
             this.pForm.reset()
             this.$emit('getPost')
         },
    },
}
</script>
