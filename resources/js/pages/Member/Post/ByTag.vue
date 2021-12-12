<template>
    <div>

        <article class="box" v-for="ta in postList.data">
            <div class="field is-pulled-right">
                <button class="button is-outlined is-danger" 
@click.prevent="$emit('getPost')">
                    <font-awesome-icon icon="times"></font-awesome-icon>
                </button>
            </div>

            <h2 class="title has-text-centered">{{ta.tag_name}}</h2>
            <div class="content">
                <ol type="1">
                    <li v-for="po in ta.post">
                        <a href="" @click.prevent="openPost(po.slug)">
                            <span>{{po.p_title}}</span>

                            <span class="ml-2">
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
                    console.log(this.postList)
                        })
            },
            openPost(slug){
                let url = `/${slug}`
                location.href=url
            },
        },
}
</script>
