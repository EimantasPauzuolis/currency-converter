<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" v-model="email" class="form-control" name="email" required autocomplete="email" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" v-model="password" class="form-control" name="password" required autocomplete="current-password">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="button" class="btn btn-primary" @click="signIn">
                                       Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SignIn",
        data() {
            return {
                email: '',
                password: '',
                errors: {
                    email: null,
                    password: null
                }
            }
        },
        methods: {
            async signIn() {
                await axios.get('/sanctum/csrf-cookie');
                await axios.post('/login', {
                    email: this.email,
                    password: this.password
                });
                const { data } = await axios.get('/api/user');
                this.$store.commit('setUser', data);
                await this.$router.push({ path: '/'})
            }
        }
    }
</script>

<style scoped>

</style>
