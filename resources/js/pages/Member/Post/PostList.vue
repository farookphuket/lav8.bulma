<template>
    <div>
        <div class="content">
            <article class="box" 
            v-for="po in postList.data">
                <h2 class="title has-text-centered">
                <a href="" @click.prevent="openPost(po.slug)">
                  <span>
                    {{po.p_title}}
                  </span>
                    <span class="ml-2">
                        <font-awesome-icon icon="external-link-alt"></font-awesome-icon>
                    </span>
                </a>

                </h2>

                <!-- show tags,date create START -->
                <div class="columns">
                    <div class="column is-3">
                        <ul class="tags">
                            <li class="tag is-info" v-for="ta in po.tag">
                                {{ta.tag_name}}
                            </li>
                        </ul>
                    </div>
                    <div class="column is-5">
                        <p>{{moment(po.created_at)}} 
                        &middot;
                        {{moment(po.created_at).fromNow()}}
                        </p>    
                    </div>

                    <div class="column is-4" v-if="user_id == po.user_id">
                        <div class="field is-pulled-left">
                            <div class="tags">
                                <span class="tag is-success is-medium" v-if="po.p_is_public != 0">
                                    <font-awesome-icon icon="lock-open">
                                    </font-awesome-icon>
                                </span>
                                <span class="tag is-warning is-medium" v-else>
                                    <font-awesome-icon icon="lock">
                                    </font-awesome-icon>
                                </span>
                            </div>
                        </div>
                        <div class="field is-pulled-right">
                            <button class="button is-link is-outlined" 
                            @click.prevent="$emit('edit',po.id)">
                                <font-awesome-icon icon="edit"></font-awesome-icon>
                            </button>

                            <button class="button is-danger is-outlined" 
                            @click.prevent="$emit('del',po.id)">
                                <font-awesome-icon icon="trash"></font-awesome-icon>
                            </button>
                        </div>
                    </div>

                    <div class="column is-4" v-else>
                        <div class="field is-pulled-right pr-4">
                            <span class="icon">
                                <span class="icon-text">

                                    <font-awesome-icon icon="user"></font-awesome-icon>
                                </span>
                                <span class="ml-2">{{po.user.name}}</span>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- show tags END -->

            </article>
        </div>
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
    </div>
</template>
<script>
var moment = require('moment')
export default{
name:"PostList",
props:["postList"],
         data(){return{
            moment:moment,
            user_id:'',
         }},
         mounted(){
            this.user_id = window.user_id
         },
methods:{
            openPost(slug){
                let url = `/${slug}`
                location.href=url
            },
        },
}
</script>
