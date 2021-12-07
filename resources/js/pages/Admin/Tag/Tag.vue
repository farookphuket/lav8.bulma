<template>
    <div>
       <div class="box">
            <ul class="tags">
                <li class="tag is-info"
                v-for="ta in tagList">{{ta.tag_name}}</li>
            </ul>
       </div>
    </div>
</template>
<script>
export default{
name:"Tag",
         data(){
             return{
                tagList:'',

             }
         },
         mounted(){
            this.getTag()
         },
methods:{
            getTag(page){
                let url = ''
                    if(page){
                        url = page 
                        this.$cookies.set('atag_old_page',url)
                    }
                    url = this.$cookies.get('atag_old_page')
                    if(!url) url = `/api/admin/tag`
                    axios.get(url)
                        .then(res=>{
                        console.log(res.data)
                        let rData = res.data
                        this.tagList = rData.tag_all
                                })
            },
        },
}
</script>
