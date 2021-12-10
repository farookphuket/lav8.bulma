<template>
<div>

    <section class="section">
            <nav class="breadcrumb" aria-label="breadcrumbs">
              <ul>
                <li><a href="/admin/home">Home</a></li>
                <li class="is-active">
                    <a href="#" aria-current="page">About</a>
                </li>
              </ul>
            </nav>


            

    </section>
    <section class="section">

        <div class="mt-4 mb-6" v-if="isShowDefaultData == false">
            <div class="field is-pulled-right">
                <button class="button is-primary" 
                    @click.prevent="edit(aboutPage.id)">
                    <font-awesome-icon icon="edit"></font-awesome-icon>
                </button>

                <button class="button is-danger" 
                    @click.prevent="del(aboutPage.id)">
                    <font-awesome-icon icon="trash"></font-awesome-icon>
                </button>
            </div>
            <div v-html="aboutPage.p_body">{{aboutPage.p_body}}</div>
        </div>
        <div class="mt-4 mb-6" v-else>

          <h1 class="title">Admin Section</h1>
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
        <about-form :editId="editId" 
        @getAbout="getAbout($event)" @edit="edit($event)"></about-form>
    </section>
</div>

</template>

<script>
import AboutForm from './AboutForm.vue'

export default {
    name:"AdminAbout",
             components:{
                AboutForm,
             },
             data(){
                 return{
                    isShowDefaultData:true,
                    aboutPage:'',
                    editId:0,
                 }
             },
             mounted(){
                this.getAbout()
             },
methods:{
            getAbout(){
                this.isShowDefaultData = true
               let url = `/api/getabout` 
               axios.get(url)
               .then(res=>{
//                console.log(res.data)
                    this.aboutPage = res.data.about
                    if(this.aboutPage != null){
                        this.isShowDefaultData = false
                    } 
                   document.title = "Edit about page to suit your need"
                })
            },
            edit(id){
                this.editId = id
            },
    del(id){
        if(id && id != 0 && 
            confirm(`this will delete About page content?`) == true){
            let url = `/api/admin/post/${id}`
            axios.delete(url)
                .then(res=>{
                    alert(`The page content has been deleted!`)
                    this.getAbout()
                })
        }
    },
        },
}
</script>
