<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{isEditing ? 'Update conversion' : 'Conversion'}}</div>
                    <div class="card-body">
                        <div v-if="!this.authUser" class="alert alert-primary mt-2" role="alert">
                            Sign in to save favorites!
                        </div>
                        <form @submit.prevent="convert" v-if="codes">
                            <div class="form-group">
                                <input type="number" class="form-control" v-model.number="form.value" min="1">
                            </div>
                            <div class="form-group">
                                <select v-model="form.source" class="form-control" name="sourceCurrency">
                                    <option v-for="(currency, code) in codes" :value="code">{{currency}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select v-model="form.target" class="form-control" name="targetCurrency">
                                    <option v-for="(currency, code) in codes" :value="code">{{currency}}</option>
                                </select>
                            </div>
                            <button class="btn btn-primary">Convert</button>
                            <button class="btn btn-secondary" type="button" @click="saveConversion" v-if="this.result && this.authUser">
                                Save conversion
                            </button>
                        </form>
                    </div>
                    <h4 class="mt-3 text-center" v-if="result">{{resultMessage}}</h4>
                    <h4 class="my-3 text-center" v-if="result">Time of exchange rate: {{result.date}}</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "ConversionForm",
        data() {
            return {
                isEditing: false,
                form: {
                    value: 1,
                    source: 'GBP',
                    target: 'EUR'
                },
                value: 1,
                source: '',
                target: '',
                codes: null,
                result: null
            }
        },
        async created() {
            const { data } = await axios.get('/api/codes');
            this.codes = data;

            if (this.$route.params.id) {
                this.isEditing = true;
                this.setEditing();
            }
        },
        methods: {
            async convert() {
                const { data } = await axios.get('/api/conversion', {
                    params: {
                        ...this.form,
                    }
                });
                const { source, target, value } = this.form;
                this.result = data;
                this.source = source;
                this.target = target;
                this.value = value;
            },
            async saveConversion() {
                const { source, target } = this.form;
                const { value, isEditing } = this;
                let data = {
                    ...this.result,
                    source,
                    target,
                    value,
                };

                if (!isEditing) {
                    data = {
                        ...data,
                        date: new Date(this.result.date)
                    }
                }
                const url = isEditing ? `/api/conversion/${this.$route.params.id}` : '/api/conversion';
                const { data: result } = await axios.post(url, data);

                if (isEditing) {
                    this.$store.commit('updateUserConversion', result);
                } else {
                    this.$store.commit('addUserConversion', result);
                }

                await this.$router.push({path: '/favorites'})
            },
            setEditing() {
                const conversionToEdit =  this.$store.getters.getConversion(this.$route.params.id);
                if (conversionToEdit && this.isEditing) {
                    this.form.value = conversionToEdit.amount;
                    this.form.source = conversionToEdit.sourceCurrency;
                    this.form.target = conversionToEdit.targetCurrency;
                }
            },
            clearResult() {
                this.result = null;
            },
        },
        computed: {
            resultMessage() {
                return `${this.value} ${this.codes[this.source]} is equal to ${Number(this.result.exchangeValue).toFixed(2)} ${this.codes[this.target]}`;
            },
            authUser() {
                return this.$store.state.user;
            }
        },
        watch: {
            '$route.params.id'() {
                this.clearResult();
                this.setEditing();
            }
        }
    }
</script>

