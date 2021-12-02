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
            <div v-html="po.p_excerpt">{{po.p_excerpt}}</div>
            <div class="columns" >
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
                            <button class="button is-warning is-outlined">
                                <font-awesome-icon icon="edit"></font-awesome-icon>
                            </button>

                            <button class="button is-danger is-outlined">
                                <font-awesome-icon icon="trash-alt"></font-awesome-icon>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

       </div><!-- end of div.box -->
        <div class="box mt-4">
            <p>pagination</p>
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
