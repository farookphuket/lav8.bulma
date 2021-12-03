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
           @formToggle="formToggle($event)"></whatnew-form>
           <whatnew-list v-if="isShow == false" :wnList="wn" 
           @getWhatnew="getWhatnew($event)"></whatnew-list>

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
                 }
             },
             mounted(){
                 this.tk = this.$cookies.get('token')
                 this.getWhatnew()
             },
methods:{
            getWhatnew(page){

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
        },
}
</script>
