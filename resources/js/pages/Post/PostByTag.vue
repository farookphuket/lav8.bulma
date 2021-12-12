<template>
    <div>
        <article class="box" v-for="ta in tagContent.data">
            <div class="field is-pulled-right">
                <button class="button is-danger is-outlined" 
                @click.prevent="$emit('getPost')">
                    <font-awesome-icon icon="times"></font-awesome-icon>
                </button>
            </div>
            <h2 class="title has-text-centered">
                {{ta.tag_name}}
            </h2>
            <div class="content">
                <ol type="1" >
                    <li v-for="po in ta.post">
                        <a href="" @click.prevent="$emit('openPost',po.slug)">
                            <span class="ml-2">
                               {{po.p_title}} 
                            </span>
                            <span>
                                <font-awesome-icon icon="eye"></font-awesome-icon>
                            </span>
                        </a>
                    </li>
                </ol>
            </div>
        </article>
    </div>
</template>
<script>
export default{
    name:"ByTag",
    props:["tagId"],
    data(){return{
        tagContent:'',
    }},
    watch:{
        "tagId":function(){
            this.getTagOpen()
        }
    },
methods:{
            getTagOpen(page){
                let url = "" 
                    if(page){
                        url = page 
                        this.$cookies.set('p_old_tag_page',url)
                    }
                    url = this.$cookies.get('p_old_tag_page')
                    if(!url) url  = `/api/postbytag?tag_id=${this.tagId}`
                axios.get(url)
                .then(res=>{
                    //console.log(res.data)
                    this.tagContent = res.data.ta
                        })
            },
        },
}
</script>
