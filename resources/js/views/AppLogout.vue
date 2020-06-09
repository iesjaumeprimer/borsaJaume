<template>
    <h1>Logout</h1>
</template>

<script>
import utilsMixin from '../mixins/utils.js';

export default {
    mixins: [utilsMixin],
    created() {
        if (confirm('¿Vols tancar la sessió?')) {
            this.$store.dispatch('logout')
            .then(() => this.$router.push('/')) 
            .catch(err => this.msgErr(err)); // if the request fails, remove any possible user token if possible
        } else {
            this.$router.go(-1);
        }
    }
}
</script>
