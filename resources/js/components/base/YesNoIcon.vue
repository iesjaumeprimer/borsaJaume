<template>
    <v-icon>mdi-{{ value?'check':'close' }}</v-icon>
</template>

<script>
export default {
    props: {
        value: {
            type: [Boolean, Number, String],
            requied: true
        }
    }
}
</script>
