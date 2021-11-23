<template>
<section class="section">
        <nav class="breadcrumb" aria-label="breadcrumbs">
          <ul>
            <li><a href="/">Home</a></li>
            <li class="is-active">
                <a href="#" aria-current="page">Register</a>
            </li>
          </ul>
        </nav>

        
        <!-- show login modal START -->
            <div class="tile is-ancestor">
              <div class="tile is-horizontal">
              <div class="tile is-parent is-8">
                    <div class="box">
                        <h2 class="title">Register</h2>
                        <h3 class="subtitle">Why do I have to register?</h3>
                        <div class="msg">
                            <p>
                               No!, you do not have to be a member in order to 
                               using this site it's not require anything you 
                               just have your right to read everything in this 
                               website.
                            </p>
                        </div>
                    </div>

                    <div class="box">

                        <h3 class="subtitle">what if I want to register?</h3>
                        <div class="msg">
                            <p>
                            Well, please do the folling step then :
                            </p>

                        </div>
                        <div class="content">
                            <ol class="is-lower-roman ">

                                <li>
                                    enter your "user name" ,"your email" and 
                            you decider password.
                                </li>
                                <li>check your e-mail you have to press 
                                the confrmation link that we've send to you 
                                <span class="button is-danger is-outlined">
                                with in the same day.
                                </span>
                                </li>
                            </ol>
                        </div>

                    </div>

              </div>
              <div class="tile is-8">
                    <div class="box">
                       <form action="">
                            <div class="field">
                              <label class="label">Username</label>
                              <div class="control has-icons-left has-icons-right">
                                <input class="input is-success" type="text" 
                                placeholder="User Name" v-model="regForm.name" 
                                name="name">
                                <span class="icon is-small is-left">
                                    <font-awesome-icon icon="user" />
                                </span>
                                <span class="icon is-small is-right">

                                    <font-awesome-icon icon="check" v-show="is_success"/>
                                </span>
                              </div>
                              <p class="help is-success" v-show="is_success">This username is available</p>
                            </div>


                            <div class="field">
                              <label class="label">E-mail</label>
                              <div class="control has-icons-left has-icons-right">
                                <input class="input is-success" type="email" 
                                placeholder="Enter E-mail" name="email" 
                                v-model="regForm.email">
                                <span class="icon is-small is-left">
                                    <font-awesome-icon icon="envelope" />
                                </span>
                                <span class="icon is-small is-right" >

                                    <font-awesome-icon icon="check" v-show="is_success"/>
                                </span>
                              </div>
                              <p class="help is-success" v-show="is_success">This email is available</p>
                            </div>

                            <div class="field">
                              <label class="label">Password</label>
                              <div class="control has-icons-left">
                                <input class="input is-success" type="password" 
                                placeholder="~~~~~~" name="password" 
                                v-model="regForm.password">
                                <span class="icon is-small is-left">
                                    <font-awesome-icon icon="lock" />
                                </span>

                              </div>

                            </div>
                            <div class="field">
                                <div v-html="res_status">{{res_status}}</div>
                            </div>
                            <div class="field is-grouped is-grouped-right">
                                <button class="button is-primary" type="submit" 
                                @click.prevent="reg">Register</button>
                            </div>
                       </form>
                    </div>
              </div>
              </div>

            </div>

            <!-- modal START -->
            <div class="modal" :class="{'is-active':is_active}">
              <div class="modal-background"></div>
              <div class="modal-card">
                <header class="modal-card-head">
                  <p class="modal-card-title">Thank you!</p>
                  <button class="delete" aria-label="close" @click.prevent="is_active = ''"></button>
                </header>
                <section class="modal-card-body">
                  <div class="box">
                    <p class="msg">thank you for joining us please check your e-mail 
                    then click the confirmation link that we're provided 
                    with in the same day</p>
                  </div>
                </section>
                <footer class="modal-card-foot">
                  <button class="button is-success" 
                  @click.prevent="is_active=''">Ok</button>
                </footer>
              </div>
            </div>

            <!-- modal End -->
</section>

</template>
<script>
export default{
    name:"Register",
             data(){
                 return{
                     res_status:'',
                     is_active:'',
                     is_success:false,
                                regForm:new Form({
                                    name:'',
                                    email:'',
                                    password:''
                                        }), 
                 }
             },
             methods:{
                         reg(){
                            this.res_status = ''
                            this.is_success = false 
                             let url = `/api/register`
                             this.regForm.submit('post',url)
                             .then((res)=>{

                                 this.is_success = true
                                 this.res_status = res.msg
                                 this.is_active = 'is-active'
                                 setTimeout(()=>{
                                     this.clearState()
                                         },3200)
                                
                                 }).catch((err)=>{
                                     this.res_status = `<span class="tag 
                                     is-medium is-danger">
                                     ${Object.values(err).join()}</span>`
                                     })
                                 
                         },
                         clearState(){
                             this.regForm.reset()
                             this.res_status = ''
                             this.is_success = false
                         },
             },
}
</script>
