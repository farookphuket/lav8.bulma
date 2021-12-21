<template>
    <div>

        <!-- show list of comment START -->
        <article class="box" v-for="cm in comment_list.data">

            <h2 class="title">{{cm.c_title}}</h2>

            <!-- delete button START -->

            <div class="columns">
                <div class="column">
                    <div class="field is-pulled-right">
                        <a class="button is-danger is-outlined is-rounded 
                        is-small" 
                            href="" @click.prevent="delComment(cm.id)">
                            <font-awesome-icon icon="trash"></font-awesome-icon>
                        </a>
                    </div>
                </div>
            </div>
            <!-- delete button END -->

            <div class="content" v-html="cm.c_body">
                {{cm.c_body}}
            </div>
            <!-- show link to post,comment's owner,comment date ,reply length START -->
            <div class="columns is-mobile">
                <div class="column">
                    <div class="field is-pulled-left">
                        post : 
                        <span class="subtitle" 
                            v-for="p in cm.post">

                            <span class="tag is-medium">
                                <a href="" class="has-text-info" 
                                    @click.prevent="openItOrgPost(p.slug)">
                                    <b>

                                        {{p.p_title}}
                                    </b>

                                    <span class="ml-2">
                                     <font-awesome-icon icon="external-link-alt">
                                     </font-awesome-icon>
                                    </span>
                                </a>

                            </span>

                        </span>

                        <!-- created at START -->
                        <span class="mr-2 has-text-primary">
                            <font-awesome-icon icon="calendar-day"></font-awesome-icon>
                        </span>
                        <span class="mr-2">
                            <a href="" class="has-text-success"
                                :title="moment(cm.created_at)">
                                {{moment(cm.created_at).fromNow()}}
                            </a>

                        </span>
                        <!-- created at END -->
                    </div>

                    <div class="field is-pulled-right">


                        <!-- comment's owner START -->
                        <span class="ml-2">
                            <font-awesome-icon icon="user"></font-awesome-icon>
                        </span>
                        <span class="mr-2">
                            {{cm.user.name}}
                        </span>
                        <!-- comment's owner END -->
                        <!-- reply length -->
                        <span class="mr-2">
                            <a class="is-success" href="" 
                                title="show reply form"
                                @click.prevent="getReplyFormSet(cm.id)">
                                <font-awesome-icon icon="reply">
                                </font-awesome-icon> reply
                                
                            </a>

                        </span>
                        <span class="ml-2">
                            <font-awesome-icon icon="eye">
                            </font-awesome-icon> 
                            <a href="" title="click to show"
                                @click.prevent="showReplyItem(cm.id)">
                                {{cm.reply.length}} replies
                            </a>
                            
                        </span>
                        <!-- reply length -->

                    </div>
                </div>
            </div>
            <!-- show owner,comment date ,reply length START -->


            <!-- show reply form START -->
            <div v-if="replyFormItem[cm.id]">
                <div class="columns">
                    <div class="column">
                        <div class="field is-pulled-right">
                            <button class="button is-danger is-rounded 
                                is-small" 
                                @click.prevent="hideReplyForm(cm.id)">
                                <font-awesome-icon icon="times"></font-awesome-icon>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="content">
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
                                <jodit-editor v-model="rForm.r_body" 
                                    height=435></jodit-editor>
                            </div>
                        </div>

                        <!-- button START -->
                        <div class="columns">
                            <div class="column">
                                <div class="field is-pulled-right">
                                    <button class="button is-primary is-outlined" 
                                        @click.prevent="saveReply(reply_id)">
                                        <font-awesome-icon icon="check"></font-awesome-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- button END -->

                    </form>
                </div>

            </div>
            <!-- show reply form END -->

            <!-- show reply item START -->
            <div v-if="replyItem[cm.id]">
                <div class="columns">
                    <div class="column">
                        <div class="field is-pulled-right">
                            <a href="" class="button is-danger is-outlined 
                                       is-small is-rounded" 
                                @click.prevent="hideReplyItem(cm.id)">
                                <font-awesome-icon icon="times"></font-awesome-icon>
                            </a>
                        </div>
                    </div>
                </div>

                <article class="box" v-for="re in cm.reply">
                    <button class="button is-danger is-rounded is-small 
                        is-outlined is-pulled-right" 
                        @click.prevent="delMyReply(re.id)">
                        <font-awesome-icon icon="trash"></font-awesome-icon>
                    </button>
                    <h2 class="title">{{re.r_title}}</h2>

                    <div class="content" v-html="re.r_body">
                        {{re.r_body}}
                    </div>
                    <!-- show user info ,date created START -->
                    <div class="columns is-mobile">
                        <div class="column">
                            <div class="field is-pulled-right">
                                <span class="mr-2">
                                    <font-awesome-icon icon="calendar-day"></font-awesome-icon>
                                </span>
                                <span>
                                    {{moment(re.created_at)}}
                                </span>
                                <span class="ml-2 mr-2">
                                    {{moment(re.created_at).fromNow()}}
                                </span>
                                <span class="mr-2 has-text-success">
                                    <font-awesome-icon icon="user"></font-awesome-icon>
                                </span>
                                <span>
                                    {{re.user.name}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- show user info ,date created START -->
                </article>
            </div>
            <!-- show reply item END -->



        </article>
        <!-- show list of comment END -->

        

        <!-- show modal START -->

        <div class="modal " :class="{'is-active':isModalShow}">
          <div class="modal-background"></div>
          <div class="modal-content">
            <div class="content box">
                <div v-html="res_status" class="mb-6">{{res_status}}</div>
            </div>
          </div>
          <button class="modal-close is-large" aria-label="close" 
          @click.prevent="isModalShow = ''"></button>

            <button class="button is-success is-outlined " 
            @click.prevent="isModalShow=''">
                <font-awesome-icon icon="check"></font-awesome-icon>
            </button>

        </div>
        <!-- show modal END -->

    </div>
</template>
<script>
var moment = require('moment')
import JoditEditor from 'jodit-vue'

export default{
    name:"CommentList",
    data(){return{
        moment:moment,
        comment_list:0,
        replyFormItem:[],
        replyItem:[],
        reply_id:0,
        post_id:0,
        res_status:'',
        isModalShow:'',
        rForm: new Form({
            r_title:'',
            comment_id:'',
            post_id:'',
            r_body:''
        }),
    }},
    mounted(){
        this.getComment()
    },
    methods:{
        getComment(page){
            let url = ''
            if(page){
                url = page 
                this.$cookies.set('acm_old_page',url)
            }
            url = this.$cookies.get('acm_old_page')
            if(!url) url = `/api/admin/getcomment`
            axios.get(url)
                .then(res=>{
                    //console.log(res.data)
                    this.comment_list = res.data.comment

                })
        },
        getReplyFormSet(comment_id){

            let cm_data = this.comment_list.data
            cm_data.forEach((cm)=>{
                if(cm.id == comment_id){
                    cm.post.forEach((po)=>{
                        //console.log(po.p_title)
                        this.post_id = po.id
                        this.rForm.post_id = po.id
                    })
                }
            })
            this.rForm.comment_id = comment_id
            this.showReplyForm(comment_id)
        },
        openItOrgPost(slug){
            let url = `/${slug}`
            location.href=url
        },
        delComment(id){
            if(id && id != 0 && 
                confirm(`delete comment id ${id} ?`) == true){
                let url = `/api/admin/comment/${id}` 
                axios.delete(url)
                    .then(res=>{
                        this.res_status = res.data.msg
                        this.isModalShow = 'is-active' 

                        setTimeout(()=>{
                            this.isModalShow = ''
                            this.res_status = ''
                            this.getComment()
                        },2500)
                    })
            }
            return
        },
        saveReply(reply_id){

            this.res_status = ''
            let url = '/api/admin/reply'
            let fData = new FormData()
            fData.append("r_title",this.rForm.r_title)
            fData.append("r_body",this.rForm.r_body)
            fData.append("comment_id",this.rForm.comment_id)
            fData.append("post_id",this.rForm.post_id)

            if(reply_id){
                url = `/api/admin/reply/${reply_id}`
                fData.append("_method","PUT")
            }

            axios.post(url,fData)
                .then(res=>{
                    this.res_status = res.data.msg
                    setTimeout(()=>{
                        this.rForm.reset()
                        this.getComment()
                    },2300)
                })
                .catch(err=>{
                    this.res_status = `<span class="tag is-medium is-danger">
                        ${Object.values(err.response.data.errors).join()}
                    </span>`
                })
            this.isModalShow = 'is-active'

        },
        delMyReply(reply_id){
            this.res_status = ''
            if(reply_id && reply_id != 0 && 
                confirm(`delete reply id ${reply_id} ?`) == true){
                let url = `/api/admin/reply/${reply_id}`
                axios.delete(url)
                    .then(res=>{
                        this.res_status = res.data.msg 
                        this.isModalShow = 'is-active' 
                        setTimeout(()=>{
                            this.isModalShow = ''
                            this.getComment()
                        },3200)
                    })
            }
            return
        },
        showReplyForm(id){
            this.rForm.comment_id = id
            this.$set(this.replyFormItem,id,true)
        },
        hideReplyForm(id){

            this.rForm.comment_id = 0
            this.$set(this.replyFormItem,id,false)
        },
        showReplyItem(id){
            this.$set(this.replyItem,id,true)
        },
        hideReplyItem(id){
            this.$set(this.replyItem,id,false)
        },
    },
}
</script>
