<template>
    <div>
        <section class="section">
            <nav class="breadcrumb" aria-label="breadcrumbs">
              <ul>
                <li><a href="/admin/home">Home</a></li>
                <li class="is-active">
                    <a href="#" aria-current="page">Template</a>
                </li>
              </ul>
            </nav>
        </section>
        <section class="content">
            <div class="columns">
                <div class="column is-3">
                    <a class="button is-primary is-block is-alt" href="#" 
                    @click.prevent="isFormOpen = true">New Template</a>
                </div>


                <div class="column is-9">
                    <div class="field is-pulled-right mb-4">
                        <button class="button is-primary is-rounded 
                        is-small"  
                        @click.prevent="isFormOpen=true"  
                        v-if="isFormOpen == false">
                            <font-awesome-icon icon="plus"></font-awesome-icon>
                        </button>
                        <button class="button is-danger is-rounded 
                        is-small" 
                        @click.prevent="isFormOpen = false" 
                        v-else>
                            <font-awesome-icon 
                            icon="times"></font-awesome-icon>
                        </button>
                    </div>

                    <template-form v-show="isFormOpen" 
                    :editId="editId" 
                    @getTemplate="getTemplate($event)"></template-form>

                    <template-list 
                    :tem_num="tem_num" :tem_list="tem_list" 
                    @getTemplate="getTemplate($event)" 
                    @edit="edit($event)" 
                    @del="del($event)"></template-list>
                </div>
            </div>


        </section>
    </div>

</template>
<script>
import TemplateForm from './TemplateForm.vue'
import TemplateList from './TemplateList.vue'
export default{
    name:"AdminTemplate",
             components:{
                 TemplateForm,
                 TemplateList,
             },
             data(){return{
                 tem_list:'',
                 tem_num:'',
                 isFormOpen:false,
                 res_status:'',
                 editId:0,
             }},
             mounted(){
                 this.getTemplate()
             },
methods:{
            getTemplate(page){
                this.getRefresh()
                
                let url = ''
                if(page){
                    url = page 
                    this.$cookies.set('atm_old_page',url)
                }
                url = this.$cookies.get('atm_old_page')
                if(!url) url = `/api/gettemplate`
                axios.get(url)
                    .then(res=>{
                        this.tem_list = res.data.template
                        this.tem_num = Object.values(res.data.template.data).length
                            })
                document.title = `Manage Template`
            },
            getRefresh(){
                this.res_status = ''

            },
        },
}
</script>
