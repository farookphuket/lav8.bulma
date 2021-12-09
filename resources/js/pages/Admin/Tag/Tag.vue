<template>
    <div>
       <div class="box">
            <div class="mb-4">
                <button class="button is-primary is-pulled-right is-small" 
                @click.prevent="isFormOpen = true">
                    <font-awesome-icon icon="plus"></font-awesome-icon>
                </button>
            </div>
            <ul class="tags">
                <li class="tag is-info"
                v-for="ta in tagList">
                    <span class="mr-2">
                        
                        {{ta.tag_name}}
                        
                    </span>
                    <button class="is-link is-medium" 
                    @click.prevent="edit(ta.id)">
                        <span class="ml-2">
                            <font-awesome-icon icon="edit"></font-awesome-icon>
                        </span>
                    </button>

                    <button class="delete is-medium" 
                    @click.prevent="del(ta.id)">
                        <font-awesome-icon icon="times"></font-awesome-icon>
                    </button>
                </li>
            </ul>
       </div>

       <tag-form v-show="isFormOpen" 
       @getTag="getTag($event)" :editId="editId"></tag-form>


       <!-- show modal -->
    
        <div class="modal" :class="{'is-active':isModalOpen}">
          <div class="modal-background"></div>
          <div class="modal-content">
            <div v-html="res_status">{{res_status}}</div>
          </div>
          <button class="modal-close is-large" aria-label="close" 
          @click.prevent="isModalOpen = ''"></button>
          <div class="columns">
              <div class="column">
                <div class="field is-pulled-right">
                    <button class="button is-success is-outlined" 
                    @click.prevent="isModalOpen = ''">
                        <font-awesome-icon icon="check"></font-awesome-icon>
                    </button>

                </div>
              </div>
          </div>
        </div>
       <!-- show modal -->
    </div>
</template>
<script>
import TagForm from './TagForm.vue'
export default{
name:"Tag",
         components:{
            TagForm,
         },
         data(){
             return{
                tagList:'',
                isFormOpen:false,
                editId:0,
                isModalOpen:false,
                res_status:'',
             }
         },
         mounted(){
            this.getTag()
         },
methods:{
            getTag(page){
                this.isFormOpen = false
                this.res_status = ''

                let url = ''
                    if(page){
                        url = page 
                        this.$cookies.set('atag_old_page',url)
                    }
                    url = this.$cookies.get('atag_old_page')
                    if(!url) url = `/api/admin/tag`
                    axios.get(url)
                        .then(res=>{
                        //console.log(res.data)
                        let rData = res.data
                        this.tagList = rData.tag_all
                    })
            },
            edit(id){
                this.isFormOpen = true
                this.editId = id
            },
            del(id){
                if(id && id != 0 && confirm(`this will delete tag id ${id}`) == true){
                    let url = `/api/admin/tag/${id}`
                    axios.delete(url)
                    .then(res=>{
                        this.res_status = res.data.msg
                        this.isModalOpen = 'is-activate'
                            })

                    setTimeout(()=>{
                        this.isModalOpen = ''
                        this.getTag()
                            },2500)
                }
                return
            },
            closeForm(){
                this.res_status = ''
                this.isFormOpen = false
            },
        },
}
</script>
