<template>

        <v-list-item link  @click="$emit('click')">
          <v-list-item-action>
            <v-icon>mdi-{{ icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{ title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
</template>

<script>
export default {
    props: {
        icon: {
            type: String,
            default: 'home',
        },
        title: {
            type: String,
            required: true,
        }
    }
}
</script>
