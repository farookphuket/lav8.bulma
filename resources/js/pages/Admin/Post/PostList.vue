<template>
    <div class="content">


       <div class="box mt-2" v-for="po in postList.data">
            <h2 class="has-text-centered">{{po.p_title}}</h2>
            <p class="subtitle">
               <span class="icon">
                    <font-awesome-icon icon="user"></font-awesome-icon>
               </span>  
                <span class="mr-2">
                    {{po.user.name}}
                </span>
               <span class="icon">
                    <font-awesome-icon icon="clock"></font-awesome-icon>
               </span>  
                <span class="mr-2">
                    {{moment(po.created_at)}} &middot;
                    {{moment(po.created_at).fromNow()}}
                </span>
            </p>
            <div class="mb-6" v-html="po.p_excerpt">{{po.p_excerpt}}</div>
            <div class="columns" >
                <div class="column">
                    <div class="field is-pulled-left">
                        <p class="subtitle">
                            <font-awesome-icon icon="tags"></font-awesome-icon> : 
                            <span class="tag is-info " v-for="t in po.tag">
                                {{t.tag_name}}
                            </span>

                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field is-grouped is-grouped-right" v-if="po.user_id == user_id">
                        <div class="tags">
                            <span class="tag is-success" v-if="po.p_is_public != 0">
                                <span class="icon-text">
                                    <font-awesome-icon icon="lock-open"></font-awesome-icon>
                                </span>
                            </span>

                            <span class="tag is-warning" v-else>
                                <span class="icon-text">
                                    <font-awesome-icon icon="lock"></font-awesome-icon>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="field is-pulled-right">
                        <div class="buttons">

                            <button class="button is-info is-outlined" 
                            @click.prevent="$emit('openPost',po.slug)">
                                <font-awesome-icon icon="eye"></font-awesome-icon>
                            </button>
                            <button class="button is-warning is-outlined" 
                            @click.prevent="$emit('edit',po.id)">
                                <font-awesome-icon icon="edit"></font-awesome-icon>
                            </button>

                            <button class="button is-danger is-outlined" 
                            @click.prevent="$emit('del',po.id)">
                                <font-awesome-icon icon="trash-alt"></font-awesome-icon>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            
       </div><!-- end of div.box -->
        <div class="box mt-4">
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

    </div> <!-- end of div.content -->
</template>
<script>
var moment = require('moment')
export default{
    name:"PostList",
    props:["postList"],
    data(){return{
        user_id:'',
        moment:moment,
    }},
    mounted(){
        this.user_id = window.user_id
    },

}
</script>
