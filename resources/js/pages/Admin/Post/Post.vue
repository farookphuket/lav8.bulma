<template>
    <section class="section">
            <nav class="breadcrumb" aria-label="breadcrumbs">
              <ul>
                <li><a href="/admin/home">Home</a></li>
                <li class="is-active">
                    <a href="#" aria-current="page">Post</a>
                </li>
              </ul>
            </nav>
        <div class="columns">
            <div class="column is-3">

                    <a class="button is-primary is-block is-alt" href="#" 
                    @click.prevent="showForm = true">New Post</a>

                    <span class="button is-info is-block is-alt mt-2">

                        <router-link
                          class="nav-link has-text-white"
                          data-toggle="collapse"
                          :to="{ name: 'AdminComment' }"
                        >
                        <b>
                          Comment
                        </b>
                        </router-link>
                    </span>


                    <aside class="mt-4 menu">
                        <p class="title">
                                Tags
                        </p>
                        <p class="subtitle">the available tags now</p>
                        <tag></tag>
                    </aside>
            </div>
            <div class="column is-9">

                    <post-form :editId="editId" 
                        :template_all="template_all"
                    @getPost="getPost($event)" v-show="showForm" 
                    @closeForm="closeForm($event)"></post-form>


                <post-list :postList="postList" @edit="edit($event)" 
                @del="del($event)"
                @openPost="openPost($event)"></post-list>
            </div>
        </div>

        <div class="modal" :class="{'is-active':showModal}">
          <div class="modal-background"></div>
          <div class="modal-content">
            <div class="content box">
                <div v-html="res_status" class="mb-6">{{res_status}}</div>
            </div>
          </div>
          <button class="modal-close is-large" aria-label="close" 
          @click.prevent="showModal = ''"></button>

            <button class="button is-success is-outlined " 
            @click.prevent="showModal=''">
                <font-awesome-icon icon="check"></font-awesome-icon>
            </button>

        </div>


    </section>
</template>

<script>
import PostForm from './PostForm.vue'
import PostList from './PostList.vue'
import Tag from '../Tag/Tag.vue'

export default{
    name:"AdminPost",
     components:{
         PostForm,
         PostList,
         Tag,
     },
     data(){return{
        res_status:'',
        showForm:false,
        editId:0,
        postList:'',
         template_all:'',
        showModal:'',
     }},
     mounted(){
         this.getPost()
     },
    methods:{
        getPost(page){
            this.res_status = ''
            this.editId = 0
            let url = ''
            if(page){
                url = page 
                this.$cookies.set('apost_old_page',url)
            }
            url = this.$cookies.get('apost_old_page')
            if(!url) url = `/api/admin/getpost`
            axios.get(url)
                .then(res=>{
                    console.log(res.data)
                    this.postList = res.data.post
                    this.template_all = res.data.template
                        })
        },
        closeForm(){
            this.showForm = false
        },
        openPost(slug){
            let url = `/api/post/${slug}`
            let openUrl = ''
            axios.get(url)
            .then(res=>{

                let e = res.data.post.slug
                openUrl = `/${e}`
                console.log(openUrl)
                location.href=openUrl
                    })
        },
        edit(id){
            this.showForm = true
            this.editId = id
        },
        del(id){ 
            if(id && id != 0 && confirm(`This will delete the post id ${id} ,Are you sure ?`) == true){
                let url = `/api/admin/post/${id}`
                axios.delete(url)
                .then(res=>{
                    this.res_status = res.data.msg
                    this.showModal = true
                    setTimeout(()=>{
                        this.getPost()
                        this.showModal = ''
                    },2000) 
                })
            }
            return
        },
    },

}
</script>
