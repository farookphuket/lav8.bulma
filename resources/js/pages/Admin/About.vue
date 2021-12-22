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

    <!-- has about data section START -->
    <section v-if="isShowDefaultData == false && isEditing == false">

        <article class="box">
            <!-- edit ,delete button START --> 
            <div class="columns">
                <div class="column">
                    <div class="field is-pulled-right">
                        <button class="button is-primary is-outlined is-small" 
                            @click.prevent="edit(aboutPage.id)">
                            <font-awesome-icon icon="edit"></font-awesome-icon>
                        </button>

                        <button class="button is-warning is-outlined is-small" 
                            @click.prevent="del(aboutPage.id)">
                            <font-awesome-icon icon="trash"></font-awesome-icon>
                            <span class="ml-2">use default data</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- edit ,delete button START --> 

            <div v-html="aboutPage.p_body">
                {{aboutPage.p_body}}
            </div>
        </article>

    </section>
    <!-- has about data section START -->

    <!-- default data section START -->
    <section class="section" v-show="isShowDefaultData">
        <!-- button on the right START -->
        <div class="columns">
            <div class="column">
                <div class="field is-pulled-right">
                    <button class="button is-primary is-outlined is-small" 
                        @click.prevent="isEditing = true" 
                        v-if="isEditing == false">
                        <font-awesome-icon icon="edit"></font-awesome-icon>
                    </button>
                    <button class="button is-danger is-outlined is-small" 
                        @click.prevent="isEditing = false" v-else>
                        <font-awesome-icon icon="times"></font-awesome-icon>
                    </button>
                </div>
            </div>
        </div>
        <!-- button on the right END -->
        <farook-about-page v-if="isEditing != true"></farook-about-page>
    </section>
    <!-- default data section END -->

    <!-- form Section START -->
    <section v-show="isEditing">
        <about-form :editId="editId" 
            @getAbout="getAbout($event)"></about-form>
    </section>
    <!-- form Section END -->

</div>

</template>

<script>
import FarookAboutPage from "../FarookAboutPage.vue"
import AboutForm from './AboutForm.vue'

export default {
    name:"AdminAbout",
             components:{
                AboutForm,
                 FarookAboutPage,
             },
             data(){
                 return{
                    isShowDefaultData:true,
                     isEditing:false,
                    aboutPage:'',
                    editId:0,
                 }
             },
             mounted(){
                this.getAbout()
             },
methods:{
            getAbout(){
                this.isEditing = false
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
                this.isEditing = true
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
