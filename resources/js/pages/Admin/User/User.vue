<template>
    <section class="section">
            <nav class="breadcrumb" aria-label="breadcrumbs">
              <ul>
                <li><a href="/admin/home">Home</a></li>
                <li class="is-active">
                    <a href="#" aria-current="page">User</a>
                </li>
              </ul>

            </nav>

            <div class="is-pulled-right">
                <button class="button is-outlined is-link">
                    <font-awesome-icon icon="plus"></font-awesome-icon>
                </button>
            </div>
            <user-form></user-form>
            <user-list :uList="uList"></user-list>
    </section>
</template>

<script>
import UserList from './UserList.vue'
import UserForm from './UserForm.vue'
export default{
    name:"AdminUser",
             components:{
                 UserList,
                 UserForm,
             },
             data(){return{
                 uList:'',
                 editId:0,
             }},
             mounted(){
                 this.getUser()
             },
methods:{
            getUser(page){
                let url = ''
                    if(page){
                        url = page
                        this.$cookies.set('auser_old_page',url)
                    }
                    url = this.$cookies.get('auser_old_page')
                    if(!url) url = `/api/admin/getuser`
                    axios.get(url)
                        .then(res=>{
                            console.log(res.data)
                            this.uList = res.data.user
                        })
            },
        }
}
</script>
