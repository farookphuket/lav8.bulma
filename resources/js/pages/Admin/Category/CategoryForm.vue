<template>
    <div>
        <div class="content">
            <form action="">
                <div class="field">
                    <div class="control">
                        <input v-model="cForm.cat_name" class="input" 
                        type="text" name="cat_name" ref="cat_name"
                        placeholder="Enter category title..." 
                        @keyup.prevent="setSlug"
                        @keydown.enter.prevent="saveC(editId)">
                    </div>

                </div>
                <div class="field" v-show="isShowSlug">
                    <p class="pt-2 has-text-success">
                        <b>
                            {{theSlug.thaiSlug(cForm.cat_name)}} ({{cForm.cat_name.length}})
                        </b>
                    </p>
                </div>

                <div class="columns">
                    <div class="column">
                        <div v-html="res_status">{{res_status}}</div>
                    </div>
                    <div class="column is-9">
                        <div class="filed is-pulled-right">
                            <button class="button is-success is-outlined" 
                            type="submit" @click.prevent="saveC(editId)">
                                <font-awesome-icon icon="check"></font-awesome-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default{
name:"CategoryForm",
props:["editId"],
         data(){return{
            cForm:new Form({
                cat_name:'',
                cat_method:'',
            }),
            res_status:'',
            tk:'',
            theSlug: new CustomText(),
            isShowSlug:false,
         }},
watch:{
          "editId":function(x){
            this.getEditData(x)
          }
      },
      mounted(){
        this.tk = this.$cookies.get('token')
      },
methods:{
            getEditData(x){
                this.res_status = ''
                if(x != 0){
                    this.$refs.cat_name.focus()
                    this.isShowSlug = true
                    let url = `/api/admin/category/${x}`
                    axios.get(url)
                    .then(res=>{
                        let rData = res.data.category
                        this.cForm.cat_name = rData.cat_name
                        this.cForm.cat_method = rData.cat_method
                    })
                }
            },
            saveC(id){
                let url = `/api/admin/category`
                    let fData = new FormData()
                    fData.append("cat_name",this.cForm.cat_name)
                    fData.append("cat_method",this.cForm.cat_method)

                    if(id){
                        url = `/api/admin/category/${id}`
                        fData.append("_method","PUT")
                    }
                axios.post(url,fData,{
                headers:{"Authorization":`Basic ${this.tk}`}
                        })
                        .then(res=>{
                            //console.log(res.data)
                            this.res_status = res.data.msg
                            setTimeout(()=>{
                                this.clearForm()
                                this.$emit('getCategory')
                             },2300)
                         })
                    .catch(err=>{
                         this.res_status = `<span class="tag is-medium is-danger">
                         ${Object.values(err.response.data.errors).join()}
                         </span>`
                    })
            },
            clearForm(){
                this.res_status = ''
                this.cForm.reset()
            },
            setSlug(){
                this.isShowSlug = false
                if(this.$refs.cat_name.value != ''){
                    this.isShowSlug = true                
                    this.cForm.cat_method = this.theSlug.thaiSlug(this.cForm.cat_name)
                }
            },
        },
}
</script>
