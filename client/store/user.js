import axios from 'axios'
import Cookies from 'js-cookie'

export const state = () => ({
    users: [],
    errors: [],
    page: 1
})


export const actions = {
    getCategoriesData({ commit, state }, payload) {
        let search = payload ? payload:''
        return new Promise((resolve, reject) => {
            this.$axios.get(`/categories?q=${search}&page=${state.page}`).then((response) => {
                commit('SET_CATEGORY_DATA', response.data.data)
                resolve()
            })
        })
    }
  

}