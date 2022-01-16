<template>
    <div>

        <section class="section">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                  <ul>
                    <li class="is-active">
                        <a href="/member/home">Home</a>
                    </li>
                  </ul>
                </nav>
        </section>

        <section class="section mt-4">

           <div class="columns">
               <div class="column is-3">
                    <a class="button is-primary is-block is-alt" href="#" 
                    @click.prevent="isFormOpen = true">New Post</a>

                    <aside class="mt-4 menu">
                        <div class="box mb-2">
                            <p class="title">
                            Category 
                                <span>
                                    <font-awesome-icon icon="bookmark">
                                    </font-awesome-icon>
                                </span>
                            </p>
                            <ul class="tags">
                                <li class="tag is-primary is-medium" v-for="ca in catHasContent">
                                    <span class="mr-2">{{ca.cat_name}}</span>
                                    <span >
                                        ({{Object.values(ca.post).length}})
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="box">
                            <p class="title">Tag 
                                <span class="ml-2">
                                    <font-awesome-icon icon="tag"></font-awesome-icon>
                                </span>
                            </p>

                            <ul class="tags">
                                <li class="tag is-info is-medium" v-for="ca in tagHasContent">
                                    <span class="mr-2">
                                        <a href="" @click.prevent="getByTag(ca.id)">
                                            {{ca.tag_name}}
                                        </a>
                                    </span>
                                    <span >
                                        ({{Object.values(ca.post).length}})
                                    </span>
                                </li>
                            </ul>
                        </div>


                    </aside>
               </div>
               <div class="column is-9">
                    <post-form :editId="editId" v-show="isFormOpen" 
                    @getPost="getPost($event)" :template_all="template_all"
                    @formToggle="formToggle($event)"></post-form>

                    <by-tag v-show="isShowByTag" 
                    @getPost="getPost($event)"
                    :tagId="tagId"></by-tag>

                   <post-list v-show="isShowDefaultList"
                   :postList="postList" @edit="edit($event)" 
                   @del="del($event)" @getPost="getPost($event)" ></post-list>

                <!-- show tag START -->
                   <div class="field mt-4 mb-4 is-pulled-left">
                        <ul class="tags">
                            <li class="tag is-medium is-primary" v-for="ca in catHasContent">
                                <span class="mr-2">
                                    <font-awesome-icon icon="bookmark">
                                    </font-awesome-icon>
                                </span>
                                <span>
                                    {{ca.cat_name}} 
                                </span>
                                <span class="ml-1">
                                    ({{Object.values(ca.post).length}})
                                </span>
                            </li>
                        </ul>
                   </div>
                   <div class="field mt-4 mb-4 is-pulled-right">
                        <ul class="tags">
                            <li class="tag is-info is-medium" v-for="ta in tagHasContent">
                                <span class="mr-2">
                                    <font-awesome-icon icon="tag"></font-awesome-icon>
                                </span>
                                <span>
                                    {{ta.tag_name}}
                                </span>
                                <span class="ml-2">
                                    ({{Object.values(ta.post).length}})
                                </span>
                            </li>
                        </ul>
                   </div>
                <!-- show tag START -->

               </div>
           </div>
        </section>


        <div class="modal" :class="{'is-active':isModalOpen}">
          <div class="modal-background"></div>
          <div class="modal-content">
            <div class="content box">
                <div v-html="res_status" class="mb-6">{{res_status}}</div>
            </div>
          </div>
          <button class="modal-close is-large" aria-label="close" 
          @click.prevent="isModalOpen = ''"></button>

            <button class="button is-success is-outlined " 
            @click.prevent="isModalOpen=''">
                <font-awesome-icon icon="check"></font-awesome-icon>
            </button>

        </div>


    </div>
</template>
<script>
import ByTag from './ByTag.vue'
import PostForm from './PostForm.vue'
import PostList from './PostList.vue'
export default{
name:"MPost",
         components:{
            PostForm,
            PostList,
            ByTag,
         },
         data(){return{
            editId:'',
            postList:'',
             template_all:'',
            post_with_category:'',
            res_status:'',
            isShowDefaultList:true,
            isShowByTag:false,
            tagId:0,
            isShowByCat:false,
            isFormOpen:false,
            isModalOpen:'',
            tagHasContent:'',
            catHasContent:'',
         }},
         mounted(){
            this.getPost()
         },
methods:{
            getPost(page){
                this.clearSet()
                let url = ''
                    if(page){
                        url = page 
                        this.$cookies.set('mpost_old_page',url)
                    }
                    url = this.$cookies.get('mpost_old_page')
                    if(!url) url = `/api/member/getpost`
                    axios.get(url)
                        .then(res=>{
                        //console.log(res.data)
                        this.postList = res.data.post
                        this.post_with_category = res.data.post_with_category

                        this.template_all = res.data.template
                        // show the tag and post
                        this.catHasContent = res.data.cp 
                        this.tagHasContent = res.data.ta
                        document.title = res.data.meta_title
                    })
            },
            getByTag(id){
                this.isShowDefaultList = false
                this.isShowByTag = true
                this.tagId = id
                //alert(`will show tag id ${this.tagId}`)
            },
            formToggle(){
                this.isFormOpen = false 

            },
            edit(id){
                this.editId = id
                this.isFormOpen = true
            },
            del(id){
                if(id && id != 0 && confirm(`this will delete your post id ${id} 
                            are your sure?`) == true){
                    let url = `/api/member/post/${id}`
                    axios.delete(url)
                    .then(res=>{
                        this.res_status = res.data.msg
                        this.isModalOpen = 'is-active'

                        setTimeout(()=>{
                            this.getPost()
                            this.res_status = ''
                            this.isModalOpen = ''
                                },750)
                    })
                }
                return
            },
            clearSet(){
                this.isShowDefaultList = true
                this.editId = 0
                this.isShowByTag = false
                this.isShowByCat = false
                this.isModalOpen = ''
                this.res_status = ''
            },
        },
}
</script>
