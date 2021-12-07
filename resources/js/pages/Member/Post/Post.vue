<template>
    <div>

        <section class="section">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                  <ul>
                    <li class="is-active">
                        <a href="/member/home">Home</a>
                    </li>
                  </ul>
                </nav>
        </section>

        <section class="section mt-4">

           <div class="columns">
               <div class="column is-3">
                    <a class="button is-primary is-block is-alt" href="#" 
                    @click.prevent="isFormOpen = true">New Post</a>

                    <aside class="mt-4 menu">
                        <p class="title">
                           Menu
                        </p>
                        <p class="subtitle">
                            show another menu here
                        </p>

                    </aside>
               </div>
               <div class="column is-9">
                    <post-form :editId="editId" v-show="isFormOpen" 
                    @getPost="getPost($event)" 
                    @formToggle="formToggle($event)"></post-form>

                   <post-list :postList="postList" @edit="edit($event)" 
                   @del="del($event)" @getPost="getPost($event)" ></post-list>
               </div>
           </div>
        </section>


        <div class="modal" :class="{'is-active':isModalOpen}">
          <div class="modal-background"></div>
          <div class="modal-content">
            <div class="content box">
                <div v-html="res_status" class="mb-6">{{res_status}}</div>
            </div>
          </div>
          <button class="modal-close is-large" aria-label="close" 
          @click.prevent="isModalOpen = ''"></button>

            <button class="button is-success is-outlined " 
            @click.prevent="isModalOpen=''">
                <font-awesome-icon icon="check"></font-awesome-icon>
            </button>

        </div>


    </div>
</template>
<script>
import PostForm from './PostForm.vue'
import PostList from './PostList.vue'
export default{
name:"MPost",
         components:{
            PostForm,
            PostList,
         },
         data(){return{
            editId:'',
            postList:'',
            res_status:'',
            isFormOpen:false,
            isModalOpen:'',
         }},
         mounted(){
            this.getPost()
         },
methods:{
            getPost(page){
                this.isFormOpen = false
                this.res_status = ''
                
                let url = ''
                    if(page){
                        url = page 
                        this.$cookies.set('mpost_old_page',url)
                    }
                    url = this.$cookies.get('mpost_old_page')
                    if(!url) url = `/api/member/getpost`
                    axios.get(url)
                        .then(res=>{

                        this.postList = res.data.post
                        document.title = res.data.meta_title
                    })
            },
            formToggle(){
                this.isFormOpen = false 

            },
            edit(id){
                this.editId = id
                this.isFormOpen = true
            },
            del(id){
                if(id && id != 0 && confirm(`this will delete your post id ${id} 
                            are your sure?`) == true){
                    let url = `/api/member/post/${id}`
                    axios.delete(url)
                    .then(res=>{
                        this.res_status = res.data.msg
                        this.isModalOpen = 'is-active'

                        setTimeout(()=>{
                            this.getPost()
                            this.res_status = ''
                            this.isModalOpen = ''
                                },750)
                    })
                }
                return
            },
        },
}
</script>
