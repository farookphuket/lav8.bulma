<template>
    <div >


                <div class="card">
                    <div class="card-content">
                        <article class="mt-4" v-for="po in wnList.data">
                            <h2 class="title has-text-centered">{{po.wn_title}}</h2>
                            <div class="content mt-4" v-html="po.wn_body">
                               {{po.wn_body}} 
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <div class="media">
                                        <span class="icon-text">

                                            <font-awesome-icon icon="user"></font-awesome-icon>  
                                            <span class="ml-2">
                                                {{po.user.name}}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="column">

                                    <div class="field is-grouped is-grouped-right">
                                        <button class="button is-primary">edit</button>
                                    </div>

                                </div>
                            </div>

                        </article>
                    </div>
                </div>

    </div>
</template>
<script>
export default{
    name:"WhatnewList",
    props:["wnList"],
             data(){return{
                 tk:'',
             }},
             mounted(){
                 this.tk = this.$cookies.get('token')
             },
methods:{

        },
}
</script>
