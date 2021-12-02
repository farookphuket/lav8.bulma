<template>
<section class="section">
        <nav class="breadcrumb" aria-label="breadcrumbs">
          <ul>
            <li><a href="/">Home</a></li>
            <li class="is-active">
                <a href="#" aria-current="page">Posts</a>
            </li>
          </ul>
        </nav>

        <post-list v-show="isShowListPost" :postList="postList" 
        @openPost="openPost($event)"></post-list>
</section>

</template>

<script>
import PostList from './PostList.vue'
export default{
    name:"Post",
             components:{
                 PostList,
             },
             data(){
                 return{
                    isShowListPost:true,
                    postList:'',
                 }
             },
             mounted(){
                 this.getPost()
             },
methods:{
            getPost(page){
                this.isShowSinglePost = false 
                let url = ''
                if(page){
                    url = page
                    this.$cookies.set('pub_post_old_page',url)
                }
                url = this.$cookies.get('pub_post_old_page')
                if(!url) url = `/api/getpost`
                axios.get(url)
                    .then(res=>{
                        console.log(res.data)
                        this.postList = res.data.post
                            })
            },
            openPost(slug){
                this.isShowListPost = false
                console.log(slug)
            },
        }
}
</script>
