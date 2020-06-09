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
      <v-toolbar flat color="white">
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
              <span class="headline">{{ isNew?'Nova':'Editar' }} empresa</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
              <v-col cols="4" sm="2">
                <v-text-field label="Id" placeholder="Id" v-model="editItem.id" disabled></v-text-field>
              </v-col>
                  <v-col cols="8" sm="3" md="2">
                <v-text-field
                  label="Cif"
                  placeholder="Cif"
                  v-model="editItem.cif"
                  mask="N#######N"
                  counter="9"
                  :rules="cifRules"
                ></v-text-field>
              </v-col>
                  <v-col cols="12" sm="7" md="8">
                <v-text-field
                  label="Nom"
                  placeholder="Nom"
                  v-model="editItem.nombre"
                  counter="25"
                  :rules="required25Rules"
                  required
                ></v-text-field>
              </v-col>
                  <v-col cols="12" sm="12" md="8">
                <v-textarea
                  label="Domicil·li"
                  placeholder="Domicil·li"
                  v-model="editItem.domicilio"
                  counter="80"
                  :rules="required80Rules"
                  required
                  rows="2"
                ></v-textarea>
              </v-col>
                  <v-col cols="6" sm="6" md="4">
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
              </v-col>
                  <v-col cols="12" sm="6" md="6">
                  <v-text-field
                  label="Persona de contacte"
                  placeholder="Persona de contacte"
                  v-model="editItem.contacto"
                  counter="50"
                  :rules="required50Rules"
                  required
                ></v-text-field>
              </v-col>
                  <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="Pàgina web"
                  placeholder="Pàgina web"
                  v-model="editItem.web"
                  counter="50"
                ></v-text-field>
              </v-col>
                  <v-col cols="12">
                <v-textarea
                  label="Descripció"
                  placeholder="Descripció"
                  v-model="editItem.descripcion"
                  counter="200"
                  rows="2"
                ></v-textarea>
              </v-col>
                </v-row>
              </v-container>
            </v-card-text>
          <v-card-actions>
            <help-button v-if="helpPage" :page="helpPage+'#editar-una-empresa'"></help-button>
            <v-spacer></v-spacer>
            <v-btn color="indigo" @click="addItem" :disabled="!valid">Guardar</v-btn>
            <v-btn @click="closeDialog">Cancel·lar</v-btn>
          </v-card-actions>

          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>

        <template v-slot:item.nombre="{ item }">
          {{ item.nombre }} {{ item.apellidos }}
        </template>
        <template v-slot:item.updated_at="{ item }">
          {{ toFecha(item.updated_at )}}
        </template>

    <template v-slot:item.action="{ item }">
      <v-icon
        
        class="mr-2"
        @click="openDialog(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        
        @click="deleteUser(item, `la empresa '${item.nombre}'`)"
      >
        mdi-delete
      </v-icon>
      <v-icon
         title="Veure ofertes"
        @click="showItem(item.id)"
      >
        mdi-calendar-text
      </v-icon>

    </template>
        <template v-slot:expanded-item="{ headers, item }">
          <td :colspan="headers.length">
            <v-card flat>
              <v-card-text>
              <strong>Domicil·li:</strong>
              {{ item.domicilio }}
              <br>
              <strong>Web:</strong>
              <a :href="item.web" target="_blank">{{ item.web }}</a>
              <br>
              <strong>Descripció:</strong>
              {{ item.descripcion }}
              <template if="!ImAlumno">
            
              <br>
              <strong>Telèfon:</strong>
              {{ item.tele }}
              <br>
              <strong>E-mail:</strong>
              {{ item.descripcion }}
              <br>
              <strong>Persona de Contacte amb Batoi:</strong>
              {{ item.contacto }}
              </template>
            </v-card-text>
            </v-card>
          </td>
        </template>

      </v-data-table>
    </v-card>

  </div>
</template>

<script>
import Headers from "../lib/Headers.js";
import utilsMixin from "../mixins/utils.js";
import formRulesMixin from "../mixins/formRules.js";
import HelpButton from "../components/base/HelpButton";

export default {
  mixins: [utilsMixin, formRulesMixin],
  components: { HelpButton },
  props: ['id'],
  data: () => ({
    table: "empresas",
    helpPage: "empresas",
    headers: Headers.getTable("empresas"),
    // Para el dialogo
    dialogCiclos: false
  }),
  computed: {
    items() {
      return this.id
      ?[ this.$store.getters.getEmpresaById(this.id) ]
      :this.$store.state.empresas;
    },
  },
  mounted() {
    this.$emit("setTitle", "Empreses");
    this.$store.dispatch("loadData");
  },
  methods: {
    showItem(id) {
      this.$router.push({ path: "/ofertas", query: { id_empresa: id } });
    },
  }
};
</script>
