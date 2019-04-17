<template>
    <h1>Logout</h1>
</template>

<script>
import API from '../lib/API';
import utilsMixin from '../mixins/utils.js';

export default {
    mixins: [utilsMixin],
    created() {
        if (confirm('¿Vols tancar la sessió?')) {
            API.logoutUser()
            .then(resp => {
                this.clearToken();
                this.$router.push('/');
            }) // store the token in localstorage
            .catch(err => this.msgErr(err)); // if the request fails, remove any possible user token if possible
        } else {
            this.$router.go(-1);
        }
    }
}
</script>