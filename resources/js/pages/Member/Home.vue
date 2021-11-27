<template>
    <div>
        <section class="hero is-success is-halfheight">
          <div class="hero-body">
            <div class="container">
              <p class="title has-text-centered">
              member  section bootstrap free!
              </p>
              <p class="subtitle">
                there is no bootstrap css style on this site
              </p>
            </div>
          </div>
        </section>
        <section class="section mt-4">
            <div class="content">
                <h2 class="has-text-centered is-info">text</h2>
                
            </div>
            <div>
                <whatnew></whatnew>
            </div>
        </section>

    </div>
</template>

<script>
import Whatnew from './Whatnew.vue'
export default {
   name:"MemberDashboard",
            components:{
                Whatnew,
            },
}
</script>
