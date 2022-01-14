<template>
    <div>
        <h2 class="title has-text-centered">
        template list {{tem_num}}</h2>

        <article class="box content" 
        v-for="tm in tem_list.data" v-if="tem_list.data != 0">
            <div>
                <h2 class="title">{{tm.t_title}}</h2>
            </div>
        </article>
        <article v-else>
            <h2>no data</h2>
        </article>


    </div>
</template>
<script>
var moment = require('moment')

export default{
    name:"TemplateList",
    props:["tem_num","tem_list"],
    data(){return{
        moment:moment,
    }},
methods:{

        },
}
</script>
