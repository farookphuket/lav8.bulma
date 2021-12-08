<template>
<div>
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
            
            <div class="box mt-4 mb-4">
               <ul class="tags">
                   <li class="tag is-medium" 
                   v-for="ca in cat_name">
                        <b class="has-text-success">
                            {{ca.cat_name}} 
                        </b> 
                        ({{post_in_cat_length}})
                   </li>
               </ul>
            </div>
    </section>
</div>

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
                    post_in_cat_length:0,
                    cat_name:'',
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
                        //console.log(res.data)
                        let cate = res.data.post_with_category.data
                        this.post_in_cat_length = Object.keys(cate).length

                        cate.forEach((ca)=>{

                            this.cat_name = ca.category
                        })
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
