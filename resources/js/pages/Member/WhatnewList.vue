<template>
    <div class="content">
        <article class="box" v-for="wn in wnList.data">
            <h2 class="title has-text-centered">{{wn.wn_title}}</h2>
            <div v-html="wn.wn_body" class="mb-4">{{wn.wn_body}}</div>
            <div class="columns mt-2">
                <div class="column">
                    <div v-if="user_id == wn.user_id"
                    class="field is-grouped is-grouped-right">
                        <span class="tag is-success" v-if="wn.is_public != 0">
                            <font-awesome-icon icon="lock-open"></font-awesome-icon>
                        </span>
                        <span class="tag is-warning" v-else>
                            <font-awesome-icon icon="lock"></font-awesome-icon>
                        </span>

                       <div class="button is-pulled-right">
                            <button class="button is-outlined is-info">
                                <font-awesome-icon icon="edit"></font-awesome-icon>
                            </button>

                            <button class="button is-outlined is-danger">
                                <font-awesome-icon icon="trash-alt"></font-awesome-icon>
                            </button>
                       </div>
                    </div>

                    <div class="columns">
                        <div class="column">

                            <div class="field is-pulled-right">
                                <div class="field">
                                    <span class="icon-text">
                                        <font-awesome-icon icon="calendar-day">
                                        </font-awesome-icon>
                                    </span>
                                    <span class="ml-2 mr-2">
                                        {{moment(wn.created_at)}}
                                        &middot; 
                                        {{moment(wn.created_at).fromNow()}}
                                    </span>


                                    <span class="icon-text">
                                        <font-awesome-icon icon="user">
                                        </font-awesome-icon>
                                    </span>
                                    <span class="ml-2">
                                        {{wn.user.name}}
                                    </span>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </article>

        <div class="box">

            <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
                <a class="pagination-previous is-current">All post {{wnList.total}}</a>
                <a class="pagination-next is-current">page {{wnList.current_page}}</a>
              <ul class="pagination-list" v-for="ln in wnList.links">
                <li v-if="ln.url != null && ln.active == false">
                  <a class="pagination-link" 
                  aria-label="Page 1" aria-current="page" v-html="ln.label" 
                  @click.prevent="$emit('getWhatnew',ln.url)">{{ln.label}}</a>
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
    name:"WhatnewList",
    props:["wnList"],
    data(){return{
        user_id:'',
        moment:moment,
        
    }},
    mounted(){
        this.user_id = window.user_id 
    },
}
</script>
