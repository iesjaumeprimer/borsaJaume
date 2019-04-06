<template functional>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12>
        <v-card>
          <v-card-title class="red darken-3 white--text subheading" primary-title>
            <span class="title">404 - Page not found</span>
          </v-card-title>
          <v-card-text>
            La pàgina que busques no es troba. Tria altra opció del menú
            o torna enrere.
          </v-card-text>
          <v-card-actions>
            <v-btn flat class="red darken-3 white--text" to="$router.go(-1)">Back</v-btn>
            <a href="#" @click.prevent="back()">Back</a>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>


<script>
export default {
    methods: {
        back() {
            this.$router.go(-1);
        }
    }
}
</script>
