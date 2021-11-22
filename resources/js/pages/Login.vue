<template>
<section class="section">
        <nav class="breadcrumb" aria-label="breadcrumbs">
          <ul>
            <li><a href="/">Home</a></li>
            <li class="is-active">
                <a href="#" aria-current="page">Login</a>
            </li>
          </ul>
        </nav>
  <h1 class="title">Medium section</h1>
  <h2 class="subtitle">
    A simple container to divide your page into <strong>sections</strong>, like the one you're currently reading.
  </h2>

        
        <!-- show login modal START -->
            <div class="tile is-ancestor">
              <div class="tile is-vertical is-8">
                    <div class="box">
                        <h2 class="title">Login</h2>
                        <div class="msg">
                            <p>login with your cridential</p>
                        </div>
                    </div>
              </div>
              <div class="tile is-4">
                   <login-form></login-form>
              </div>
            </div>
        <!-- show login modal END -->

</section>
</template>

<script>
import LoginForm from "./LoginForm.vue"
export default{
    name:"Login",
             components:{
                 LoginForm,
             },
}
</script>
