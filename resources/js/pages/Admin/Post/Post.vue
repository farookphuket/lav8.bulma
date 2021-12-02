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
					<aside class="menu">
						<p class="menu-label">
							Tags
						</p>
					</aside>
            </div>
            <div class="column is-9">

                    <post-form :editId="editId" 
                    @getPost="getPost($event)" v-show="showForm" 
                    @closeForm="closeForm($event)"></post-form>


                <post-list :postList="postList" 
                @openPost="openPost($event)"></post-list>
            </div>
        </div>
    </section>
</template>

<script>
import PostForm from './PostForm.vue'
import PostList from './PostList.vue'
export default{
    name:"AdminPost",
     components:{
         PostForm,
         PostList,
     },
     data(){return{
        res_status:'',
        showForm:false,
        editId:0,
        postList:'',
        showForm:false,
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
                    //console.log(res.data)
                    this.postList = res.data.post
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
    },

}
</script>
