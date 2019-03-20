<template>
    <h1>Logout</h1>
</template>

<script>
import API from '../lib/API';
import utilsMixin from '../mixins/utils.js';

export default {
    mixins: [utilsMixin, formRulesMixin],
    created() {
        if (confirm('¿Vols tancar la sessió?')) {
            console.log('logout')
            API.logoutUser()
            .then(resp => {
                sessionStorage.removeItem('access_token');
                sessionStorage.removeItem('expires_at');
                sessionStorage.removeItem('user_rol');
                sessionStorage.removeItem('user_id');
                sessionStorage.removeItem('token_type');
                this.$router.push('/');
            }) // store the token in localstorage
            .catch(err => {
              this.msgErr('ERROR: '+err);
            }); // if the request fails, remove any possible user token if possible
        } else {
            this.$router.go(-1);
        }
    }
}
</script>