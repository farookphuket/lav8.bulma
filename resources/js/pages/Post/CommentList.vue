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
                            <div class="field is-pulled-left pl-2">
                                <span class="mr-2">
                                    <font-awesome-icon icon="calendar-day"></font-awesome-icon>
                                </span>
                                <span>
                                    {{moment(c.created_at)}}
                                </span>
                                <span class="ml-2">
                                    {{moment(c.created_at).fromNow()}}
                                </span>
                            </div>
                        </div>
                     <div class="column">
                        
                        <div class="field is-pulled-right">
                            <span class="mr-2">
                                <a class="is-link is-outlined" href="" 
                                @click.prevent="showReplyForm(c.id)"
                                >
                                    <font-awesome-icon icon="reply"></font-awesome-icon>
                                </a>
                            </span>


                            <span class="ml-2 has-text-info">
                                <font-awesome-icon icon="user"></font-awesome-icon>
                            </span>
                            <span>
                                {{c.user.name}}
                            </span>
                        </div>
                     </div>



                 </div>


                 <div class="columns">

                     <div class="column">
                        <div v-if="replyItem[c.id]">
                            <form action="">

                            <div class="field">
                                <div class="control">
                                    <input v-model="rForm.r_title" 
                                    class="input" type="text" name="" 
                                    ref="r_title">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <jodit-editor 
                                    v-model="rForm.r_body" 
                                    height=250></jodit-editor>
                                </div>    
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <div class="field is-pulled-left">
                                        <div v-html="res_status">{{res_status}}</div>
                                    </div>
                                </div>
                                <div class="column">

                                    <div class="field is-pulled-right">
                                        <button class="button is-outlined is-primary" 
                                        @click.prevent="saveReply(replyId)">
                                            <font-awesome-icon icon="check"></font-awesome-icon>
                                        </button>
                                        <button class="button is-outlined is-danger" 
                                        @click.prevent="hideReplyForm(c.id)">
                                            <font-awesome-icon icon="times"></font-awesome-icon>
                                        </button>
                                    </div>
                                </div>
                            </div>


                            </form>

                        </div>

                     </div>

                     
                 </div>

                <!-- reply list START -->
                <article class="box" v-for="re in reply_list">
                    <h2 class="title">{{re.r_title}}</h2>
                    <div class="content" v-html="re.r_body">
                        {{re.r_body}}
                    </div>
                </article>
                <!-- reply list End -->

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
        replyItem:[],
        reply_list:'',
        replyId:0,
        rForm: new Form({
            r_title:"",
            r_body:"",
            comment_id:''
                }),
        btnReply:true,
        res_status:'',
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
                        //console.log(cc.reply)
                        this.reply_list = cc.reply
                        cc.reply.forEach((re)=>{
                            //this.reply_list = re
                            console.log(re)
                                })
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
        showReplyForm(id){
            this.$set(this.replyItem,id,true)
            this.rForm.comment_id = id
            this.btnReply = false 

        },
        hideReplyForm(id){
            this.btnReply = true
            this.$set(this.replyItem,id,false)
        },
        saveReply(id){
            let url = '/api/member/reply'
            let fData = new FormData()

            fData.append("r_title",this.rForm.r_title)
            fData.append("r_body",this.rForm.r_body)
            fData.append("post_id",this.post_id)
            fData.append("comment_id",this.rForm.comment_id)


            if(id){
                fData.append("_method","PUT")
                url = `/api/member/reply/${id}`
            }
            axios.post(url,fData)
                .then(res=>{
                    this.res_status = res.data.msg
                })
            .catch(err=>{
                this.res_status = `<span class="tag is-medium is-danger">
                ${Object.values(err.response.data.errors).join()} 
                </span>`
                    })

        },
    },
}
</script>
