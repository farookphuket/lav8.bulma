<template>

<section class="section">
        <nav class="breadcrumb" aria-label="breadcrumbs">
          <ul>
            <li><a href="/">Home</a></li>
            <li class="is-active">
                <a href="#" aria-current="page">LogOut</a>
            </li>
          </ul>
        </nav>
        
        <!-- 2 columns START -->
        <div class="columns ">
            <h2>logout page</h2>
        </div>
        <!-- 2 columns END -->

</section>
</template>
<script>
export default{
    name:"Logout",
             data(){
                 return{
                     u:'',
                 }
             },
             mounted(){
                 this.logout()
             },
             methods:{
                 logout(){
                     let r1 = this.$cookies.get('token');
                     let url = `/api/logout`
                         axios.delete(url,{
                             headers:{'Authorization':`Basic ${r1}`}
                                 })
                     .then(res=>{
                         console.log(res.data)
                         this.$cookies.set('token','')
                         location.href=res.data.url
                             })
                 },
             },

}
</script>
