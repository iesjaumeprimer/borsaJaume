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
        item-key="id"
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
        <v-dialog v-model="dialog" max-width="800px" @keydown.esc="closeDialog">
          <template v-slot:activator="{ on }">
            <v-btn color="indigo" dark class="mb-2" v-on="on">
                        <v-icon>mdi-plus</v-icon>
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ isNew?'Nou':'Editar' }} cicle</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="3" md="2">
                <v-text-field label="Id" placeholder="Id" v-model="editItem.id" readonly></v-text-field>
              </v-col>
                  <v-col cols="12" sm="5" md="3">
                <v-text-field
                  label="Codi"
                  placeholder="Codi"
                  v-model="editItem.codigo"
                  mask="NNNN"
                  counter="4"
                  required
                ></v-text-field>
              </v-col>
                  <v-col cols="12" sm="10" md="7">
                <v-text-field
                  label="Cicle"
                  placeholder="Cicle"
                  v-model="editItem.ciclo"
                  counter="50"
                  :rules="required50Rules"
                  required
                ></v-text-field>
              </v-col>
                  <v-col cols="12">
                <v-text-field
                  label="Nom"
                  placeholder="Nom"
                  v-model="editItem.vCiclo"
                  counter="80"
                  :rules="required80Rules"
                  required
                ></v-text-field>
              </v-col>
                  <v-col cols="12" sm="6" md="4">
                <v-select
                  v-model=editItem.Dept
                  label="Departament"
                  :items="departaments"
                  item-value="cod"
                  item-text="nombre"
                  required>
                </v-select>
              </v-col>
                  <v-col cols="12" sm="9" md="6">
                <v-select
                  label="Responsable"
                  :items="responsables"
                  v-model="editItem.responsable"
                  item-text="name"
                  item-value="id"
                  required
                  single-line
                ></v-select>
              </v-col>
                </v-row>
              </v-container>
            </v-card-text>
          <v-card-actions>
            <help-button v-if="helpPage" :page="helpPage+'#editar-un-ciclo'"></help-button>
            <v-spacer></v-spacer>
            <v-btn color="indigo" @click="preAddItem" :disabled="!valid">Guardar</v-btn>
            <v-btn @click="closeDialog">Cancel·lar</v-btn>
          </v-card-actions>

          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>

        <template v-slot:item.responsable="{ item }">
          <td>{{ nomResponsable(item.responsable) }}</td>
        </template>

    <template v-slot:item.action="{ item }">
      <v-icon
        
        class="mr-2"
        @click="openDialog(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        
        @click="deleteItem(item, `el cicle '${item.ciclo}'`)"
      >
        mdi-delete
      </v-icon>
    </template>



      </v-data-table>
    </v-card>

  </div>
</template>

<script>
import API from "../lib/API";
import formRulesMixin from "../mixins/formRules.js";
import utilsMixin from "../mixins/utils.js";
import HelpButton from '../components/base/HelpButton'

export default {
  name: "ciclos",
  mixins: [formRulesMixin, utilsMixin],
  components: { HelpButton },
  data: () => ({
    table: "ciclos",
    helpPage: "ciclos",
    responsables: [],
        departaments: [], 
    headers: [
      { text: "Codi", value: "codigo" },
      { text: "Cicle", value: "ciclo" },
      { text: "Nom", value: "vCiclo" },
      { text: "Responsable", value: "responsable" },
      { text: "Família", value: "vDept" },
      { text: "Accions", value: "action" }
    ]
  }),
  computed: {
    items() {
      return this.$store.state.ciclos;
    },
    objectProfes() {
      let aux = {};
      this.responsables.forEach(profe => (aux[profe.id] = profe.nombre));
      return aux;
    }
  },
  mounted() {
    this.$emit("setTitle", "Cicles");
    this.$store.dispatch("loadData");
  },
  methods: {
    loadData() {
      API.getTable("users")
        .then(
          resp =>
            (this.responsables = resp.data.data
              .filter(resp => resp.rol <= "3")
              .map(resp => {
                return {
                  id: resp.id,
                  name: resp.name
                };
              }))
        )
        .catch(err => this.msgErr(err));
    },
    nomResponsable(id_resp) {
      let responsable = this.responsables.find(resp => resp.id == id_resp);
      return responsable ? responsable.name : "";
    },
    preAddItem() {
      this.editItem.vDept=this.departaments.find(dep=>dep.cod==this.editItem.Dept).nombre;
      this.addItem();
    }
  }
};
</script>
