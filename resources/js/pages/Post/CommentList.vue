<template>
    <div>
        <article class="box" v-for="cc in comment_list.data">
            <h2 class="title">{{cc.c_title}}</h2>
            <p class="subtitle"> 
                {{cc.user.name}}</p>


            <div class="content mb-4 mt-2" v-html="cc.c_body">
                {{cc.c_body}}
            </div><!-- end of div for comment body -->

            <!-- div.columns show user detail START -->
            <div class="columns">
                <div class="column">
                    <div class="field is-pulled-left">
                        {{cc.created_at}}
                    </div>
                </div>
                <div class="column">
                    <!-- user info START -->
                    <div class="field is-pulled-right">
                        <span class="ml-2 has-text-success">
                            <font-awesome-icon icon="user"></font-awesome-icon>
                        </span>
                        <span>
                            {{cc.user.name}}
                        </span>
                        <span class="ml-2">
                            <font-awesome-icon icon="quote-left"></font-awesome-icon>

                        </span>
                        <span>

                            <a class="is-link is-outlined" href="" 
                            @click.prevent="showReplyForm(cc.id)"
                                >
                                reply 
                                <font-awesome-icon icon="quote-right"></font-awesome-icon>
                                
                            </a>
                        </span>
                    </div>
                    <!-- user info END -->

                </div><!-- end of div.column -->
            </div>
            <!-- div.columns show user detail END -->

            <!-- reply form START -->
            <div class="mb-4 mt-4" v-if="replyItem[cc.id]">
               <div class="field">
                    <div class="control">
                        <jodit-editor 
                        v-model="rForm.r_body"></jodit-editor>
                    </div>
               </div>
            </div>

            <!-- reply form START -->


            <!-- reply START -->
            <article class="box" v-for="re in cc.reply">
                <h2 class="title">{{re.r_title}}</h2>
                <div class="content mb-2 mt-2" v-html="re.r_body">
                    {{re.r_body}}
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field is-pulled-right">
                            <span class="ml-2">
                                <font-awesome-icon icon="calendar-day">
                                </font-awesome-icon>
                            </span>
                            <span class="mr-2 ml-2">
                                {{moment(re.created_at)}}
                            </span>
                            <span>{{moment(re.created_at).fromNow()}}</span>
                            <span class="ml-2 mr-2 has-text-info">
                                <font-awesome-icon icon="user"></font-awesome-icon>
                            </span>
                            <span>{{re.user.name}}</span>
                        </div>
                    </div>
                </div>
                
            </article>

            <!-- reply END -->


        </article>


        <!-- pagination page START -->
        <div class="content mt-6 mb-4">
            pagination
        </div>
        <!-- pagination page END -->
    </div>
</template>

<script>
import JoditEditor from 'jodit-vue'
import CommentForm from './CommentForm.vue'
var moment = require("moment")
export default{
    name:"CommentList",
    props:["postId"],
    components:{
        CommentForm,
    },
    data(){return{
        post_id:0,
        comment_list:0,
        reply_list:0,
        replyItem:[],
        btnReply:true,
        rForm: new Form({
            r_body:'',
            comment_id: 0
        }),
        res_status:'',
        moment:moment,
    }},
    watch:{
        "postId":function(x){
            this.getPostById(x)
        }
    },
    mounted(){

    },
    methods:{
        getComment(page){
            let url = ''
            if(page){
                url = page+`&post_id=${this.post_id}`
                this.$cookies.set("pcm_old_page",url)
            }
            url = this.$cookies.get("pcm_old_page")
            if(!url) url = `/api/getcomment?post_id=${this.post_id}`
            axios.get(url)
                .then(res=>{
                    console.log(res.data)
                    this.comment_list = res.data.comment
                })
        },
        showReplyForm(id){
            this.rForm.comment_id = id 
            this.$set(this.replyItem,id,true)
            this.btnReply = false
        },
        hideReplyForm(id){
            this.$set(this.replyItem,id,false)
            this.rForm.comment_id = 0
            this.btnReply = true
        },
        getPostById(x){
            this.post_id = x 


            this.getComment()
        },
    },
}
</script>
