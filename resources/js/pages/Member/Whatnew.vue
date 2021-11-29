<template>
    <div class="card">
            <div class="buttons is-right">
                <button class="button is-link" 
                @click.prevent="isShow = true">+</button>
            </div>

           <whatnew-form v-show="isShow" 
           @formToggle="formToggle($event)"></whatnew-form>

    </div>
</template>
<script>
import WhatnewForm from './WhatnewForm.vue'
export default{
    name:"Whatnew",
             components:{
                 WhatnewForm,
             },
             data(){
                 return{
                     isShow:false,
                 }
             },
methods:{
            makePost(){
                alert('tes')
            },
            formToggle(){
                this.isShow = false
            },
        },
}
</script>
