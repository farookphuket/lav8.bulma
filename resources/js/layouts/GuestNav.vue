<template>
        <nav class="navbar" role="navigation" aria-label="main navigation">
          <div class="navbar-brand">
              <a class="navbar-item" href="https://bulma.io">
              <img src="/img/logo_006.png">
              </a>

              <a role="button" class="navbar-burger" aria-label="menu" 
              aria-expanded="false" data-target="nav-main" 
             @click.prevent="toggleNav" :class="{'is-active':isOpen}">
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
                          :to="{ name: 'home' }"
                        >
                          Home
                        </router-link>
                  </span>

<!--
                  <a class="navbar-item" href="https://bulma.io/documentation/">
                    Bulma Documentation
                  </a>
-->
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
                              :to="{ name: 'post' }"
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


                        <span class="button is-primary">
                            <router-link
                              class="nav-link"
                              data-toggle="collapse"
                              :to="{ name: 'register' }"
                            >
                              Register
                            </router-link>
                        </span>

                        <span class="button is-warning">
                            <router-link
                              class="nav-link"
                              data-toggle="collapse"
                              :to="{ name: 'login' }"
                            >
                              Login
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
    name:"GuestNav",
             data(){
                 return{
                     isOpen:false,
                 }
             },
methods:{
            toggleNav(){
                this.isOpen = !this.isOpen 
            },
        },

}
</script>
