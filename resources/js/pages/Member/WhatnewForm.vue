<template>
    <div>
        <div class="card">

            <div class="card-content">

            <form action="">

                <div class="field">
                    <label class="label" for="">what in your mind</label>
                    <div class="control" >
                        <jodit-editor 
                        v-model="wnForm.wn_body" 
                        height=450></jodit-editor>
                    </div>
                </div>

                <footer class="card-footer">
                    <div class="column">
                        <div class="is-pulled-left">
                            <p>show</p>
                        </div>
                        <div class="is-pulled-right">
                            <button class="button is-link" type="submit"
                            @click.prevent="makePost">Post</button>
                            <button class="button is-outlined is-danger" 
                            @click.prevent="$emit('formToggle')">cancel</button>
                        </div>
                    </div>
                </footer>

            </form>

            </div>
            
        </div>
    </div>
</template>
<script>
import JoditEditor from 'jodit-vue'
export default{
    name:"WhatnewForm",
             data(){
                 return{
                     isShow:'',
                     res_status:"",
                    wnForm:new Form({
                        wn_body:''
                                   }),
                    }
             },
             methods:{

             },
}
</script>
