<template>
    <div class="container">
        <div class="box">
            <h2 class="title">visitors</h2>
        </div>
        <nav class="level">
          <div class="level-item has-text-centered">
            <div>
              <p class="heading">Today</p>
              <p class="title">{{show_case.visited_today}}</p>
            </div>
          </div>

          <div class="level-item has-text-centered">
            <div>
              <p class="heading">This Month</p>
              <p class="title">{{show_case.visit_this_month}}</p>
            </div>
          </div>


          <div class="level-item has-text-centered">
            <div>
              <p class="heading">This Year</p>
              <p class="title">{{show_case.visit_this_year}}</p>
            </div>
          </div>


          <div class="level-item has-text-centered">
            <div>
              <p class="heading">All Visitors</p>
              <p class="title">{{show_case.visit_all_time}}</p>
            </div>
          </div>

          <div class="level-item has-text-centered">
            <div>
              <p class="heading">You</p>
              <p class="title">{{show_case.your_browser}}</p>
              <div class="tags">
                <span class="tag is-info is-medium">IP {{show_case.your_ip}}</span>
                <span class="tag is-info is-medium">Device {{show_case.your_device}}</span>
                <span class="tag is-info is-medium">OS {{show_case.your_os}}</span>
              </div>
            </div>
          </div>

        </nav>
    </div>
</template>

<script>
export default{
    name:"Visitor",
             data(){
                 return{
                     show_case:'',
                 }
             },
             mounted(){
                 this.getVisitor()
             },
    methods:{
        getVisitor(){
            this.show_case = ''
            let url = `/api/visitor`
            axios.get(url)
            .then(res=>{
              //  console.log(res.data.your_data)
                this.show_case = res.data.your_data
                    })
        },
    }
}
</script>
