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
  <h1 class="title">Register Page</h1>
  <h2 class="subtitle">
    A simple container to divide your page into <strong>sections</strong>, like the one you're currently reading.
  </h2>

        
        <!-- show login modal START -->
            <div class="tile is-ancestor">
              <div class="tile is-vertical is-4">
                    <div class="box">
                        <h2 class="title">Login</h2>
                        <div class="msg">
                            <p>login with your cridential</p>
                        </div>
                    </div>
              </div>
              <div class="tile is-parent is-8">
                    <div class="box">
                       <form action="">
                            <div class="field">
                                <label class="label" for="">User Name</label>
                                <div class="control">
                                    <input id="" class="input" type="text" 
                                    placeholder="Your user name"
                                    name="">
                                </div>
                            </div>
                            <div class="field">
                              <label class="label">Username</label>
                              <div class="control has-icons-left has-icons-right">
                                <input class="input is-success" type="text" placeholder="Text input" value="bulma">
                                <span class="icon is-small is-left">
                                  <i class="fas fa-user"></i>
                                </span>
                                <span class="icon is-small is-right">
                                  <i class="fas fa-check"></i>

                                    <font-awesome-icon icon="coffee" />
                                </span>
                              </div>
                              <p class="help is-success">This username is available</p>
<font-awesome-icon icon="coffee" />
                            </div>
                            <div class="field is-grouped-right">
                                <button class="button is-primary">Register</button>
                                <button class="button is-primary">Cancel</button>
                            </div>
                       </form>
                    </div>
              </div>
            </div>
        <!-- show login modal END -->

</section>

</template>
<script>
export default{
    name:"Register"
}
</script>
