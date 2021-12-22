<template>
    <div>
        <div class="content mb-6 mt-4">
            <form action="">
                <div class="field">
                    <div class="control">
                        <input v-model="cForm.c_title" class="input" 
                        type="text" name="" placeholder="Title..."
                        ref="c_title" required>
                    </div>

                </div>

                <div class="field">
                    <div class="control">
                        <jodit-editor 
                            v-model="cForm.c_body" 
                            height=450></jodit-editor>
                    </div>
                </div>

                <!-- status,button START -->
                <div class="columns">
                    <div class="column">
                        <div v-html="res_status">{{res_status}}</div>
                    </div>

                    <div class="column">
                        <div class="field is-pulled-right">
                            <button class="button" type="submit" 
                                @click.prevent="saveC(comment_id)">
                                <font-awesome-icon icon="check"></font-awesome-icon>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- status,button END -->


            </form>
        </div>
    </div>
</template>
<script>
import JoditEditor from "jodit-vue"
export default{
    name:"CommentForm",
    props:["postId","editId"],
    data(){return{
        cForm: new Form({
            c_title:'',
            c_body: '',

        }),
        res_status:'',
        post_id:0,
        comment_id:0,
    }},
    mounted(){

    },
    watch:{
        "postId":function(x){
            this.getThePostData(x)
        },
        "editId":function(x){
            this.getEditData(x)
        }
    },
    methods:{
        getThePostData(x){
            this.post_id = x
        },
        getEditData(x){
            if(x != 0){
                this.$refs.c_title.focus()
                let url = `/api/member/comment/${x}`
                axios.get(url)
                .then(res=>{
                    //console.log(res.data.comment)
                    let rData = res.data.comment
                    this.cForm.c_title = rData.c_title 
                    this.cForm.c_body = rData.c_body
                    this.comment_id = rData.id 
           //         alert(`comment id ${this.comment_id}`)
                        })
            }
            return
        },
        saveC(id){
            let url = ""
            let fData = new FormData()
            fData.append("c_title",this.cForm.c_title)
            fData.append("c_body",this.cForm.c_body)
            fData.append("post_id",this.post_id)
            fData.append("comment_id",this.comment_id)


            if(id && id != 0){
//                alert(`edit comment id ${id}`)
                fData.append("_method","PUT")
                url = `/api/member/comment/${id}`
            }else{
                url = '/api/member/comment'

 //               alert(`in sert`)
            }

            
            axios.post(url,fData)
                .then(res=>{
                    this.res_status = res.data.msg
                    setTimeout(()=>{
                        this.clearForm()
                        this.$emit('getComment')
                    },1800)

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
