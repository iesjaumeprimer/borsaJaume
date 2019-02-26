<template>
    <h1>Logout</h1>
</template>

<script>
export default {
    created() {
        if (confirm('¿Vols tancar la sessió?')) {
            sessionStorage.removeItem('user-data');
            this.$router.push('/login');
        } else {
            this.$router.go(-1);
        }
    }
}
</script>