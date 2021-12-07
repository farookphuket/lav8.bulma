<template>
    <div>
        <div class="content">
            <article class="box" v-for="ca in catList.data">
                <h2 class="title has-text-centered">{{ca.cat_name}}</h2>
            </article>

            <div class="box">

                <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
                    <a class="pagination-previous is-current">All post {{catList.total}}</a>
                    <a class="pagination-next is-current">page {{catList.current_page}}</a>
                  <ul class="pagination-list" v-for="ln in catList.links">
                    <li v-if="ln.url != null && ln.active == false">
                      <a class="pagination-link"
                      aria-label="Page 1" aria-current="page" v-html="ln.label" 
                      @click.prevent="$emit('getCategory',ln.url)">{{ln.label}}</a>
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
</template>
<script>
var moment = require('moment')
export default{
name:"CategoryList",
props:["catList"],
}
</script>
