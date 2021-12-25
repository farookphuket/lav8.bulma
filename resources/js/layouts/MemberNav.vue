<template>

        <nav class="navbar" role="navigation" aria-label="main navigation">
          <div class="navbar-brand">
              <a class="navbar-item" href="https://bulma.io">
              <img src="/img/logo_006.png"  width="112" height="28">
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
                          :to="{ name: 'MemberDashboard' }"
                        >
                        <span class="mr-2">
                            <font-awesome-icon icon="home"></font-awesome-icon>
                        </span>

                        </router-link>
                  </span>


                  <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        <span class="mr-2">
                            <font-awesome-icon icon="folder"></font-awesome-icon>
                        </span> 
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
                              :to="{ name: 'MPost' }"
                            >
                              Post
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

                              <font-awesome-icon icon="user"></font-awesome-icon>
                            </router-link>
                        </span>

                        <span class="button is-outlined is-rounded is-warning">
                            <router-link
                              class="nav-link"
                              data-toggle="collapse"
                              :to="{ name: 'logout' }"
                            >
                              <font-awesome-icon icon="sign-out-alt"></font-awesome-icon>
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
    name:"MeberNav",
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
