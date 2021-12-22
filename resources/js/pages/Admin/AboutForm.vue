<template>
<div>
    <div class="content box mb-6 mt-4" v-show="isShowPreview" 
        v-html="abForm.p_body">
        {{abForm.p_body}} 
    </div>
    <div class="box content">
        <form action="">
            <div class="field">
                <div class="control">
                    <input v-model="abForm.p_title" class="input" type="text" 
                    name="p_title" 
                    ref="p_title" disabled>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <jodit-editor 
                    height=450 
                    v-model="abForm.p_body"></jodit-editor>
                </div>
            </div>


            <div class="columns">
                <div class="column is-3">
                    <div class="field is-pulled-left">
                        <div v-html="res_status">{{res_status}}</div>
                    </div>
                </div>
                <div class="column is-9">
                    <div class="field is-pulled-right">
                        <button class="button is-primary is-outlined 
                        is-small is-rounded" 
                        @click.prevent="save(editId)">
                            <font-awesome-icon icon="check"></font-awesome-icon>
                        </button>
                        <button class="button is-danger is-outlined 
                        is-small is-rounded" 
                        @click.prevent="$emit('getAbout')">
                            <font-awesome-icon icon="times"></font-awesome-icon>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>

</template>

<script>
import JoditEditor from 'jodit-vue'
export default {
    name:"AboutForm",
    props:["editId"],
             data(){
                 return{
abForm: new Form({
   p_title:'about',
   p_body:'',
                }),
                res_status:'',
                isShowPreview : false,
                 }
             },
    watch:{
        "editId":function(x){
            this.getEditData(x)
        }
    },
             mounted(){
                this.firstLoad()
             },
methods:{
    firstLoad(){
        this.res_status = ''
        this.abForm.reset()
        this.abForm.p_title = "about"
        this.isShowPreview = true
    },
    getEditData(x){
        if(x != 0){
            let url = `/api/admin/post/${x}`
            axios.get(url)
                .then(res=>{
                   // console.log(res.data)
                    this.abForm.p_body = res.data.post.p_body
                })
        }
    },
            save(id){
                let url = `/api/admin/about`
                let data = new FormData()
                data.append("p_title",this.abForm.p_title)
                data.append("p_body",this.abForm.p_body)

                if(id){
                    data.append("_method","PUT")
                    url = `/api/admin/about/${id}`
                }

                axios.post(url,data)
                    .then(res=>{
                        this.res_status = res.data.msg
                        setTimeout(()=>{
                            this.res_status = ''
                            this.firstLoad()
                            this.$emit('getAbout')
                                },2300)
                            })
                .catch(err=>{
                    this.res_status = `<span class="tag is-medium is-danger">
                    ${Object.values(err.response.data.errors).join()} 
                    </span>`
                        })

            },
        },
}
</script>
