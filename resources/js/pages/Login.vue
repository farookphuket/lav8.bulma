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
        
        <!-- 2 columns START -->
        <div class="columns ">
                <div class="column is-8">
                    <div class="content">
                        <h2 class="title">
                            No log-in require.
                        </h2>
                        <h3 class="subtitle">
                            All those article are posted as public to any one. 
                        </h3>
                        <div class="msg">
                            <p>
                            but if you have a feeling like you have something 
                            to contribute so please login.
                            </p>
                        </div>
                    </div>
                    <div class="content">
                        <h2 class="title">ไม่จำเป็นต้องล๊อคอิน</h2>
                        <h3 class="subtitle">
                        ข้อความหรือบทความที่เผยแพร่ทั้งหมดเป็นสาธารณะ
                        </h3>
                        <div class="msg">
                        <p>
                            แต่ถ้าหากว่าท่านต้องการจะร่วมเป็นผู้เขียนกับเรา ก็ได้โปรดล๊อคอิน
                            ก่อนนะครับ
                        </p>
                        </div>
                    </div>
                    
                </div>
                <div class="column is-4">
                    <login-form></login-form>
                </div>
        </div>
        <!-- 2 columns END -->

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
