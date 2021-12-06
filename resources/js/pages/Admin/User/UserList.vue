<template>
    <div class="content">
        <div class="box" v-for="u in uList.data">

            <div class="filed is-pulled-right">
                <div >
                     <span class="icon-text">
                        <font-awesome-icon icon="calendar-day"></font-awesome-icon>
                     </span>
                     <span class="ml-2">{{moment(u.created_at).fromNow()}}</span>
                </div>
                <button class="button is-primary" 
                    @click.prevent="$emit('edit',u.id)">
                    <font-awesome-icon icon="edit"></font-awesome-icon>
                </button>

                <button class="button is-danger" v-if="user_id == u.id" 
                    @click.prevent="$emit('del',u.id)" disabled>
                    <font-awesome-icon icon="trash"></font-awesome-icon>
                </button>

                <button class="button is-danger" v-else 
                    @click.prevent="$emit('del',u.id)">
                    <font-awesome-icon icon="trash"></font-awesome-icon>
                </button>
            </div>

            <ul>
                <li>{{u.name}}</li>
                <li>{{u.email}}</li>
                <li class="tags"> Role
                    <ul>
                        <li class="tag is-medium is-info" v-for="ro in u.role">
                            {{ro.role_name}}
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
        <div class="box">

            <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
                <a class="pagination-previous is-current">All user {{uList.total}}</a>
                <a class="pagination-next is-current">on page {{uList.current_page}}</a>
              <ul class="pagination-list" v-for="ln in uList.links">
                <li v-if="ln.url != null && ln.active == false">
                  <a class="pagination-link"
                  aria-label="Page 1" aria-current="page" v-html="ln.label" 
                  @click.prevent="$emit('getUser',ln.url)">{{ln.label}}</a>
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
var moment = require("moment")
export default{
    name:"UserList",
    props:["uList"],
    data(){return{
        moment:moment,
        user_id:'',
    }},
    mounted(){
        this.user_id = window.user_id

    },
}
</script>
