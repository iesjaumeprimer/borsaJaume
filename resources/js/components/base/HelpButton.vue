<template>
        <v-btn flat icon color="indigo" title="Ajuda" @click="showHelp(page)">
            <v-icon large>help_outline</v-icon>
        </v-btn>
</template>

<script>
export default {
    props: ['page'],
    methods: {
        showHelp(page) {
            window.open('https://cipfpbatoi.github.io/borsaBatoi/'+page, '_ajudaBorsa');
        }
    }
}
</script>

