function initialState() {
    return {
        item: {
            id: null,
            name: null,
            city: null,
            categories: [],
            address: null,
            description: null,
            logo: null, uploaded_logo: null,
        },
        citiesAll: [],
        categoriesAll: [],
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    citiesAll: state => state.citiesAll,
    categoriesAll: state => state.categoriesAll,
    
}

const actions = {
    storeData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== 'object') {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(fieldName + '[' + index + ']', fieldValue[index]);
                        }
                    }
                }
            }

            if (! _.isEmpty(state.item.city)) {
                params.set('city_id', state.item.city.id)
            }
            if (_.isEmpty(state.item.categories)) {
                params.delete('categories')
            } else {
                for (let index in state.item.categories) {
                    params.set('categories['+index+']', state.item.categories[index].id)
                }
            }
            

            axios.post('/api/v1/companies', params)
                .then(response => {
                    commit('resetState')
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors  = error.response.data.errors

                    dispatch(
                        'Alert/setAlert',
                        { message: message, errors: errors, color: 'danger' },
                        { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setLoading', false)
                })
        })
    },
    updateData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();
            params.set('_method', 'PUT')

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== 'object') {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(fieldName + '[' + index + ']', fieldValue[index]);
                        }
                    }
                }
            }

            if (! _.isEmpty(state.item.city)) {
                params.set('city_id', state.item.city.id)
            }
            if (_.isEmpty(state.item.categories)) {
                params.delete('categories')
            } else {
                for (let index in state.item.categories) {
                    params.set('categories['+index+']', state.item.categories[index].id)
                }
            }
            

            axios.post('/api/v1/companies/' + state.item.id, params)
                .then(response => {
                    commit('setItem', response.data.data)
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors  = error.response.data.errors

                    dispatch(
                        'Alert/setAlert',
                        { message: message, errors: errors, color: 'danger' },
                        { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setLoading', false)
                })
        })
    },
    fetchData({ commit, dispatch }, id) {
        axios.get('/api/v1/companies/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchCitiesAll')
    dispatch('fetchCategoriesAll')
    },
    fetchCitiesAll({ commit }) {
        axios.get('/api/v1/cities')
            .then(response => {
                commit('setCitiesAll', response.data.data)
            })
    },
    fetchCategoriesAll({ commit }) {
        axios.get('/api/v1/categories')
            .then(response => {
                commit('setCategoriesAll', response.data.data)
            })
    },
    setName({ commit }, value) {
        commit('setName', value)
    },
    setCity({ commit }, value) {
        commit('setCity', value)
    },
    setCategories({ commit }, value) {
        commit('setCategories', value)
    },
    setAddress({ commit }, value) {
        commit('setAddress', value)
    },
    setDescription({ commit }, value) {
        commit('setDescription', value)
    },
      uploadLogo({commit}, value) {
        commit('setLogo', value);
    },
    destroyLogo({commit}, value) {
        commit('setUploadedLogo', value);
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setName(state, value) {
        state.item.name = value
    },
    setCity(state, value) {
        state.item.city = value
    },
    setCategories(state, value) {
        state.item.categories = value
    },
    setAddress(state, value) {
        state.item.address = value
    },
    setDescription(state, value) {
        state.item.description = value
    },
    
    setLogo(state, value) {
        state.item.logo = value
    },
    setUploadedLogo(state, value) {
        state.item.uploaded_logo = value
    },
    setCitiesAll(state, value) {
        state.citiesAll = value
    },
    setCategoriesAll(state, value) {
        state.categoriesAll = value
    },
    
    setLoading(state, loading) {
        state.loading = loading
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
