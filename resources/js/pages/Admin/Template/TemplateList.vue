<template>
    <div>
        <h2>template list {{tem_num}}</h2>
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
