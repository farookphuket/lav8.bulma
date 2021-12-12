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

            <by-tag :tagId="tagId" v-show="isShowByTag" 
            @getPost="getPost($event)" 
            @openPost="openPost($event)"></by-tag>

            <by-cat :catId="catId" v-show="isShowByCat" 
                @getPost="getPost($event)" 
                @openPost="openPost($event)"></by-cat>

            <post-list  :postList="postList" 
            @getPost="getPost($event)" v-show="isShowDefaultList"
            :post_with_category="post_with_category" 
            @openPost="openPost($event)" ></post-list>
            

            <!-- show category and tag START -->
            <div class="columns mt-6">
                <div class="column is-4">
                    <div class="field is-pulled-left">
                       <ul class="tags">
                           <li class="tag is-medium" 
                           v-for="ca in category"
                           >
                                <span class="mr-2">
                                    <font-awesome-icon icon="bookmark"></font-awesome-icon>
                                </span>
                                <span>
                                    <b class="has-text-success">
                                            <a href="" 
                                            @click.prevent="byCat(ca.id)">
                                                {{ca.cat_name}}
                                            </a>                                 

                                    </b>  
                                    ({{Object.values(ca.post).length}}) 
                                </span>

                           </li>
                       </ul>
                    </div>
                </div>
                <div class="column is-8">
                    <div class="field is-pulled-right">
                        
                       <ul class="tags">
                            <li class="tag" v-for="ta in tag">
                                <span class="mr-2">
                                    <font-awesome-icon icon="tag">
                                    </font-awesome-icon>
                                </span>
                                <span>
                                    <b class="has-text-info">

                                        <a href="" @click.prevent="byTag(ta.id)">
                                            {{ta.tag_name}}
                                        </a>
                                        
                                    </b> 
                                    ({{Object.values(ta.post).length}})
                                </span>
                                
                            </li>
                       </ul>
                    </div>
                </div>
            </div>
            <!-- show category and tag END -->
    </section>
</div>

</template>

<script>
import ByTag from './PostByTag.vue'
import ByCat from './PostByCat.vue'
import PostList from './PostList.vue'
export default{
    name:"Post",
             components:{
                 PostList,
                 ByTag,
                 ByCat,
             },
             data(){
                 return{
                    postList:'',
                    post_with_category:'',
                    post_in_cat_length:0,
                    cat_name:'',
                    isShowDefaultList:true,
                    isShowByTag:false,
                    tagId:0,
                    isShowByCat:false,
                    catId:0,
                    category:'',
                    tag:'',
                 }
             },
             mounted(){
                 this.getPost()
                 this.showTagHasContent()
             },
methods:{
            getPost(page){
                this.clearSet()
               this.isShowDefaultList = true 

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
                        document.title = res.data.meta_title
                        let cate = res.data.post_with_category.data
                        this.post_in_cat_length = Object.keys(cate).length
                        this.post_with_category = res.data.post_with_category
                        cate.forEach((ca)=>{

                            this.cat_name = ca.category
                        })
                        this.postList = res.data.post
                    })
            },
            showTagHasContent(){
               let url = `/api/getpost`
               axios.get(url)
               .then(res=>{

                    let cp = res.data.cp 
                    this.category = cp
                    //console.log(res.data)
                    let ta = res.data.ta
                    this.tag = ta
                    

                })
            },
            byTag(id){
                this.clearSet()
                this.isShowByTag = true 
                this.tagId = id
            },
            byCat(id){
                this.clearSet()
                this.isShowByCat = true 
                this.catId = id
            },
            openPost(slug){
                let url = `/${slug}`
                location.href=url
            },
            clearSet(){
                this.isShowDefaultList = false 
                this.isShowByCat = false 
                this.isShowByTag = false

            }
        },
}
</script>
