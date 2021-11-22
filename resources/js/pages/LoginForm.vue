<template>
    <div class="box">
        <form action="">
            <div class="field">

                <label class="label" for="">E-mail</label>
                <div class="control">
                    <input class="input" type="text" 
                    name="" placeholder="Email...">
                </div>
            </div>

            <div class="field">

                <label class="label" for="">Password</label>
                <div class="control">
                    <input class="input" type="password" 
                    name="" placeholder="~~~~~~">
                </div>
            </div>

            <div class="field is-grouped is-grouped-right">
              <div class="control">
                <button class="button is-link">Submit</button>
              </div>
              <div class="control">
                <button class="button is-link is-light">Cancel</button>
              </div>
            </div>

        </form>
    </div>
</template>



<script>
export default{
    name:"LoginForm"
}
</script>
