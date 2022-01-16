<template>
    <div>
        <div class="mb-6">
            <form action="">


                <!-- select template START -->
                <div class="columns">
                    <div class="column">
                        <div class="select">
                            <select id="" name="" 
                            ref="show_cat_list" v-model="pForm.category"
                            @change.prevent="setCategory">
                                <option value="0">--- Select Category ---</option>
                                <option :value="ca.id" 
                                    v-for="ca in cat_list" 
                                    >{{ca.cat_name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="column">
                        <div class="select">
                            <select ref="template" name="" 
                                @change.prevent="setTemplate">
                                <option value="0">-- Select Template --</option>
                                <option :value="tm.id" v-for="tm in template_all">
                                {{tm.t_title}}
                                </option>
                            </select>
                        </div>
                    </div>

                </div>
                <!-- select template END -->

                <div class="field">
                    <label class="label" for="">Title</label>
                    <div class="control">
                        <input v-model="pForm.p_title" class="input" 
                        type="text" name="p_title" ref="p_title" 
                        placeholder="Enter the title..."
                        @keyup.prevent="getSlug">
                    </div>
                </div>

                <!-- show slug -->
                <div class="field" v-show="isShowSlug">
                    <div class="control has-background-light pl-2">
                        <p class="subtitle has-text-success ">

                            {{theSlug.thaiSlug(pForm.p_title)}}
                            &middot; {{pForm.p_title.length}} 
                            character(s).
                        </p>
                    </div>
                </div>
                <!-- show slug -->

                <div class="field">
                    <div class="control">
                        <jodit-editor 
                        height=450 
                        v-model="pForm.p_excerpt"></jodit-editor>
                    </div>
                </div>


                <div class="field">
                    <div class="control">
                        <jodit-editor 
                        height=450 
                        v-model="pForm.p_body"></jodit-editor>
                    </div>
                </div>

                <!-- div.columns tags,new_tag START -->
                <div class="columns">
                    <div class="column is-9" >
                        <ul class="tags">
                          <li class="tag is-info is-rounded" 
                          v-for="ta in tagList">

                            <input v-model="user_select_tag" type="checkbox" 
                            name="" :value="ta.id"> 
                            <span class="ml-2">
                                <b>
                                    {{ta.tag_name}}
                                </b>
                            </span>
                          </li>  
                        </ul>
                    </div>

                    <div class="column is-3">
                        <div class="field">
                            <label class="label" for="">
                                new tage 
                                <a class="is-link is-warning" href="" 
                                title="Type in your new tag then hit Enter to save">
                                    <span class="mr-2">
                                        <font-awesome-icon icon="question"></font-awesome-icon>
                                    </span>
                                </a>

                            </label>
                            <div class="control">
                                <input v-model="pForm.new_tag" class="input" 
                                type="text" name="new_tag" 
                                placeholder="Enter new tag" 
                                ref="new_tag" @keydown.enter.prevent="addTag">
                            </div>
                            <p class="help">*type tag name then hit Enter to 
                            save</p>
                        </div>
                    </div>

                </div>
                <!-- div.columns tags,new_tag END -->

                <!-- div.columns res_status,is_public,button START -->
                <div class="columns">
                    <div class="column">
                        <div v-html="res_status">{{res_status}}</div>
                    </div>

                    <!-- checkbox START -->
                    <div class="column">

                        <div class="field">
                              <div class="control">
                                <label class="is-checkbox is-info is-rounded">
                                  <input type="checkbox" v-model="pForm.p_is_public" 
                                  name="is_public">
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
                                    @click.prevent="saveP(editId)">
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
                    <!-- checkbox END -->

                </div>
                <!-- div.columns END -->
            </form>
        </div>
    </div>
</template>

<script>
import JoditEditor from 'jodit-vue'
export default{
    name:"PostForm",
    props:["editId","template_all"],
    data(){return{
    isShowSlug:false,
    theSlug:new CustomText(),
    tagList:[],
    user_select_tag:[],
    cat_list:'',
    pForm:new Form({
        p_title:'',
        p_body:'',
        p_excerpt:'',
        p_is_public:'',
        slug:'',
        category:0,
        new_tag:'',
      }),
        res_status:'',

    }},
watch:{
          "editId":function(x){
            this.getEditData(x)
          }
      },
    mounted(){
       this.getTag() 
       this.getCategory()
    },
methods:{
            getEditData(x){
                if(x != 0){
                    this.$refs.p_title.focus()
                    this.res_status = ''
                    let url = `/api/member/post/${x}`
                    axios.get(url)
                    .then(res=>{
                        let rData = res.data.post
                        this.pForm.p_title = rData.p_title 
                        this.isShowSlug = true
                        this.pForm.p_excerpt = rData.p_excerpt 
                        this.pForm.p_body = rData.p_body 
                        this.pForm.slug = rData.slug
                        if(rData.p_is_public != 0) this.pForm.p_is_public = true

                        rData.tag.forEach((val)=>{
                            this.user_select_tag.push(val.pivot.tag_id)
                        }) 

                        rData.category.forEach((ca)=>{
                            //console.log(ca.cat_name)
                            this.pForm.category = ca.id
                        })

                    })
                }
            },
            saveP(id){
                let url = `/api/member/post`
                let fData = {
                    p_title:this.pForm.p_title,
                    p_excerpt:this.pForm.p_excerpt,
                    p_body:this.pForm.p_body,
                    p_is_public:this.pForm.p_is_public,
                    slug:this.pForm.slug,
                    category:this.pForm.category,
                    tags:this.user_select_tag
                } 

                if(id){
                    url = `/api/member/post/${id}`

                    axios.put(url,fData)
                    .then(res=>{
                        this.res_status = res.data.msg

                        setTimeout(()=>{
                            this.clearForm()
                            this.$emit('getPost')
                        },2000)
                    })
                    .catch(err=>{
                        this.res_status = `<span class="tag is-danger is-medium">
                            ${Object.values(err.response.data.errors).join()}
                        </span>`
                    })
                }else{

                    axios.post(url,fData)
                    .then(res=>{
                        this.res_status = res.data.msg
                        setTimeout(()=>{
                            this.clearForm()
                            this.$emit('getPost')
                        },2000)
                    })
                    .catch(err=>{
                        this.res_status = `<span class="tag is-danger is-medium">
                            ${Object.values(err.response.data.errors).join()}
                        </span>`
                    })

                }
            },
            getSlug(){
               this.isShowSlug = false 
               if(this.$refs.p_title.value != ''){
                    this.isShowSlug = true
                    this.pForm.slug = this.theSlug.thaiSlug(this.$refs.p_title.value)
               }
            },
            getTag(){
                let url = `/api/tag`
                axios.get(url)
                .then(res=>{
                    this.tagList = res.data.tag_all
        //            console.log(res.data)
                        })
            },
            addTag(){
                let nTag = this.$refs.new_tag.value
                this.pForm.new_tag = ''
                if(nTag != ''){
                   let url = `/api/member/tag` 
                   let data = { new_tag: nTag }
                   axios.post(url,data)
                       .then(res=>{
                        this.res_status = res.data.msg
                            setTimeout(()=>{
                                this.res_status = ''
                                this.getTag()
                            },700)
                        })
                   .catch(err=>{
                        this.res_status = `<span class="tag is-medium is-danger">
                        ${Object.values(err.response.data.errors).join()}
                        </span>`
                           })
                }
            },
            getCategory(){
                this.cat_list = []
                let url = `/api/category`
                axios.get(url)
                .then(res=>{
                    this.cat_list = res.data.category
                })
            },
            setCategory(){
                //alert(this.$refs.show_cat_list.value)
                let cat = this.$refs.show_cat_list.value
                this.pForm.category = this.$refs.show_cat_list.value
                //console.log(`set the category to ${cat}`)
            },
            clearForm(){
                this.pForm.reset()
                this.res_status = ''
                this.user_select_tag = []
            },
            setTemplate(){
                //alert(`the template ${this.$refs.template.value}`)
                let url = `/api/member/template/${this.$refs.template.value}`
                axios.get(url)
                .then(res=>{
                    let rData = res.data.template       
                    this.$refs.p_title.focus()
                    this.pForm.p_title = rData.t_title+" [Edit Template]"
                    this.pForm.p_excerpt = rData.t_excerpt

                    this.isShowSlug = true
                })
            },
        },
}
</script>
