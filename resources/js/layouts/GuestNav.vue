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
                          <font-awesome-icon icon="home"></font-awesome-icon>
                        </router-link>
                  </span>

<!--
                  <a class="navbar-item" href="https://bulma.io/documentation/">
                    Bulma Documentation
                  </a>
-->
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


                        <span class="button is-warning is-outlined is-rounded">
                            <router-link
                              class="nav-link"
                              data-toggle="collapse"
                              :to="{ name: 'register' }"
                            >
                              <font-awesome-icon icon="plug"></font-awesome-icon>
                            </router-link>
                        </span>

                        <span class="button is-danger is-outlined is-rounded">
                            <router-link
                              class="nav-link"
                              data-toggle="collapse"
                              :to="{ name: 'login' }"
                            >
                              <font-awesome-icon icon="user"></font-awesome-icon>
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
