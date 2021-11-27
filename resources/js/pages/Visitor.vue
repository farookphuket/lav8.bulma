<template>
    <div class="tags">
        
        <span class="tag is-info">today {{show_case.visited_today}}</span>
        <span class="tag is-info">this month {{show_case.visit_this_month}}</span>
        <span class="tag is-info">this year {{show_case.visit_this_year}}</span>
        <span class="tag is-info">All {{show_case.visit_all_time}}</span>
        <span class="tag is-info">your ip {{show_case.your_ip}}</span>
        <span class="tag is-info">your browser {{show_case.your_browser}}</span>
        <span class="tag is-info">your device {{show_case.your_device}}</span>
        <span class="tag is-info">your os {{show_case.your_os}}</span>
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
