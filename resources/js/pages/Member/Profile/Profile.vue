<template>

<section class="section">
        <nav class="breadcrumb" aria-label="breadcrumbs">
          <ul>
            <li><a href="/member/home">Home</a></li>
            <li class="is-active">
                <a href="#" aria-current="page">Profile</a>
            </li>
          </ul>
        </nav>
        

</section>
</template>

<script>
export default{
    name:"MemberProfile",
             mounted(){
                 console.log(this.$cookies.get('token'))
             },
}
</script>
