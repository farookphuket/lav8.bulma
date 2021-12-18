<template>
    <div>
        

        <comment-form v-show="isFormOpen" 
            :postId="post_id" :editId="editId"
            @getComment="getComment($event)"></comment-form>

        <div class="content mt-6 mb-4">
            <h2>comment {{comment_list.total}} item(s).</h2>

            <article class="box" v-for="c in comment_list.data">
                <h2 class="title">
                    <span class="ml-2">
                        <font-awesome-icon icon="reply"></font-awesome-icon>
                    </span>
                    <span>
                        {{c.c_title}}
                    </span>
                </h2>
                <div class="content" v-html="c.c_body">
                    {{c.c_body}} 
                </div>

                 <div class="columns">
                     <div class="column">
                        <div class="field is-pulled-right">
                            <span class="ml-2 has-text-info">
                                <font-awesome-icon icon="user"></font-awesome-icon>
                            </span>
                            <span>
                                {{c.user.name}}
                            </span>
                        </div>
                     </div>
                 </div>
            </article>



        <!-- pagination START -->

            <div class="box" v-show="isShowPagination">

                <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
                    <a class="pagination-previous is-current">All comment {{comment_list.total}}</a>
                    <a class="pagination-next is-current">page {{comment_list.current_page}}</a>
                  <ul class="pagination-list" v-for="ln in comment_list.links">
                    <li v-if="ln.url != null && ln.active == false">
                      <a class="pagination-link" 
                      aria-label="Page 1" aria-current="page" v-html="ln.label" 
                      @click.prevent="getComment(ln.url)">{{ln.label}}</a>
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


    </div>

</template>
<script>
var moment = require("moment")
import CommentForm from './CommentForm.vue'
export default{
    name:"CommentList",
    props:["postId"],
    components:{
        CommentForm,
    },
    data(){return{
        comment_list:'',
        moment:moment,
        post_id:0,
        editId:0,
        current_post_id:0,
        isFormOpen:false,
        isShowPagination:false,

    }},
    mounted(){
        this.isUserLogin()
    },
    watch:{
        "postId":function(x){
            this.getLastEndPoint(x)
        }
    },
    methods:{
        getComment(page){
            this.isShowPagination = false
            let url = ''

            if(page){
                url = page+`&post_id=${this.post_id}`
                this.$cookies.set("pcm_old_page",url)
            }
            url = this.$cookies.get("pcm_old_page")
            if(!url) url = `/api/getcomment?post_id=${this.post_id}`
            axios.get(url)
                .then(res=>{
                    this.comment_list = res.data.comment
                   
                    if(this.comment_list.total != 0) this.isShowPagination = true
                    let cm = res.data.comment
                    cm.data.forEach((cc)=>{
                        //console.log(cc.pivot.post_id)
                        this.$cookies.set("current_post_id",cc.pivot.post_id)
                    })

             //       console.log(res.data)
                })
        },
        getLastEndPoint(x){
            this.post_id = x

            this.current_post_id = this.$cookies.get("current_post_id")
            if(this.post_id != this.current_post_id){
                this.$cookies.remove("pcm_old_page")
            }

            this.getComment()
        },
        isUserLogin(){
            this.isFormOpen = false
            if(this.$cookies.get("token") != null) this.isFormOpen = true
            //console.log(this.$cookies.get("token"))
        },
    },
}
</script>
