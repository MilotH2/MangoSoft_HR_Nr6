export default {
    state: {
        userTokenValue:null,
    },
    getters: {
        userToken(state){
            return state.userTokenValue;
        },
    },
    mutations: {
        activeUser(state, token){
            state.userTokenValue = token;
            console.log('aa',state);
        },
        hideModal(state, modal){
            $('#'+modal).modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }
    },
    actions: {

    }
}
