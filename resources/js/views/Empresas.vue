<template>
  <div>
    <div v-for="(error,i) in errors" :key="i">
      <v-alert v-model="error.show" :type="error.type" dismissible>{{ error.msg }}</v-alert>
    </div>

    <v-card>
      <v-card-title>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Filtrar taula"
          single-line
          hide-details
        ></v-text-field>
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
          <tr>
            <td>{{ props.item.cif }}</td>
            <td>{{ props.item.nombre }}</td>
            <td>{{ props.item.localidad }}</td>
            <td class="text-xs-right">{{ props.item.telefono }}</td>
            <td>{{ props.item.email }}</td>
            <td class="justify-center layout px-0">
              <v-btn icon class="mx-0" @click="props.expanded = !props.expanded" title="Més dades">
                <v-icon>{{ props.expanded?'remove':'add' }}</v-icon>
              </v-btn>
              <v-btn icon class="mx-0" @click.stop="openDialog(props.item)">
                <v-icon>edit</v-icon>
              </v-btn>
              <v-btn
                icon
                class="mx-0"
                @click="deleteUser(props.item, 'la empresa \''+props.item.nombre+'\'')"
              >
                <v-icon>delete</v-icon>
              </v-btn>
              <v-btn icon class="mx-0" @click.stop="showItem(props.item.id)" title="Veure ofertes">
                <v-icon>event_note</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>
        <v-alert
          slot="no-results"
          :value="true"
          color="error"
          icon="warning"
        >La cerca de "{{ search }}" no dona cap resultat</v-alert>
        <template slot="expand" slot-scope="props">
          <v-card flat>
            <v-card-text>
              <strong>Domicil·li:</strong>
              {{ props.item.domicilio }}
              <br>
              <strong>Web:</strong>
              {{ props.item.web }}
              <br>
              <strong>Persona de Contacte amb Batoi:</strong>
              {{ props.item.contacto }}
              <br>
              <strong>Descripció:</strong>
              {{ props.item.descripcion }}
            </v-card-text>
          </v-card>
        </template>

        <template class="text-sm-left" slot="actions-prepend">
          <help-button v-if="helpPage" :page="helpPage"></help-button>
        </template>
        <template
          slot="pageText"
          slot-scope="props"
        >Registres del {{ props.pageStart }} al {{ props.pageStop }} de {{ props.itemsLength }}</template>
      </v-data-table>
    </v-card>

    <v-dialog v-model="dialog" width="800px" @keydown.esc="closeDialog" :fullscreen="$vuetify.breakpoint.smAndDown">
      <v-card>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-card-title class="grey lighten-4 py-4 title">{{ isNew?'Nou':'Editar' }} empresa</v-card-title>
          <v-container grid-list-sm class="pa-4">
            <v-layout row wrap>
              <v-flex xs4 sm2>
                <v-text-field label="Id" placeholder="Id" v-model="editItem.id" disabled></v-text-field>
              </v-flex>
              <v-flex xs6 sm3>
                <v-text-field
                  label="Cif"
                  placeholder="Cif"
                  v-model="editItem.cif"
                  mask="N#######N"
                  counter="9"
                ></v-text-field>
              </v-flex>
              <v-flex xs12 sm7>
                <v-text-field
                  label="Nom"
                  placeholder="Nom"
                  v-model="editItem.nombre"
                  counter="25"
                  :rules="required25Rules"
                  required
                ></v-text-field>
              </v-flex>
              <v-flex xs12 sm8>
                <v-textarea
                  label="Domicil·li"
                  placeholder="Domicil·li"
                  v-model="editItem.domicilio"
                  counter="80"
                  :rules="required80Rules"
                  required
                ></v-textarea>
              </v-flex>
              <v-flex xs8 sm4>
                <v-text-field
                  label="Localitat"
                  placeholder="Localitat"
                  v-model="editItem.localidad"
                  counter="25"
                  :rules="required25Rules"
                  required
                ></v-text-field>
                <v-text-field
                  label="Telèfon"
                  placeholder="Telèfon"
                  v-model="editItem.telefono"
                  counter="25"
                  :rules="required25Rules"
                  required
                ></v-text-field>
              </v-flex>
              <v-flex xs12 sm6>
                <v-text-field
                  label="Persona de contacte"
                  placeholder="Persona de contacte"
                  v-model="editItem.contacto"
                  counter="50"
                  :rules="required50Rules"
                  required
                ></v-text-field>
              </v-flex>
              <v-flex xs12 sm6>
                <v-text-field
                  label="Pàgina web"
                  placeholder="Pàgina web"
                  v-model="editItem.web"
                  counter="50"
                  :rules="required50Rules"
                ></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-textarea
                  label="Descripció"
                  placeholder="Descripció"
                  v-model="editItem.descripcion"
                  counter="200"
                  rows="2"
                ></v-textarea>
              </v-flex>
            </v-layout>
          </v-container>
          <v-card-actions>
            <help-button v-if="helpPage" :page="helpPage+'#editar-una-empresa'"></help-button>
            <v-spacer></v-spacer>
            <v-btn flat color="primary" :disabled="!valid" @click="addItem">Guardar</v-btn>
            <v-btn flat @click="closeDialog">Cancel·lar</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import API from "../lib/API";
import Headers from "../lib/Headers.js";
import utilsMixin from "../mixins/utils.js";
import formRulesMixin from "../mixins/formRules.js";
import HelpButton from "../components/base/HelpButton";

export default {
  mixins: [utilsMixin, formRulesMixin],
  components: { HelpButton },
  data: () => ({
    table: "empresas",
    helpPage: "empresas",
    headers: Headers.getTable("empresas"),
    // Para el dialogo
    dialogCiclos: false
  }),
  mounted() {
    this.$emit("setTitle", "Manteniment d'Empreses");
    this.loadData();
  },
  methods: {
    loadData() {
      if (this.imEmpresa) {
        // Es una empresa y sólo puede verse a sí misma
        API.getItem(this.table, this.myId)
          .then(resp => {
            this.items = [resp.data.data];
            // Si estoy creando un nuevo usuario lo edito
            if (this.$route.params.new) {
              let newEmpresa = this.items.find(
                item => item.id == this.$route.params.id
              );
              newEmpresa.nombre = this.$route.params.name;
              this.openDialog(newEmpresa);
            }
          })
          .catch(err => this.msgErr(err));
      } else {
        API.getTable(this.table)
          .then(resp => {
            this.items = resp.data.data;
            // Si estoy creando un nuevo usuario lo edito
            if (this.$route.params.new) {
              let newEmpresa = this.items.find(
                item => item.id == this.$route.params.id
              );
              newEmpresa.nombre = this.$route.params.name;
              this.openDialog(newEmpresa);
            }
          })
          .catch(err => this.msgErr(err));
      }
    },
    showItem(id) {
      this.$router.push({ path: "/ofertas", query: { id_empresa: id } });
    }
  }
};
</script>
