<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Favorites</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">Amount</div>
                            <div class="col-md-1">From</div>
                            <div class="col-md-2">Exchange rate</div>
                            <div class="col-md-1">To</div>
                            <div class="col-md-2">Exchange value</div>
                            <div class="col-md-3">Conversion date</div>
                            <div class="col-md-1"></div>
                        </div>
                        <ul class="list-group">
                            <li v-for="conversion in conversions" class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        {{conversion.amount}}
                                    </div>
                                    <div class="col-md-1">
                                        {{conversion.sourceCurrency}}
                                    </div>
                                    <div class="col-md-2">
                                        {{conversion.exchangeRate}}
                                    </div>
                                    <div class="col-md-1">
                                        {{conversion.targetCurrency}}
                                    </div>
                                    <div class="col-md-2">
                                        {{conversion.exchangeValue.toFixed(2)}}
                                    </div>
                                    <div class="col-md-3">
                                        {{new Date(conversion.date).toDateString()}}
                                    </div>
                                    <div class="col-md-1">
                                        <router-link :to="{ path: `favorites/${conversion.id}`}" class="btn btn-primary">Edit</router-link>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        async mounted() {
            const { data } = await axios.get('/api/conversions')
            this.$store.commit('setUserConversions',  data);
        },
        computed: {
            conversions() {
                return this.$store.state.conversions;
            }
        }
    }
</script>
