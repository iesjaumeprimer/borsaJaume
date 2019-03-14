<template>
  <div>
    <h1>Què es la Borsa</h1>
    <p>La Borsa de Treball del CIP FP Batoi és un punt de trobada 
      entre els nostres alumnes i ex-alumnes i
      les empreses que busquen professionals qualificats per a incorporar
      a les seues plantilles.
    </p>
    <h2>Sóc una empresa que busca un professional</h2>
    <p>Per a les empreses oferim una gran bolsa de professionals que
      s'han preparat en el nostre Centre y que pensem que s'adaptaran
      perfectament als seus requeriments.
    </p>
    <p>Una vegada publicada una oferta es pot veure el curriculum de les
      persones que cumpleixen els requisits demanats. Els aspirants 
      també ens poden indicar el seu interés per la nostra oferta de manera
      que siga senzill posar-se en contacte amb els que millor s'adapten a
      les nostres necessitats.
    </p>
    <h2>Sóc un ex-alumne que busque treball</h2>
    <p>Si busques treball l'únic que has de fer és registrar-te en la
      plataforma, indicant els cicles que has fet. Una vegada que el responsable
      de cada cicle els valide tindras accés a totes les ofertes on es 
      demanen persones amb algú dels teus cicles.
    </p>
    <h2>Com comence?</h2>
    <p>El primer pas per a participar en la Borsa, tant si eres empresa 
      com alumne, és <a @click.prevent="$router.push('/register')">
      registrar-te</a> i crear el teu compte. Si ja el tens només 
      t'has de <a @click.prevent="$router.push('/login')">loguejar</a>.
    </p>
  </div>
</template>

<script>
  export default {
    mounted() {
      this.$emit('setTitle', 'Inici');
    },
  }
</script>
