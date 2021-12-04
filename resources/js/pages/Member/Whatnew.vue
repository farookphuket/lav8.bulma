<template>
    <div>
            <div class="card">
                <div class="buttons is-right">
                    <button class="button is-outlined is-link" 
                    @click.prevent="isShow = true">
                        <font-awesome-icon icon="plus"></font-awesome-icon>
                    </button>
                </div>
            </div>

           <whatnew-form v-show="isShow" @getWhatnew="getWhatnew($event)" 
           @formToggle="formToggle($event)" 
           :editId="editId"></whatnew-form>

           <whatnew-list v-if="isShow == false" :wnList="wn" 
           @getWhatnew="getWhatnew($event)" 
           @edit="edit($event)" @del="del($event)"></whatnew-list>

        <!-- show model status START -->
        <div class="modal" :class="{'is-active':modalActive}">
          <div class="modal-background"></div>
          <div class="modal-content">
            <div class="card" >
                <div class="card-content" v-html="res_status">
                    {{res_status}}
                </div>

                <div class="field is-grouped is-grouped-right pr-2 pb-2">
                    <button class="button is-info is-outlined" 
                    @click.prevent="modalActive = ''">
                        <font-awesome-icon icon="check-circle"></font-awesome-icon>
                    </button>
                </div>

            </div>
          </div>
          <button class="modal-close is-large" aria-label="close" 
          @click.prevent="modalActive = ''"></button>
        </div>
        <!-- show model status END -->
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
             data(){
                 return{
                     isShow:false,
                     tk:'',
                     wn:'',
                     editId:0,
                     res_status:'',
                     modalActive:'',
                 }
             },
             mounted(){
                 this.tk = this.$cookies.get('token')
                 this.getWhatnew()
             },
methods:{
            getWhatnew(page){
                this.formToggle()
                let url = ''
                if(page){
                    url = page 
                    this.$cookies.set('mw_old_page',url)

                }
                url = this.$cookies.get('mw_old_page')
                if(!url) url = `/api/member/getwhatnew`
                let doc_title = ''
                axios.get(url)
                    .then(res=>{
       //                 console.log(res.data)
                        doc_title = res.data.meta_title 
                        this.wn = res.data.whatnew
                        document.title = doc_title
                    })
            },
            formToggle(){
                this.isShow = false
            },
            edit(id){
                this.isShow = true 
                this.editId = id
            },
            del(id){
                if(id != 0 && confirm(`Delete item id ${id}?`) == true){
                    let url = `/api/member/whatnew/${id}`
                    axios.delete(url)
                    .then(res=>{
                       this.modalActive = 'is-active' 
                        this.res_status = res.data.msg
                    })
                    setTimeout(()=>{
                        this.getWhatnew()
                            },2300)
                }
                return
            },
        },
}
</script>
