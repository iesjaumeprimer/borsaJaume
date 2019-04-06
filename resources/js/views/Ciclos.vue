<template>
  <div>
    <div v-for="(error,i) in errors" :key="i">
      <v-alert v-model="error.show" :type="error.type" dismissible>{{ error.msg }}</v-alert>
    </div>

    <v-card>
      <v-card-title>
        <help-button v-if="helpPage" :page="helpPage"></help-button>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Filtrar taula"
          single-line
          hide-details
        ></v-text-field>

        <v-spacer></v-spacer>
        <v-btn v-if="imAdmin" top right color="indigo" dark @click.stop="openDialog(false)">
          <v-icon>add</v-icon>
        </v-btn>
      </v-card-title>
      <v-data-table
        :items="items"
        no-data-text="No hi ha dades disponibles"
        rows-per-page-text="Registres per pàgina"
        :headers="headers"
        :search="search"
        class="elevation-1"
      >
        <template slot="headerCell" slot-scope="props">
          <v-tooltip bottom>
            <span slot="activator">{{ props.header.text }}</span>
            <span>{{ props.header.text }}</span>
          </v-tooltip>
        </template>

        <template slot="items" slot-scope="props">
          <td>{{ props.item.codigo }}</td>
          <td>{{ props.item.ciclo }}</td>
          <td>{{ props.item.vCiclo }}</td>
          <td>{{ nomResponsable(props.item.responsable) }}</td>
          <td>{{ props.item.Dept }}</td>
          <td>{{ props.item.vDept }}</td>
          <td v-if="imAdmin" class="justify-center layout px-0">
            <v-btn icon class="mx-0" @click="openDialog(props.item)">
              <v-icon>edit</v-icon>
            </v-btn>
            <v-btn icon class="mx-0" @click="deleteItem(props.item, 'ciclo')">
              <v-icon>delete</v-icon>
            </v-btn>
          </td>
        </template>
        <v-alert
          slot="no-results"
          :value="true"
          color="error"
          icon="warning"
        >La cerca de "{{ search }}" no dona cap resultat</v-alert>
        <template  class="text-sm-left" slot="actions-prepend">
          <help-button v-if="helpPage" :page="helpPage"></help-button>
        </template>
        <template
          slot="pageText"
          slot-scope="props"
        >Registres del {{ props.pageStart }} al {{ props.pageStop }} de {{ props.itemsLength }}</template>
      </v-data-table>
    </v-card>

    <v-dialog v-model="dialog" width="800px" @keydown.esc="closeDialog">
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-card>
          <v-card-title class="grey lighten-4 py-4 title">{{ isNew?'Nou':'Editar' }} cicle</v-card-title>
          <v-container grid-list-sm class="pa-4">
            <v-layout row wrap>
              <v-flex xs2>
                <v-text-field label="Id" placeholder="Id" v-model="editItem.id" readonly></v-text-field>
              </v-flex>
              <v-flex xs3>
                <v-text-field
                  label="Codi"
                  placeholder="Codi"
                  v-model="editItem.codigo"
                  mask="NNNN"
                  counter="4"
                  required
                ></v-text-field>
              </v-flex>
              <v-flex xs7>
                <v-text-field
                  label="Cicle"
                  placeholder="Cicle"
                  v-model="editItem.ciclo"
                  counter="50"
                  :rules="required50Rules"
                  required
                ></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-text-field
                  label="Nom"
                  placeholder="Nom"
                  v-model="editItem.vCiclo"
                  counter="80"
                  :rules="required80Rules"
                  required
                ></v-text-field>
              </v-flex>
              <v-flex xs4>
                <v-select
                  v-model=editItem.Dept
                  label="Departament"
                  :items="departaments"
                  item-value="cod"
                  item-text="nombre"
                  required>
                </v-select>
              </v-flex>
              <v-flex xs6>
                <v-select
                  label="Responsable"
                  :items="responsables"
                  v-model="editItem.responsable"
                  item-text="name"
                  item-value="id"
                  required
                  single-line
                ></v-select>
              </v-flex>
            </v-layout>
          </v-container>
          <v-card-actions>
            <help-button v-if="helpPage" :page="helpPage+'/dialog'"></help-button>
            <v-spacer></v-spacer>
            <v-btn flat color="primary" @click="preAddItem">Guardar</v-btn>
            <v-btn flat @click="closeDialog">Cancel·lar</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>
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
      { text: "CodDep.", value: "Dept" },
      { text: "Família", value: "vDept" }
    ]
  }),
  mounted() {
    this.$emit("setTitle", "Manteniment de Cicles");
    this.loadData();
  },
  computed: {
    objectProfes() {
      let aux = {};
      this.responsables.forEach(profe => (aux[profe.id] = profe.nombre));
      return aux;
    }
  },
  methods: {
    loadData() {
      API.getTable(this.table)
        .then(resp => {
          this.items = resp.data.data;
        })
        .catch(err => this.msgErr(err));
      API.getTable("users")
        .then(
          resp =>
            (this.responsables = resp.data.data
              .filter(resp => resp.rol == "3")
              .map(resp => {
                return {
                  id: resp.id,
                  name: resp.name
                };
              }))
        )
        .catch(err => this.msgErr(err));
      this.departaments=[
        {cod: 'Adm', nombre: 'Administratiu'},
        {cod: 'Hos', nombre: 'Hosteleria i Turisme'},
        {cod: 'Img', nombre: 'Imatge Personal'},
        {cod: 'Inf', nombre: 'Informàtica'},
        {cod: 'San', nombre: 'Sanitària'},
        {cod: 'Srv', nombre: 'Serveis a la Comunitat'},
        
      ]
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
