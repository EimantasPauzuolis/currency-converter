<template>
    <div class="links d-flex justify-content-end my-4">
        <router-link class="btn" to="/">Conversion</router-link>
        <div v-if="isLoggedIn">
            <router-link class="btn" to="/favorites">Favorites</router-link>
            <a class="btn" @click="logout">Logout</a>
        </div>
        <div v-if="!isLoggedIn">
            <router-link class="btn" to="/register">Register</router-link>
            <router-link class="btn" to="/login">Sign In</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Navigation",
        methods: {
            async logout() {
                await axios.post('/logout');
                this.$store.commit('setUser', null);
                await this.$router.push({ path: '/'});
            }
        },
        computed: {
            isLoggedIn() {
                return this.$store.state.user !== null;
            }
        }
    }
</script>

<style scoped>

</style>
