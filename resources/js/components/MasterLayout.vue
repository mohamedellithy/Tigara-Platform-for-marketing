<template>
    <router-view v-if="(this.$route.meta.requiresAuth == true) && (this.$auth.user.account_type == this.$route.meta.AccountID)"></router-view>
    <router-view v-else-if="this.$route.meta.requiresAuth == false"></router-view>
    <img style="width:50%;margin-right: 25%;" src="@/img/404.png" v-else/>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap');
body {
    font-family: 'Tajawal', sans-serif;
}
</style>
