<template>
    <div>
        <article class="box" >
           {{tagId}} 
        </article>
    </div>
</template>

<script>
export default{
    name:"ByTag",
    props:["tagId"],
             data(){return{
                postList:'',
             }},
             mounted(){

             },
watch:{
          "tagId":function(){
              this.getByTag()
          }
      },
methods:{
            getByTag(){
                let tag_id = this.tagId
                let url = `/api/postbytag?tag_id=${tag_id}`
                axios.get(url)
                .then(res=>{
                    this.postList = res.data.ta
                    console.log(res.data)
                        })
            },
        },
}
</script>
