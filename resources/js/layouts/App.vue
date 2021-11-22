<template>
  <div>
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
                          :to="{ name: 'home' }"
                        >
                          Home
                        </router-link>
                  </span>

                  <a class="navbar-item" href="https://bulma.io/documentation/">
                    Bulma Documentation
                  </a>

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
                              :to="{ name: 'posts' }"
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
                      <a class="button is-primary" 
                      >
                        <strong>Sign up</strong>
                      </a>

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

      <router-view></router-view>
  </div>
</template>

<script>
export default {
    name:"App",
             data(){
                 return{
                     isOpen:false,
                 }
             },
             mounted(){

             },
             methods:{
                 burgerToggle(){
                    // nav-main 
                    this.isOpen = !this.isOpen
                 },
             },
};
</script>
