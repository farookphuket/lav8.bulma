<template>
<div>

    <section class="section">
            <nav class="breadcrumb" aria-label="breadcrumbs">
              <ul>
                <li><a href="/">Home</a></li>
                <li class="is-active">
                    <a href="#" aria-current="page">About</a>
                </li>
              </ul>
            </nav>
    </section>

    <section class="section" v-if="isShowDefaultData != true">
        <article class="box">
           <h2 class="title has-content-centered">
               {{aboutPage.p_title}} 
           </h2>
           <div v-html="aboutPage.p_body">
            {{aboutPage.p_body}}
           </div>
        </article>
    </section>
    <section class="section" v-else>

        <farook-about-page></farook-about-page>
    </section>
</div>

</template>

<script>
import FarookAboutPage from "./FarookAboutPage.vue"
export default {
    name:"AboutPage",
    components:{
        FarookAboutPage,
    },
             data(){
                 return{
                    isShowDefaultData:true,
                    aboutPage:'',
                 }
             },
             mounted(){
                this.getAbout()
             },
methods:{
            getAbout(){
               let url = `/api/getabout` 
               axios.get(url)
               .then(res=>{
                //console.log(res.data)
                    this.aboutPage = res.data.about         
                   if(this.aboutPage != null){
                       this.isShowDefaultData = false 
                   }
               })
            },
        },
}
</script>
