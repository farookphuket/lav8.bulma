<template>
    <div class="tags">
        <div class="tag" v-for="yy in show_case">
            <span class="tag is-success">{{yy.your_ip}}</span>
        </div>
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
                console.log(res.data.your_data)
                this.show_case = res.data.your_data
                    })
        },
    }
}
</script>
