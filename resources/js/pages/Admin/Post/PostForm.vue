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

                        </div>
                    </div>
                    <div class="field">
                        <div class="tag is-medium is-success" v-show="isSlug">
                            <p class="mt-4 mb-4" >{{theSlug.thaiSlug(pForm.p_title)}}</p>
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
                                <span class="tag is-medium is-rounded is-info" 
                                v-for="ta in tag_all">
                                    <input v-model="user_select_tag" type="checkbox" 
                                    name="" :value="ta.id"> 
                                    <span class="ml-2">{{ta.tag_name}}</span>
                                </span>
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="field">
                                <label class="label" for="">
                                    <span class="mr-4">
                                        New Tag 
                                    </span>
                                </label>
                                <div class="control">
                                    <input v-model="pForm.new_tag" 
                                    class="input" type="text" name="" 
                                    placeholder="hit Enter to save"
                                    ref="new_tag" @keypress.enter.prevent="addTag">
                                    <div class="help is-success">

                                        <span class="icon is-pulled-right">
                                            <span>
                                            <a href="" class="tag is-bold" title="Enter the tag then hit enter to create you can leave this field blank">
                                                WTF
                                            </a>
                                            </span>
                                            <span class="icon-text">
                                                <font-awesome-icon icon="question"></font-awesome-icon>
                                            </span>

                                        </span>
                                    </div>
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
                                    @click.prevent="saveP(editId)">Post</button>
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
        isSlug:false,
        tag_all:'',
        user_select_tag:[],
        tag_with_post:'',
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
watch:{
          "editId":function(x){
            this.getEditData(x)
          }
      },
    mounted(){
        this.getTag()

    },
    methods:{

    /*
         savePost(id){
             this.res_status = ''
             let url = `/api/admin/post`
             let fData = new FormData()
             fData.append("p_title",this.pForm.p_title)
             fData.append("slug",this.pForm.slug)
             fData.append("p_excerpt",this.pForm.p_excerpt)
             fData.append("p_body",this.pForm.p_body)
             fData.append("p_is_public",this.pForm.p_is_public)
             fData.append("tags",this.user_select_tag)
             if(id){
                 url = `/api/admin/post/${id}`
                 fData.append("_method","PUT")
             }
             axios.post(url,fData)
                 .then(res=>{
                    // console.log(res.data)
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
         */
                getEditData(x){
                    if(x != 0){
                        this.user_select_tag = []
                        this.$refs.p_title.focus()
                        let url = `/api/admin/post/${x}`
                        axios.get(url)
                        .then(res=>{

                            let rData = res.data.post
                            this.pForm.p_title = rData.p_title
                            this.pForm.p_excerpt = rData.p_excerpt
                            this.pForm.p_body = rData.p_body
                            this.isSlug = true
                            if(rData.p_is_public != 0) this.pForm.p_is_public = true
                            rData.tag.forEach((val)=>{
                                //console.log(val)
                                this.user_select_tag.push(val.pivot.tag_id)
                                    })
                                })
                    }
                },
         saveP(id){
            let url = `/api/admin/post`
                let fData = {
                   p_title:this.pForm.p_title,
                   p_excerpt:this.pForm.p_excerpt,
                   p_body:this.pForm.p_body,
                   slug:this.pForm.slug,
                   p_is_public:this.pForm.p_is_public,
                   tags:this.user_select_tag,
                }
            if(id){
                url = `/api/admin/post/${id}`
                axios.put(url,fData)
                .then(res=>{
                    this.res_status = res.data.msg
                    setTimeout(()=>{
                        this.getClear()
                        this.$emit('getPost')
                    },1500)
                })
                .catch(err=>{
                     this.res_status = `<span class="tag is-medium is-danger">
                        ${Object.values(err.response.data.errors).join()}
                     </span>`
                })
            }else{

                axios.post(url,fData)
                .then(res=>{
                    this.res_status = res.data.msg
                    setTimeout(()=>{
                        this.getClear()

                        this.$emit('getPost')
                    },1500)
                })
                .catch(err=>{
                     this.res_status = `<span class="tag is-medium is-danger">
                        ${Object.values(err.response.data.errors).join()}
                     </span>`
                })
            }
         },
         getSlug(){
             this.isSlug = false
            this.pForm.slug = this.theSlug.thaiSlug(this.$refs.p_title.value)
            if(this.$refs.p_title.value != '') this.isSlug = true
         },
         getClear(){
             this.res_status = ''
                this.isSlug = false
            this.user_select_tag = []
             this.pForm.reset()
         },
         getTag(){
            this.res_status = ''
             this.$refs.new_tag.value = ''
             let url = `/api/tag`
             axios.get(url)
             .then(res=>{
                 //console.log(res.data)
                 let tag_all = res.data.tag_all 
                 let tag_post = res.data.tag_with_post
                    this.tag_all = tag_all
                     })
         },
         addTag(){
             this.res_status = ''

             if(this.$refs.new_tag.value != ''){
                 //alert(`will be ${this.$refs.new_tag.value}`)
                 let url = `/api/admin/tag`
                 let fData = new FormData()
                 fData.append("new_tag",this.$refs.new_tag.value)
                 axios.post(url,fData)
                 .then(res=>{
                   //  console.log(res.data)
                     this.res_status = res.data.msg
                     setTimeout(()=>{

                         this.$refs.p_title.focus()
                         this.getTag()
                             },3200)
                         })
                 .catch(err=>{
                     this.res_status = `<span class="tag is-medium is-danger">
                     ${Object.values(err.response.data.errors).join()}</span>`
                     setTimeout(()=>{
                        this.res_status = ''
                             },5200)
                         })
             }
         },
    },
}
</script>
