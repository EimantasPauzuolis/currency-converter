<template>
    <div>
        <Navigation/>
        <keep-alive>
            <router-view/>
        </keep-alive>
    </div>
</template>

<script>
    import Navigation from "./Navigation";

    export default {
        name: "Container",
        async created() {
            const user = this.$store.user;
            if (!user) {
                const result = await axios.get('/api/user');
                this.$store.commit('setUser', result.data);
                await this.$router.push({ path: '/'})
            }
        },
        components: {
            Navigation
        }
    }
</script>

<style scoped>

</style>
