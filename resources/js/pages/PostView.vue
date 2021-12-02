<template>
<div>
    <div class="content">
        <h2 class="title has-text-centered">{{thePost.p_title}}</h2>
        <div class="box" v-html="thePost.p_excerpt">{{thePost.p_excerpt}}</div>
        <div class="box" v-html="thePost.p_body">{{thePost.p_body}}</div>
    </div>

</div>

</template>
<script>
export default{
    name:"PostView",
             data(){return{
                 theUrl:'',
                thePost:'',
             }},
             mounted(){
                 this.getUrl()
             },
methods:{
            getUrl(){
                this.theUrl = `/api/post${this.$route.path}`
                axios.get(this.theUrl)
                .then(res=>{
                    //console.log(res.data)
                    this.thePost = res.data.post
                    document.title = res.data.post.p_title
                        })
            },
        },
}
</script>
