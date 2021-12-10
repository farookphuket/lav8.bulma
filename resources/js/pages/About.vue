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
    <section class="section">

        <div class="mt-4">

          <h1 class="title">Medium section</h1>
          <h2 class="subtitle">
            A simple container to divide your page into <strong>sections</strong>, like the one you're currently reading.
          </h2>
          <p>this is the default data to show in this page</p>
          <div class="content">
            <p>
                this is the tag in p tag div.content
            </p>
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
                console.log(res.data)
                       })
            },
        },
}
</script>
