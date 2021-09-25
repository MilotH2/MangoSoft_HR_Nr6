<template>
    <div style="width:100%">
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: "MainApp",
        props:['token'],
        created(){
            this.$store.commit('activeUser', this.token);
        }
    }
</script>

<style scoped>

</style>
