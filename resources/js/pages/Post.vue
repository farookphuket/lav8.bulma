<template>
<section class="section">
        <nav class="breadcrumb" aria-label="breadcrumbs">
          <ul>
            <li><a href="/">Home</a></li>
            <li class="is-active">
                <a href="#" aria-current="page">Posts</a>
            </li>
          </ul>
        </nav>

       <post-view></post-view>

</section>

</template>

<script>
import PostView from './PostView.vue'
export default{
    name:"Post",
             components:{
                 PostView,
             },
             data(){
                 return{

                 }
             },
methods:{
            post(url){
                alert(url)
            },
        }
}
</script>
