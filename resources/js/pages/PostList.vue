<template>
    <div class="content">
       <div class="box mt-2" v-for="po in postList.data">
            <h2 class="has-text-centered">
                <a href="" @click.prevent="openPost(po.slug)">
                    {{po.p_title}}
                </a>
            </h2>
            <p>
                <span class="icon">
                    <span class="icon-text">
                        <font-awesome-icon icon="eye"></font-awesome-icon>
                    </span>
                    <span>Read</span>
                </span>
            </p>
            <div v-html="po.p_excerpt">{{po.p_excerpt}}</div>
       </div>
    </div>
</template>

<script>
export default{
    name:"PostList",
    props:["postList"],
    methods:{
        openPost(slug){
            let url = `/${slug}`
            window.location.href=url
        },
    },
}
</script>
