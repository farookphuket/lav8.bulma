<template>
    <div >


                <div class="card">
                    <div class="card-content">
                        <article class="mt-4" v-for="po in wnList.data">


                            <div class="columns">

                                <div class="column">
                                    
                                    <div class="tags is-pulled-right" v-if="po.user_id == user_id">
                                        <div class="tag is-warning" v-if="po.is_public == 0">

                                        <font-awesome-icon icon="lock"></font-awesome-icon>
                                        <span class="ml-2">
                                            Private    
                                        </span>
                                        

                                        </div>
                                        <div class="tag is-success" v-else>
                                        
                                        <font-awesome-icon icon="lock-open"></font-awesome-icon>
                                        <span class="ml-2">
                                            Public
                                        </span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <span class="icon-text">

                                            <font-awesome-icon icon="user"></font-awesome-icon>  
                                            <span class="ml-2">
                                                {{po.user.name}}
                                            </span>
                                        </span>
                                        <span class="icon-text ml-2">
                                            <font-awesome-icon icon="clock"></font-awesome-icon>
                                        </span>
                                        <span class="ml-2">
                                            <a href="" :title="moment(po.created_at)">
                                                {{moment(po.created_at).fromNow()}}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <div class="column">

                                    <div class="field is-grouped is-grouped-right">
                                        <button class="button is-primary is-outlined" 
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

                            <h2 class="title has-text-centered">{{po.wn_title}}</h2>
                            <div class="content mt-4" v-html="po.wn_body">
                               {{po.wn_body}} 
                            </div>

                            <hr class="mb-4">
                            
                        </article>
                    </div>
                </div>

               <!-- pagination START --> 
               <div class="box">

<nav class="pagination is-rounded" role="navigation" aria-label="pagination">
    <a class="pagination-previous is-current">All post {{wnList.total}}</a>
    <a class="pagination-next is-current">page {{wnList.current_page}}</a>
  <ul class="pagination-list" v-for="ln in wnList.links">
    <li v-if="ln.url != null && ln.active == false">
      <a class="pagination-link" :class="{'is-current':theCurrentPage}"
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
               <!-- pagination END --> 

    </div>
</template>
<script>
var moment = require('moment')
export default{
    name:"WhatnewList",
    props:["wnList"],
             data(){return{
                 tk:'',
                 user_id:'',
                 moment:moment,
                 theCurrentPage:'',
             }},
             mounted(){
                 this.tk = this.$cookies.get('token')
                 this.user_id = window.user_id
             },
methods:{

        },
}
</script>
