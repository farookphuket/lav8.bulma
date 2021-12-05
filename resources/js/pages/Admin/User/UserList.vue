<template>
    <div class="content">
        <div class="box" v-for="u in uList.data">

            <div class="filed is-pulled-right">
                <div >
                     <span class="icon-text">
                        <font-awesome-icon icon="calendar-day"></font-awesome-icon>
                     </span>
                     <span class="ml-2">{{moment(u.created_at).fromNow()}}</span>
                </div>
                <button class="button is-primary" 
                    @click.prevent="$emit('edit',u.id)">
                    <font-awesome-icon icon="edit"></font-awesome-icon>
                </button>

                <button class="button is-danger" 
                    @click.prevent="$emit('del',u.id)">
                    <font-awesome-icon icon="trash"></font-awesome-icon>
                </button>
            </div>

            <ul>
                <li>{{u.name}}</li>
                <li>{{u.email}}</li>
                <li class="tags"> Role
                    <ul>
                        <li class="tag is-medium is-info" v-for="ro in u.role">
                            {{ro.role_name}}
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
        <div class="box">
            pagination
        </div>
    </div>
</template>
<script>
var moment = require("moment")
export default{
    name:"UserList",
    props:["uList"],
    data(){return{
        moment:moment,
    }},
}
</script>
