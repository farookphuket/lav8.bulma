<template>
    <div>

        <!-- show list of post START -->
        <article class="box" 
            v-for="po in postList.data"
        >
            <div class="content">
                <h2 class="has-text-centered has-text-success">
                    <a href="" @click.prevent="openPost(po.slug)">
                        <span class="ml-2">
                            {{po.p_title}}
                        </span>
                        <span>
                            <font-awesome-icon icon="external-link-alt"></font-awesome-icon>
                        </span>
                    </a>
                </h2>

                <!-- show user,post date info in the same row -->
                <div class="columns">
                    <div class="column">
                        <ul class="tags">
                            <li class="tag has-text-success">
                                {{po.slug}}
                            </li>
                            <li class="tag is-warning">
                                <span class="mr-2">
                                    <font-awesome-icon 
                                    icon="eye"></font-awesome-icon>
                                </span>
                                <span>
                                    {{Object.values(po.read).length}}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="column">

                        <div class="is-pulled-right">
                            <ul class="tags">
                                <li class="tag is-info">
                                    <span>
                                        <font-awesome-icon icon="calendar-day"></font-awesome-icon>
                                    </span>
                                    <span class="ml-2">{{moment(po.created_at)}}</span>
                                    &middot;
                                    <span class="ml-2">{{moment(po.created_at).fromNow()}}</span>
                                </li>
                                <li class="tag is-info">
                                    <span>
                                        <font-awesome-icon icon="user"></font-awesome-icon>
                                    </span>
                                    <span class="ml-2">{{po.user.name}}</span>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div><!-- div.columns END -->
                <!-- show user,post date info in the same row -->

                <div class="mb-4 mt-4" v-html="po.p_excerpt">
                    {{po.p_excerpt}}
                </div>

                <!-- show tag of this post START -->
                <div class="columns">
                    <div class="column">
                        <div class="is-pulled-left">
                            <ul class="tags">
                                <li class="tag is-info" v-for="ca in po.category">
                                   <span class="mr-2">
                                        <font-awesome-icon icon="bookmark"></font-awesome-icon>
                                   </span>
                                   <span>{{ca.cat_name}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="column">
                        <div class="is-pulled-right">
                            <ul class="tags">
                                <li class="tag ml-2" v-for="ta in po.tag">
                                    <span class="mr-2">
                                        <font-awesome-icon icon="tag">
                                        </font-awesome-icon>
                                    </span>
                                    <span>
                                        {{ta.tag_name}}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>     
                <!-- show tag of this post END -->

            </div>
        </article>
        <!-- show list of post END -->


        <!-- pagination START -->

            <div class="box">

                <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
                    <a class="pagination-previous is-current">All post {{postList.total}}</a>
                    <a class="pagination-next is-current">page {{postList.current_page}}</a>
                  <ul class="pagination-list" v-for="ln in postList.links">
                    <li v-if="ln.url != null && ln.active == false">
                      <a class="pagination-link" 
                      aria-label="Page 1" aria-current="page" v-html="ln.label" 
                      @click.prevent="$emit('getPost',ln.url)">{{ln.label}}</a>
                    </li>
                    <li v-else>
                      <a class="pagination-link is-current"  v-if="ln.active == true" 
                      aria-label="" aria-current="page" v-html="ln.label" 
                      >{{ln.label}}</a>

                      <a class="pagination-link"  v-else 
                      aria-label="" aria-current="page" v-html="ln.label" 
                      >{{ln.label}}</a>
                    </li>

                  </ul>
                </nav>
            </div>
        <!-- pagination END -->
    </div>
</template>

<script>
var moment = require('moment')
export default{
    name:"PostList",
    props:["postList"],
    data(){return{
        moment:moment,

    }},

    methods:{
        openPost(slug){
            let url = `/${slug}`
            window.location.href=url
        },
    },
}
</script>
