<template>
  <v-chip
    @dblclick="$emit('dblclick')"
    :title="datosCiclo.vCiclo"
  >
    <v-avatar
      :color="datosCircle.color"
      :title="datosCircle.desc"
      left
    >
      <span class="white--text caption font-weight-bold">{{ ciclo.any }}</span>
    </v-avatar>
    <span class="caption">{{ datosCiclo.ciclo }}</span>
  </v-chip>
</template>

<script>
export default {
    name: 'ciclo-chip',
    props: ['ciclo'],
    computed: {
            datosCiclo() {
                    return this.$store.getters.getCicloById(this.ciclo.id_ciclo);
    },
        datosCircle() {
            if (this.ciclo.validado==undefined)
                return { desc: this.descCiclo, color: 'grey' };
            return {
              desc: this.ciclo.validado?'Validado':'No validado',
              color: this.ciclo.validado?'teal':'red'
            }
        },

},
}
</script>

<style scoped>
.v-chip .v-avatar {
  height: 30px !important;
  width: 36px !important;
}
.v-chip {
  padding: 8px;
    margin: 2px 2px !important;
}
</style>
