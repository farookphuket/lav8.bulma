<template>

        <nav class="navbar" role="navigation" aria-label="main navigation">
          <div class="navbar-brand">
              <a class="navbar-item" href="https://bulma.io">
              <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
              </a>

              <a role="button" class="navbar-burger" aria-label="menu" 
              aria-expanded="false" data-target="nav-main" 
             @click.prevent="burgerToggle" :class="{'is-active':isOpen}">
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
            </a>
            </div>

              <div id="nav-main" class="navbar-menu" 
              :class="{'is-active':isOpen}">
                <div class="navbar-start">
                  <span class="navbar-item">
                        <router-link

                          data-toggle="collapse"
                          :to="{ name: 'AdminDashboard' }"
                        >
                          Home
                        </router-link>
                  </span>

                  <span class="navbar-item">
                        <router-link
                          data-toggle="collapse"
                          :to="{ name: 'AdminUser' }"
                        >
                          User
                        </router-link>
                  </span>

                  <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                      Pages
                    </a>

                    <div class="navbar-dropdown">
                        <span class="navbar-item">
                            <router-link
                              class="nav-link"
                              data-toggle="collapse"
                              :to="{ name: 'about' }"
                            >
                              About
                            </router-link>
                        </span>
                        <span class="navbar-item">
                            <router-link
                              class="nav-link"
                              data-toggle="collapse"
                              :to="{ name: 'AdminPost' }"
                            >
                              Post
                            </router-link>
                        </span>

                        <span class="navbar-item">
                            <router-link
                              class="nav-link"
                              data-toggle="collapse"
                              :to="{ name: 'AdminCategory' }"
                            >
                              Category
                            </router-link>
                        </span>

                    </div>
                  </div>
                </div>

                <div class="navbar-end">
                  <div class="navbar-item">
                    <div class="buttons">


                        <span class="button is-info is-outlined">
                            <router-link
                              class="nav-link"
                              data-toggle="collapse"
                              :to="{ name: 'MemberProfile' }"
                            >

                              Update Profile 
                            </router-link>
                        </span>

                        <span class="button is-outlined is-danger">
                            <router-link
                              class="nav-link"
                              data-toggle="collapse"
                              :to="{ name: 'logout' }"
                            >
                              LogOut
                            </router-link>
                        </span>
                    </div>
                  </div>
                </div>

              </div>
            </nav>
</template>
<script>
export default{
    name:"AdminNav",
             data(){
                 return{
                     isOpen:false,
                     user_id:'',

                 }
             },
             mounted(){
                 this.user_id = window.user_id
             },
methods:{
            burgerToggle(){
                this.isOpen = !this.isOpen
            },

        }
}
</script>
