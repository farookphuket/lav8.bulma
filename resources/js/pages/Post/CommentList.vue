<template>
    <div>

        <div class="box mb-4">
            <h2 class="has-text-centered title">
                Leave comment ({{comment_list.total}})
            </h2>
        </div>

        <comment-form v-show="isCommentFormShow" 
        :editId="editId" :postId="post_id"
        @getComment="getComment($event)"></comment-form>

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
                        <span class="ml-2">
                            <font-awesome-icon icon="calendar-day">
                            </font-awesome-icon>
                        </span>
                        <span>
                            {{moment(cc.created_at)}}
                        </span>
                        <span class="ml-2">
                            {{moment(cc.created_at).fromNow()}}
                        </span>

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
                        <span v-show="isCommentFormShow">

                            <a class="is-link is-outlined" href="" 
                            @click.prevent="showReplyForm(cc.id)"
                                >
                                reply 
                                <font-awesome-icon icon="quote-right"></font-awesome-icon>
                                
                            </a>
                        </span>

                        <!-- edit,delete button START -->
                        <span class="ml-2 mr-2 pr-2" 
                        v-if="user_id == cc.user_id">
                            <a class="button is-info is-outlined 
                            is-rounded" href="" 
                            @click.prevent="editComment(cc.id)">
                                <font-awesome-icon icon="edit"></font-awesome-icon>
                            </a>

                            <a class="button is-danger is-outlined 
                            is-rounded" href="" 
                            @click.prevent="delComment(cc.id)">
                                <font-awesome-icon icon="trash"></font-awesome-icon>
                            </a>
                        </span>
                        <!-- edit,delete button END -->

                    </div>
                    <!-- user info END -->

                </div><!-- end of div.column -->
            </div>
            <!-- div.columns show user detail END -->

            <!-- reply form START -->
            <div class="mb-4 mt-4" v-if="replyItem[cc.id]">

                <div class="field">
                    <div class="control">
                        <input v-model="rForm.r_title" 
                        placeholder="Title....." 
                        ref="r_title"
                        class="input" type="text" name="">
                    </div>
                </div>
               <div class="field">
                    <div class="control">
                        <jodit-editor 
                        v-model="rForm.r_body"></jodit-editor>
                    </div>

                    <!-- button status on reply form START -->
                    <div class="columns">
                        <div class="column">
                            <div class="field is-pulled-left">
                                <div v-html="res_status">
                                {{res_status}}
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field is-pulled-right">
                                <button class="button is-primary" 
                                type="submit" 
                                @click.prevent="saveReply(reply_id)">
                                <font-awesome-icon icon="check">
                                </font-awesome-icon>
                                </button>
                                <button class="button is-danger is-outlined" 
                                @click.prevent="hideReplyForm(cc.id)">
                                    <font-awesome-icon icon="times">
                                    </font-awesome-icon>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- button status on reply form END -->

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
        current_post_id:0,
        editId:0,
        comment_list:0,
        reply_list:0,
        reply_id:0,
        isCommentFormShow:false,
        replyItem:[],
        btnReply:true,
        rForm: new Form({
            r_title:'',
            r_body:'',
            comment_id: 0
        }),
        res_status:'',
        moment:moment,
        user_token:'',
        user_id:'',

    }},
    watch:{
        "postId":function(x){
            this.getPostById(x)
        }
    },
    mounted(){
        this.user_token = this.$cookies.get("token")
        this.current_post_id = this.$cookies.get("current_post_id")
        this.user_id = window.user_id
        this.checkIfUserHasToken()
    },
    methods:{
        getComment(page){
            this.res_status = ''
            
            let url = ''
            if(page){
                url = page+`&post_id=${this.post_id}`
                this.$cookies.set("pcm_old_page",url)
            }
            url = this.$cookies.get("pcm_old_page")
            if(!url) url = `/api/getcomment?post_id=${this.post_id}`
            axios.get(url)
                .then(res=>{
                    //console.log(res.data)
                    this.comment_list = res.data.comment
                    let c_title = ''
                    this.comment_list.data.forEach((cc)=>{
                        this.$cookies.set("current_post_id",cc.pivot.post_id)     

                    })
                })
        },
        saveReply(reply_id){
            let url = `/api/member/reply`
            let fData = new FormData()
            this.res_status = ''
            fData.append("r_title",this.rForm.r_title)
            fData.append("r_body",this.rForm.r_body)
            fData.append("post_id",this.post_id)
            fData.append("comment_id",this.rForm.comment_id)

            if(reply_id != 0){
                fData.append("_method","PUT")
                url = `/api/member/reply/${reply_id}`
            }
            axios.post(url,fData)
                .then(res=>{
                    this.res_status = res.data.msg
                    setTimeout(()=>{
                        this.clearReplyForm()
                        this.getComment()
                            },800)
                })
            .catch(err=>{
                this.res_status = `<span class="tag is-medium is-danger">
                ${Object.values(err.response.data.errors).join()}
                </span>`

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
            if(this.current_post_id != this.post_id){
                this.$cookies.set("current_post_id",x)
                this.$cookies.remove("pcm_old_page")
            }

            this.getComment()
        },
        checkIfUserHasToken(){
            this.isCommentFormShow = false
            if(this.user_token != null && window.user_id != undefined){
                this.isCommentFormShow = true
            }
        },
        clearReplyForm(){
            this.res_status = ''
            this.rForm.reset()
        },
        editComment(comment_id){

            this.editId = comment_id
        },
        delComment(comment_id){},
    },
}
</script>
