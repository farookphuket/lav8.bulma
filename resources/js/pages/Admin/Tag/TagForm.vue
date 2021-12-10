<template>
    <div>
        <div class="content box">
            <form action="">
                <div class="field">
                    <div class="control has-icons-right">
                        <input v-model="tForm.new_tag" class="input is-rounded" 
                        type="text" placeholder="Enter Tag Name..." 
                        @keydown.enter.prevent="saveTag(editId)" 
                        @keyup.prevent="calTag"
                        ref="new_tag">

                        <span class="icon is-left">
                            {{tForm.new_tag.length}}
                        </span>
                    </div>
                </div>
                
                <div class="field">
                    <div v-html="res_status">{{res_status}}</div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default{
name:"TagForm",
props:["editId"],
data(){
    return{
    res_status:'',
    isShowTagLength:false,
           tForm: new Form({
                new_tag:''
            }),
        }
},
watch:{
    "editId":function(x){
        this.getEditData(x)
    }
    },
methods:{
            getEditData(x){
            this.res_status = ''
            
                if(x != 0){
                    this.isShowTagLength = true
                    this.$refs.new_tag.focus()
                    let url = `/api/admin/tag/${x}`
                    axios.get(url)
                    .then(res=>{
                        //console.log(res.data)
                        let rData = res.data.tag
                        this.tForm.new_tag = rData.tag_name
                            })
                }
            },
            saveTag(id){
                let url = `/api/admin/tag`
                let data = new FormData()
                data.append("new_tag",this.tForm.new_tag)

                if(id){
                    url = `/api/admin/tag/${id}`
                    data.append("_method","PUT")
                }
                axios.post(url,data)
                    .then(res=>{
                        this.res_status = res.data.msg
                        setTimeout(()=>{
                            this.res_status = ''
                            this.tForm.reset()
                            this.$emit('getTag')
                                },1500)
                            })
                .catch(err=>{
                    this.res_status = `<span class="tag is-medium is-danger">
                    ${Object.values(err.response.data.errors).join()}
                    </span>`
                        })
            },
            calTag(){
                let nT = this.$refs.new_tag.value
                    if(nT != ''){
                        this.isShowTagLength = true
                    }
            },
        
},
}
</script>
