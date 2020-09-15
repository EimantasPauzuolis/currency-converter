import Vuex from 'vuex';
import Vue from 'vue';
Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        user: null,
        conversions: []
    },
    mutations: {
        setUser (state, user) {
            state.user = user;
        },
        removeUser(state) {
            state.user = null;
        },
        setUserConversions(state, conversions) {
            state.conversions = conversions;
        },
        addUserConversion(state, conversion) {
            state.conversions = [
                conversion,
                ...state.conversions
            ];
        },
        updateUserConversion(state, conversion) {
            state.conversions = state.conversions.map(c => {
                if (c.id === conversion.id) {
                    return conversion;
                }
                return c;
            })
        }
    },
    getters: {
        getConversion: state => id => {
            return state.conversions.find(c => c.id === Number(id));
        }
    }
})
