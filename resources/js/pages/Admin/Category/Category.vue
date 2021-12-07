<template>
    <div>
    <section class="section">
            <nav class="breadcrumb" aria-label="breadcrumbs">
              <ul>
                <li class="is-active">
                    <a href="/admin/home">Home</a>
                </li>
              </ul>
            </nav>

            <category-form :editId="editId"
            @getCategory="getCategory($event)">
            </category-form>


            <category-list :catList="catList" 
            @edit="edit($event)" @del="del($event)" 
            @getCategory="getCategory"></category-list>

            <!-- show modal START -->
            <div class="modal" :class="{'is-active':isShowModal}">
              <div class="modal-background"></div>
              <div class="modal-content">
                <div class="box" v-html="res_status">
                   {{res_status}} 
                </div>

                  <div class="column is-pulled-right">
                    <button class="button is-link is-outlined" 
                    @click.prevent="isShowModal = ''">
                        <font-awesome-icon icon="check"></font-awesome-icon>
                    </button>
                  </div>
              </div>
              <button class="modal-close is-large" aria-label="close"></button>
            </div>
            <!-- show modal END -->
    </section>
    </div>

</template>
<script>
import CategoryList from './CategoryList.vue'
import CategoryForm from './CategoryForm.vue'
export default{
name:"AdminCategory",
         components:{
            CategoryList,
            CategoryForm,
         },
         data(){return{
            catList:'',
            editId:0,
            isShowModal:'',
         }},
         mounted(){
            this.getCategory()
         },
methods:{
            getCategory(page){
                this.isShowModal = ''
                let url = ''
                    if(page){
                        url = page
                        this.$cookies.set("acat_old_page",url)
                    }
                url = this.$cookies.get("acat_old_page")
                if(!url) url = `/api/admin/getcategory`
                axios.get(url)
                .then(res=>{
                    console.log(res.data)
                    this.catList = res.data.category
                })
            },
            edit(id){
                this.editId = id
            },
            del(id){
                if(id && id != 0 && confirm(`This will delete category id ${id} 
                            are you sure?`) == true){
                     let url = `/api/admin/category/${id}`
                     axios.delete(url)
                     .then(res=>{
                        this.res_status = res.data.msg
                        this.isShowModal = 'is-active'
                             })
                }
            },
        },
}
</script>
