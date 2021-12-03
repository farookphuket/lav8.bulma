<template>
    <div>
    <section class="hero is-success is-fullheight">
      <div class="hero-body">
      </div>
    </section>
    <section class="container">
        <div class="columns">
            <div class="column is-3">
                <h2 class="title">see-southern 2022</h2>
            </div>
            <div class="column is-9">
                <article class="box" 
                v-for="w in wn.data">
                   <h2 class="title has-text-centered">{{w.wn_title}}</h2>
                   <div v-html="w.wn_body">{{w.wn_body}}</div>
                   
                </article>
                <div class="box">

                    <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
                        <a class="pagination-previous is-current">All post {{wn.total}}</a>
                        <a class="pagination-next is-current">page {{wn.current_page}}</a>
                      <ul class="pagination-list" v-for="ln in wn.links">
                        <li v-if="ln.url != null && ln.active == false">
                          <a class="pagination-link" 
                          aria-label="Page 1" aria-current="page" v-html="ln.label" 
                          @click.prevent="getWn(ln.url)">{{ln.label}}</a>
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
        </div>
    </section>
    </div>
</template>

<script>
var moment = require('moment')
export default {
   name:"Home",
            data(){return{
                wn:'',
                moment:moment,
            }},
            mounted(){
                this.getWn()
            },
methods:{
            getWn(page){
                let url = ''
                    if(page){
                        url = page
                        this.$cookies.set('pub_old_wn',url)
                    }
                    url = this.$cookies.get('pub_old_wn')
                    if(!url) url = `/api/whatnew`
                    axios.get(url)
                        .then(res=>{
                           //console.log(res.data)
                            this.wn = res.data.whatnew
                            document.title = res.data.meta_title

                    })
            },
        },
}
</script>
