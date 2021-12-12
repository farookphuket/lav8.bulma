<template>
    <div>
        <article class="box" v-for="ca in category.data">
            <div class="field is-pulled-right">
                <button class="button is-outlined is-danger" 
                    @click.prevent="$emit('getPost')">
                    <font-awesome-icon icon="times"></font-awesome-icon>
                </button>
            </div>
            <h2 class="title has-text-centered">
                {{ca.cat_name}}
            </h2>

            <ul>
                <li v-for="po in ca.post">
                    <a href="" 
                    @click.prevent="openPost(po.slug)">
                        {{po.p_title}}
                    </a>

                </li>
            </ul>
        </article>
    </div>
</template>
<script>
export default{
    name:"ByCat",
    props:["catId"],
    data(){return{
        postList:'',
        category:'',
    }},
    watch:{
        "catId":function(){
            this.getByCat()
        }
    },
methods:{
            getByCat(page){

                let url = ''

                if(page){
                    url = page 
                    this.$cookies.set('p_bycat_old_page',url)
                }
                url = this.$cookies.get("p_bycat_old_page")
                if(!url) url = `/api/postbycat?cat_id=${this.catId}`

                axios.get(url)
                .then(res=>{
                    console.log(res.data)
                    this.category = res.data.category
                })
            },
            openPost(slug){
                let url = `/${slug}`
                location.href=url
            },
        },
}
</script>
