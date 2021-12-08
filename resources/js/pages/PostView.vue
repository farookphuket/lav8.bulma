<template>
    <section class="section">
    <div class="container">
        <div class="content">
            <h2 class="title has-text-centered">{{thePost.p_title}}</h2>
            <p class="subtitle">{{thePost.slug}}</p>
            <div  v-html="thePost.p_excerpt">{{thePost.p_excerpt}}</div>
            <div  v-html="thePost.p_body">{{thePost.p_body}}</div>

            <!-- show tag,category START -->
            <div class="columns">
                <div class="column">
                    <div class="is-pulled-left">
                        <ul class="tags">
                            <li class="tag is-info" v-for="ca in thePost.category">
                               <span class="mr-2">
                                 <font-awesome-icon icon="bookmark"></font-awesome-icon>
                               </span>
                               <span>
                                    {{ca.cat_name}}
                               </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="column">
                    
                    <div class="is-pulled-right">
                        <ul class="tags">
                            <li class="tag is-primary" v-for="ta in thePost.tag">
                               <span class="mr-2">
                                 <font-awesome-icon icon="tag"></font-awesome-icon>
                               </span>
                               <span>
                                    {{ta.tag_name}}
                               </span>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="column is-6">
                    <div class="is-pulled-right">
                        <ul class="tags">

                            <li class="tag">
                                <span class="mr-2">
                                    <font-awesome-icon icon="calendar-day">
                                    </font-awesome-icon>
                                </span>
                                <span>
                                {{moment(thePost.created_at)}}
                                </span> 
                                &middot; 
                                <span class="ml-2">{{moment(thePost.created_at).fromNow()}}</span>
                            </li>

                            <li class="tag">
                                <span class="mr-2">
                                    <font-awesome-icon icon="user">
                                    </font-awesome-icon>
                                </span>
                                <span>{{thePost.user.name}}</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div><!-- end div.columns -->
            <!-- show tag,category END -->

        </div>
    </div>
    </section>
</template>
<script>
var moment = require('moment')
export default{
    name:"PostView",
             data(){return{
                 theUrl:'',
                thePost:'',
                moment:moment,
             }},
             mounted(){
                 this.getUrl()
             },
methods:{
            getUrl(){
                this.theUrl = `/api/post${this.$route.path}`
                axios.get(this.theUrl)
                .then(res=>{
                    //console.log(res.data)
                    this.thePost = res.data.post
                    document.title = res.data.post.p_title
                        })
            },
        },
}
</script>
