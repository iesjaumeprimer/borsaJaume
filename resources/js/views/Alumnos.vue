<template>
  <div>
    <div v-for="(error,i) in errors" :key="i">
      <v-alert v-model="error.show" :type="error.type" dismissible>{{ error.msg }}</v-alert>
    </div>

    <v-card>
      <v-data-table
      fluid
        :items="items"
        no-data-text="No hi ha dades disponibles"
        :items-per-page="10"
        footer-props.items-per-page-text="Registres per pàgina"
        :headers="headers"
        :search="search"
        class="elevation-1"
        single-expand
        item-key="id"
        show-expand
        no-results-text="No hi ha dades amb el text indicat"
            :footer-props="{
      showFirstLastPage: true,
      firstIcon: 'mdi-chevron-double-left',
      lastIcon: 'mdi-chevron-double-right',
      itemsPerPageText: 'Registres per pàgina'
          }"
      >
    <template v-slot:footer.page-text="records">
            {{ records.pageStart }} a {{ records.pageStop }} de {{ records.itemsLength }}
    </template>

    <template v-slot:body.append>
          <help-button v-if="helpPage" :page="helpPage"></help-button>
    </template>

    <template v-slot:top>
      <v-toolbar color="white">
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Filtrar taula"
          single-line
          hide-details
        ></v-text-field>
        <v-spacer></v-spacer>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="800px">
          <v-card>
            <v-card-title>
              <span class="headline">{{ isNew?'Nou':'Editar' }} alumne</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="2" md="1">
                <v-text-field label="Id" placeholder="Id" v-model="editItem.id" readonly></v-text-field>
              </v-col>
                  <v-col cols="12" sm="5" md="3">
                <v-text-field
                  label="Nom"
                  placeholder="Nom"
                  v-model="editItem.nombre"
                  :rules="required25Rules"
                ></v-text-field>
              </v-col>
                  <v-col cols="12" sm="12" md="8">
                <v-text-field
                  label="Cognoms"
                  placeholder="Cognoms"
                  v-model="editItem.apellidos"
                  :rules="required50Rules"
                ></v-text-field>
              </v-col>
                  <v-col cols="12" sm="12" md="9">
                <v-textarea
                  label="Domicil·li"
                  placeholder="Domicil·li"
                  v-model="editItem.domicilio"
                  counter="80"
                  :rules="required80Rules"
                  rows="3"
                ></v-textarea>
              </v-col>
                  <v-col cols="12" sm="4" md="3">
                <v-text-field label="Telèfon" placeholder="Telèfon" v-model="editItem.telefono"></v-text-field>
              </v-col>
                  <v-col cols="12" sm="8" md="7">
                <v-text-field
                  label="C.V."
                  placeholder="Enllaç al CV en Linkedin, ..."
                  v-model="editItem.cv_enlace"
                ></v-text-field>
              </v-col>
                  <v-col cols="12" sm="5" md="3">
                <v-checkbox
                  v-model="editItem.bolsa"
                  label="Borsa treball"
                  title="Ha d'estar marcada per a formar parte de la borsa de treball"
                  placeholder="Si vols participar en la borsa de treball"
                  hint="Vuig rebre ofertes de la borsa"
                  persistent-hint
                ></v-checkbox>
              </v-col>
                  <v-col cols="12" sm="3" md="2">
                <v-checkbox
                  v-model="editItem.info"
                  label="Rebre info."
                  title="Per a rebre informacions com data de matriculacions, jornades, ..."
                  placeholder="Si vols rebre informació del Centre"
                ></v-checkbox>
              </v-col>
                  <v-col cols="12">
                <v-select
                  :items="ciclos"
                  v-model="editItem.ciclos"
                  item-text="ciclo"
                  item-value="id"
                  label="Cicles finalitzats"
                  multiple
                  chips
                  persistent-hint
                ></v-select>
              </v-col>

                </v-row>
              </v-container>
            </v-card-text>
          <v-card-actions>
            <help-button v-if="helpPage" :page="helpPage+'#editar-un-alumne'"></help-button>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="preAddItem" :disabled="!valid">Guardar</v-btn>
            <v-btn @click="closeDialog">Cancel·lar</v-btn>
          </v-card-actions>

          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>

        <template v-slot:item.nombre="{ item }">
          {{ item.nombre }} {{ item.apellidos }}
        </template>

        <template v-slot:item.cicles="{ item }">
          <ciclo-chip
            v-for="ciclo in item.ciclos"
            :key="ciclo.id_ciclo"
            :ciclo="ciclo"
            @dblclick="toogleValida(ciclo, item.nombre+' '+item.apellidos)"
          ></ciclo-chip>
        </template>

        <template v-slot:item.cv_enlace="{ item }">
          <a v-if="item.cv_enlace" :title="item.cv_enlace" :href="item.cv_enlace" target="_blank">
      <v-icon
        
        class="mr-2"
      >
        class
      </v-icon>
          </a>
        </template>

        <template v-slot:item.bolsa="{ item }">
          <yes-no-icon :value="item.bolsa"></yes-no-icon>
        </template>
        <template v-slot:item.info="{ item }">
          <yes-no-icon :value="item.info"></yes-no-icon>
        </template>
        <template v-slot:item.updated_at="{ item }">
          {{ toFecha(item.updated_at )}}
        </template>

    <template v-slot:item.action="{ item }" v-if="!imEmpresa">
      <v-icon
        
        class="mr-2"
        @click="preOpenDialog(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        
        @click="deleteUser(item, `l'alumne '${item.nombre} ${item.apellidos}'`)"
      >
        mdi-delete
      </v-icon>
    </template>
        <template v-slot:expanded-item="{ headers, item }">
          <td :colspan="headers.length">
            <v-card>
              <v-card-text>
                <strong>Domicil·li:</strong>
                {{ item.domicilio }}
                <v-spacer></v-spacer>
                <strong>Telèfon:</strong>
                {{ item.telefono }}
                <v-spacer></v-spacer>
                <strong>E-mail:</strong>
                {{ item.email }}
              </v-card-text>
            </v-card>
          </td>
        </template>

      </v-data-table>
    </v-card>



    <v-dialog v-model="dialogCiclo" width="400px">
      <v-card>
        <v-card-title class="grey lighten-4 py-4 title">{{ ciclo.nombre }}</v-card-title>
        <v-container class="pa-4">
          <v-row>
            <v-col cols="7">
              <v-text-field
                label="Cicle"
                placeholder="Cicle"
                :value="nomCiclo(ciclo.id_ciclo)"
                readonly
              ></v-text-field>
            </v-col>
            <v-col cols="2">
              <v-text-field
                label="Any"
                placeholder="Any de finalització"
                v-model="ciclo.any"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="3">
              <v-checkbox v-model="ciclo.validado" label="Validat" placeholder="Validat"></v-checkbox>
            </v-col>
          </v-row>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="indigo" @click="validaCiclo">Guardar</v-btn>
          <v-btn @click="closeDialogCiclo()">Cancel·lar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import API from "../lib/API";
import YesNoIcon from "../components/base/YesNoIcon";
import formRulesMixin from "../mixins/formRules.js";
import utilsMixin from "../mixins/utils";
import CicloChip from "../components/base/CicloChip";
import HelpButton from "../components/base/HelpButton";

export default {
  mixins: [formRulesMixin, utilsMixin],
  components: {
    YesNoIcon,
    HelpButton,
    CicloChip
  },
  props: ['id'],
  data: () => ({
    table: "alumnos",
    helpPage: "alumnos",
    headers: [
      { text: "Id", value: "id" },
      { text: "Nom", value: "nombre" },
      { text: "Cicles", value: "cicles", sortable: false },
      { text: "CV", value: "cv_enlace", sortable: false },
      { text: "Borsa", value: "bolsa" },
      { text: "Info", value: "info" },
      { text: "Modificat", value: "updated_at" },
      { text: "Accions", value: "action" }
    ],
    // Para el dialogo de ciclos
    dialogCiclo: false,
    ciclo: {}
  }),
  computed: {
    items() {
      return this.$store.getters.getAlumnos(this.$route.params.ids || this.id);
    },
    ciclos() {
      return this.$store.state.ciclos;
    }
  },
  mounted() {
    this.$emit("setTitle", "Candidats");
    this.$store.dispatch("loadData");
  },
  methods: {
    preAddItem() {
      if (!this.editItem.bolsa) {
        if (
          !confirm(
            "No has marcat la casella de 'Borsa treball' i per tant no rebras ofertes. Si vols marcar-la cancel·la aquesta finestra, en altre cas continua"
          )
        )
          return false;
      }
      this.addItem();
    },
    preOpenDialog(item) {
      let itemCiclos = { ...item };
      itemCiclos.ciclos = itemCiclos.ciclos.map(ciclo => ciclo.id_ciclo);
      this.openDialog(itemCiclos);
    },
    closeDialogCiclo() {
      this.dialogCiclo = false;
      this.ciclo = {};
    },
    nomCiclo(id) {
      return id && this.ciclos.length
        ? this.ciclos.find(ciclo => ciclo.id == id).ciclo
        : "";
    },
    descCiclo(id) {
      return id && this.ciclos.length
        ? this.ciclos.find(ciclo => ciclo.id == id).descrip
        : "";
    },
    toogleValida(ciclo, alumno) {
      if (this.imResponsable) {
        this.ciclo = { ...ciclo };
        this.ciclo.nombre = alumno;
        this.dialogCiclo = true;
      }
    },
    validaCiclo() {
      API.updateCicloAlum(this.ciclo)
        .then(resp => {
          let alumIndex = this.items.findIndex(
            alum => alum.id == resp.data.data.id
          );
          let validado = this.ciclo.validado;
          this.items.splice(alumIndex, 1, resp.data.data);
          this.closeDialogCiclo(); // No es el diálogo estándar
          this.msgOk(
            "updateCiclo",
            "Ciclo " +
              (validado ? "validado" : "desvalidado") +
              " correctamente"
          );
        })
        .catch(err => {
          this.msgErr(err);
          this.closeDialogCiclo();
        });
    }
  }
};
</script>

<style scoped>
a {
  text-decoration: none;
}
</style>
