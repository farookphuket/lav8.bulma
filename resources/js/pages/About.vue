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

        <div class="box">

          <h1 class="title">
            see-southern.com
          </h1>
          <h2 class="subtitle">
            see-southern.com has create on Oct 2007              
          </h2>
          <div class="content">
              <p>
                when I try to learn to code
                 in php at my first place the very first 
                <strong>
                    "Hello world"
                </strong>
                 line has start written on 
                 <strong>Ubuntu 7.04</strong> while I am just about to really 
                 have to get my head (my computer) out of my belove 
                 "window XP" as many  people has been try 
                <span class="tag is-medium is-warning">
                    "window Vista"
                </span> and have to very impress experience on it (you maybe 
                one of them too) so it's the time for me to move on to learn 
                something new "Ubuntu" is the very first Linux that I have give 
                it a try and love it at the very first try Ubuntu can cause me 
                a lot of headache but you know? it's some new experience so 
                why not? let do it. 

              </p>
                <p>
                    today my computer is fully run "Arch Linux" and I am really 
                    really fall in love with this! it is just my feeling 
                    "like home" again.
                </p>
                <p>
                    # I am an Arch Noob.
                </p>

          </div>
        </div>


        <div class="columns">
            <div class="column">
                <figure class="is-flex is-justify-content-center">
                    <a href="https://i.ibb.co/GVgKNzX/farook-year2021.jpg" 
                        target="_blank">
                        <img src="https://i.ibb.co/GVgKNzX/farook-year2021.jpg" 
                    alt="farook on year 2021" class="responsive">
                    </a>

                </figure>
                <p class="has-text-centered">
                    farook on year 2021
                </p>
            </div>

            <div class="column">
                <figure class="is-flex is-justify-content-center">
                    <a href="https://i.ibb.co/zxBw2yY/farook-year2011.jpg" 
                        target="_blank">
                        <img src="https://i.ibb.co/zxBw2yY/farook-year2011.jpg" 
                        alt="farook on year 2011" class="responsive">
                    </a>
                </figure>
                <p class="has-text-centered">
                    farook on year 2011
                </p>
            </div>


            <div class="column">
                <figure class="is-flex is-justify-content-center">
                    <a href="https://i.ibb.co/18xQmdJ/farook-year2009.jpg" 
                        target="_blank">
                        <img src="https://i.ibb.co/18xQmdJ/farook-year2009.jpg" 
                        alt="farook on year 2009" class="responsive">
                    </a>
                </figure>
                <p class="has-text-centered">
                    farook on year 2009
                </p>
            </div>




            <div class="column">
                <figure class="is-flex is-justify-content-center">
                    <a href="https://i.ibb.co/BzZ5HNL/farook-year2007-2.jpg" 
                        target="_blank">

                        <img src="https://i.ibb.co/BzZ5HNL/farook-year2007-2.jpg" 
                        alt="farook on year 2007 " class="responsive">
                    </a>

                </figure>
                <p class="has-text-centered">
                    farook on year 2007
                </p>
            </div>
            <div class="column">
                <figure class="is-flex is-justify-content-center">
                    <a href="https://i.ibb.co/PcS56LN/farook-year2007.jpg" 
                        target="_blank">
                        <img src="https://i.ibb.co/PcS56LN/farook-year2007.jpg" 
                        alt="farook on year 2006" class="responsive">
                    </a>
                </figure>
                <p class="has-text-centered">
                    farook on year 2006
                </p>
            </div>



        </div>

        <div class="columns">
            <div class="column">
                <h2 class="title">
                    How to create my own about page?
                </h2>
                <div class="box">
                    <p class="mt-4 mb-2">
                        this is the default page if you want to edit this page simply 
                        login with your "admin" credentials select "about" from the 
                        menu then you can add your stuff in the text box then click 
                        save the button that's it!
                    </p>
                </div>
            </div>

            <div class="column">
                <h2 class="title">
                    Where is this file
                </h2>
                <div class="box">
                    <p>
                        to totally edit this file `/resources/js/pages/About.vue` open 
                        you text editor program you will find this section.
                    </p>
                </div>
            </div>

        </div>

    </section>
</div>

</template>

<script>
export default {
    name:"AboutPage",
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
