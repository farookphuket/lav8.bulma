<template>
    <div>
        <div class="content">
            <form action="">
                <div class="field">
                    <div class="control">
                        <input v-model="cForm.cat_name" class="input" 
                        type="text" name="cat_name" 
                        placeholder="Enter category title..."
                        @keydown.enter.prevent="saveC(editId)">
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <div v-html="res_status">{{res_status}}</div>
                    </div>
                    <div class="column is-9">
                        <div class="filed is-pulled-right">
                            <button class="button">
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
            cat_name:''
           }),
           res_status:'',

         }},
methods:{
            saveC(id){
                let url = `/api/admin/category`
                    let fData = new FormData()
                    fData.append("cat_name",this.cForm.cat_name)

                    if(id){
                        url = `/api/admin/category/${id}`
                        fData.append("_method","PUT")
                    }
                    axios.post(url,fData)
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
        },
}
</script>
