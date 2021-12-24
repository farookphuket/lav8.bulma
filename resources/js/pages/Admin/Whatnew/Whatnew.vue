<template>
    <div class="columns is-multiline ">

            <div class="column is-3">

                    <a class="button is-primary is-block is-alt" href="#" 
                    @click.prevent="showForm = true">New Post</a>

                <!-- side menu left START -->
                    <aside class="mt-4 menu">
                        <p class="title">
                           Menu
                        </p>


                    </aside>
                <!-- side menu left END -->

            </div>
            <div class="column is-9">

            <whatnew-form v-show="showForm" @closeForm="closeForm($event)"
            :editId="editId" @getWhatnew="getWhatnew($event)" 
            ></whatnew-form>

            <whatnew-list :wnList="wnList" 
            @getWhatnew="getWhatnew($event)" @edit="edit($event)" 
            @del="del($event)"></whatnew-list>

            </div>

        <div class="modal" :class="{'is-active':isShow}">
          <div class="modal-background"></div>
          <div class="modal-content">
            <div v-html="res_status">{{res_status}}</div>
          </div>
          <button class="modal-close is-large" aria-label="close" 
          @click.prevent="isShow = false"></button>
          <div class="columns">
              <div class="column">
                <div class="field is-pulled-right">
                    <button class="button is-success is-outlined" 
                    @click.prevent="isShow = ''">
                        <font-awesome-icon icon="check"></font-awesome-icon>
                    </button>

                </div>
              </div>
          </div>
        </div>

    </div>
</template>

<script>
import WhatnewForm from './WhatnewForm.vue'
import WhatnewList from './WhatnewList.vue'
export default{
    name:"Whatnew",
             components:{
                 WhatnewForm,
                 WhatnewList,
             },
             data(){return{
                 showForm:false,
                 wnList:'',
                 editId:0,
                 isShow:'',
                 res_status:'',
             }},
         mounted(){
            this.tk = this.$cookies.get("token")
            this.getWhatnew()
         },
methods:{
            getWhatnew(page){
                this.wnList = ''
                this.editId = 0

                let url = ''
                    if(page){
                        url = page 
                        this.$cookies.set('awn_old_page',url)
                    }
                    url = this.$cookies.get('awn_old_page')
                    if(!url) url = `/api/admin/getwhatnew`
                        axios.get(url,{
                            headers:{"Authorization":`Basic ${this.tk}`}
                                })
                    .then(res=>{
                        //console.log(res.data)
                        this.wnList = res.data.whatnew
                        document.title = res.data.meta_title
                            })
            },
            edit(id){
                this.showForm = true
                this.editId = id
            },
            del(id){
                this.isShow = ''
                if(id != 0){
                    if(confirm(`Do you want to delete the id ${id}?`) == true){
                        let url = `/api/admin/whatnew/${id}`
                            axios.delete(url,{
                                headers:{"Authorization":`Basic ${this.tk}`}
                                    })
                        .then(res=>{
                            //console.log(res.data)
                            this.isShow = 'is-active' 
                            this.res_status = res.data.msg
                            setTimeout(()=>{
                                this.closeBox()
                                    },1200)
                                })
                    }
                }else{
                    return
                }
                
            },
            closeBox(){
                this.isShow = '' 
                
                this.res_status = ''
                    setTimeout(()=>{
                        this.getWhatnew()
                            },3200)
            },
            closeForm(){
                this.showForm = false
            },
        },
}
</script>
