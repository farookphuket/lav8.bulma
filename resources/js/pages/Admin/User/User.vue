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
            <div class="columns">
                <div class="column is-3">
                    <div class="content">

                        <button class="button is-outlined is-link" @click.prevent="showForm = true">
                            <font-awesome-icon icon="plus"></font-awesome-icon>
                            <span class="ml-2">Add new User</span>
                        </button>
                    </div>
                </div>
                <div class="column is-9">
                    <user-form :editId="editId" @closeForm="closeForm($event)" 
                    v-show="showForm" 
                    @getUser="getUser($event)"></user-form>

                    <user-list :uList="uList" @getUser="getUser($event)"
                    @edit="edit($event)" @del="del($event)" ></user-list>
                </div>
            </div>


        <div class="modal" :class="{'is-active':isShow}">
          <div class="modal-background"></div>
          <div class="modal-content">
              <div class="box">
                <div v-html="res_status">{{res_status}}</div>
              </div>

            <div class="field is-pulled-right ">
                <button class="button is-outlined is-success" 
                    @click.prevent="isShow = ''">
                    <font-awesome-icon icon="check"></font-awesome-icon>
                </button>
            </div>
          </div>
          <button class="modal-close is-large" aria-label="close" 
          @click.prevent="isShow = false"></button>
        </div>
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
                 showForm:false,
                 res_status:'',
                 isShow:'',
             }},
             mounted(){
                 this.getUser()
             },
methods:{
            getUser(page){
                this.closeForm()

                let url = ''
                    if(page){
                        url = page
                        this.$cookies.set('auser_old_page',url)
                    }
                    url = this.$cookies.get('auser_old_page')
                    if(!url) url = `/api/admin/getuser`
                    axios.get(url)
                        .then(res=>{
  //                          console.log(res.data)
                            this.uList = res.data.user
                        })
            },
            edit(id){
                this.editId = id
                this.showForm = true
            },
            del(id){
                if(id && id != 0 && confirm(`This will delete the user id ${id}`) == true){
                    let url = `/api/admin/user/${id}`
                    axios.delete(url)
                        .then(res=>{
                            this.res_status = res.data.msg
                            this.isShow = true
                            setTimeout(()=>{
                                this.isShow = ''
                                this.getUser()
                            },2000)
                        })
                        .catch(err=>{
                            console.log(err)
                        })
                }
                return
            },
            closeForm(){
                this.showForm = false
            },
        }
}
</script>
