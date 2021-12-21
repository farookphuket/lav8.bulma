<template>
    
    <section class="section">
            <nav class="breadcrumb" aria-label="breadcrumbs">
              <ul>
                <li><a href="/admin/home">Home</a></li>
                <li class="is-active">
                    <a href="#" aria-current="page">Comment</a>
                </li>
              </ul>
            </nav>


            <!-- comment list START -->
            <comment-list></comment-list>
            <!-- comment list END -->


    </section>

</template>
<script>
import CommentList from './CommentList.vue'
export default{
    name:"AdminComment",
    components:{
        CommentList,
    },
}
</script>
