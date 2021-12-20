<template>
    <div>
        <section class="section">
           <article>
                <h2 class="title has-text-centered">
                    <span>
                        {{post.p_title}}
                    </span>
                </h2>

                <!-- START show user,date create info div.columns -->
                <div class="columns">
                    <div class="column">
                        <ul class="tags">
                            <li class="tag">
                                <span class="ml-2">
                                    <font-awesome-icon icon="calendar-day"></font-awesome-icon>
                                </span>
                                <span class="ml-2">
                                    {{moment(post.created_at)}}
                                </span>

                            </li>
                            <li class="tag">
                                <span class="ml-2">
                                    {{moment(post.created_at).fromNow()}}
                                </span>
                            </li>

                        </ul>
                    </div>
                    <div class="column">
                       <div class="is-pulled-right">
                            <ul class="tags">

                                <li class="tag">
                                    <span class="mr-2">
                                        <font-awesome-icon icon="eye">
                                        </font-awesome-icon>
                                    </span>
                                    <span>{{post_has_read_times}}</span>
                                </li>
                                <li class="tag">
                                    <span class="mr-2">
                                        <font-awesome-icon icon="user">
                                        </font-awesome-icon>
                                    </span>
                                    <span>
                                        {{writer_name}}
                                    </span>
                                </li>
                            </ul>
                       </div>
                    </div>
                </div>
                <!-- end div.columns -->
                <div class="content">
                    <span class="subtitle has-text-info">
                        {{post.slug}}
                    </span>
                    <div v-html="post.p_excerpt">
                        {{post.p_excerpt}}
                    </div>
                    <div class="mt-4" v-html="post.p_body">
                        {{post.p_body}}
                    </div>
                </div>

                <!-- show tag,category div.colums START -->
                <div class="columns">
                    <div class="column">
                        <ul class="tags mt-4">

                            <li class="tag">
                                <span class="tags">
                                    <span class="mr-2">
                                        <font-awesome-icon icon="tag">
                                        </font-awesome-icon>
                                    </span>
                                   <span class="tag is-info" 
                                   v-for="ta in tag">
                                    {{ta.tag_name}}
                                   </span>
                                </span>
                            </li>

                            <li class="tag">
                                <span class="mr-2">
                                    <font-awesome-icon icon="bookmark"></font-awesome-icon>
                                </span>
                                <span class="tags">
                                    <span class="tag is-success" v-for="ca in category">
                                        {{ca.cat_name}}
                                    </span>
                                </span>

                            </li>
                        </ul>
                    </div>
                </div>
                <!-- show tag,category div.colums END -->

    
                <comment-list :postId="post_id" 
                    :post="post"></comment-list>
           </article>
        </section>
    </div>

</template>

<script>
var moment = require('moment')
import CommentList from './CommentList.vue'
export default{
name:"PostView",
    components:{
        CommentList,
    },
         data(){return{
            moment:moment,
            post:'',
             post_id:'',
            writer_name:'',
            category:'',
            tag:'',
            post_has_read_times:0,
            theGetUrl:'',
         }},
         mounted(){
            this.theGetUrl = this.$route.path
            this.getThePost()
         },
methods:{
            getThePost(){
                let url = `/api/post${this.theGetUrl}`
                axios.get(url)
                .then(res=>{
                    //console.log(res.data)
                    let rData = res.data.post
                    this.post = res.data.post
                    this.writer_name = this.post.user.name
                    this.tag = rData.tag 
                    this.category = rData.category
                    this.post_id = this.post.id
                    this.post_has_read_times = Object.values(rData.read).length
                    document.title = this.post.p_title
                        })
            },
        },
}

</script>
