<template>
    <div>
        <h2 class="title has-text-centered">
        template list {{tem_num}}</h2>

        <article class="box content" 
        v-for="tm in tem_list.data" v-if="tem_list.data != ''">
            <div class="mb-4">
                <h2 class="title has-text-centered">{{tm.t_title}}</h2>
                <div v-html="tm.t_excerpt">
                    {{tm.t_excerpt}}
                </div>
            </div>

            <!-- div.columns show post date,user START -->
            <div class="columns">
                <div class="column is-4">

                    <span>
                        <font-awesome-icon 
                        icon="calendar-day"></font-awesome-icon>
                    </span>
                    <span class="tag is-medium">{{moment(tm.created)}}</span>
                    <span class="tag is-medium">
                        {{moment(tm.created_at).fromNow()}}
                    </span>

                </div>
                <div class="column">
                    <span class="mr-2">
                        <font-awesome-icon icon="user">
                        </font-awesome-icon>
                    </span>
                    <span>{{tm.user.name}}</span>
                    <span class="ml-2 mr-2 tag is-success is-medium" 
                        v-if="tm.is_default_template == 1">
                        <font-awesome-icon icon="unlock"></font-awesome-icon>
                    </span>
                    <span class="ml-2 mr-2 tag is-warning is-medium" v-else>
                        <font-awesome-icon icon="lock"></font-awesome-icon>
                    </span>
                    <div class="filed is-pulled-right">

                        <button class="button is-primary 
                        is-rounded is-small" 
                        @click.prevent="$emit('edit',tm.id)">
                            <font-awesome-icon icon="edit">
                            </font-awesome-icon>
                        </button>
                        <button class="button is-danger 
                        is-rounded is-small" 
                        @click.prevent="$emit('del',tm.id)">
                            <font-awesome-icon 
                            icon="trash"></font-awesome-icon>
                        </button>
                    </div>

                </div>

            </div>
            <!-- div.columns show post date,user END -->
        </article>
        <article v-else>
            <h2>no data</h2>
        </article>

        <div class="box mt-4" v-if="tem_list.total > 1">
            <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
                <a class="pagination-previous is-current">All post {{tem_list.total}}</a>
                <a class="pagination-next is-current">page {{tem_list.current_page}}</a>
              <ul class="pagination-list" v-for="ln in tem_list.links">
                <li v-if="ln.url != null && ln.active == false">
                  <a class="pagination-link" 
                  aria-label="Page 1" aria-current="page" v-html="ln.label" 
                  @click.prevent="$emit('getTemplate',ln.url)">{{ln.label}}</a>
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
    name:"TemplateList",
    props:["tem_num","tem_list"],
    data(){return{
        moment:moment,
    }},
methods:{

        },
}
</script>
