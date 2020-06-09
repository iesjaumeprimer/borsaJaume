<template>
    <div>
        <div v-for="(error,i) in errors" :key="i">
            <v-alert v-model="error.show" :type="error.type" dismissible>
                {{ error.msg }}
            </v-alert>
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
              <span class="headline">{{ isNew?'Nou':'Editar' }} element del menú</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
              <v-col cols="5" sm="2">
                <v-text-field label="Id" placeholder="Id" v-model="editItem.id" disabled></v-text-field>
              </v-col>
                  <v-col cols="7" sm="3">
              <v-text-field
                label="Order"
                placeholder="Order"
                v-model="editItem.order"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="7">
              <v-text-field
                label="Text"
                placeholder="Text"
                v-model="editItem.text"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="5">
              <v-text-field
                label="Ruta"
                placeholder="Ruta"
                v-model="editItem.path"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="11" sm="6">
              <v-text-field
                label="Icona"
                placeholder="Icona"
                v-model="editItem.icon"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="1">
<v-icon>mdi-{{ editItem.icon }}</v-icon>
            </v-col>
            <!-- Roles -->
      <v-col cols="12" sm="9">
        <v-select
          :items="roles"
          item-value="id"
          item-text="rol"
          v-model="thisRoles"
          label="Rols"
          multiple
          chips
          hint="Qui tendrà accés a aquest menú"
          persistent-hint
        ></v-select>
      </v-col>
            <v-col cols="12" sm="3">
              <v-checkbox
                  v-model="editItem.active"
                  label="Element actiu"
                  placeholder="Si està actiu o deshabil·litat"
              ></v-checkbox>
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

        <template v-slot:item.icon="{ item }">
          <v-icon>mdi-{{ item.icon }}</v-icon>
        </template>
        <template v-slot:item.rol="{ item }">
         <span :title="descRoles(item.rol)">{{ item.rol }}</span>
        </template>
        <template v-slot:item.active="{ item }">
          <yes-no-icon :value="item.active"></yes-no-icon>
        </template>

    <template v-slot:item.action="{ item }">
      <v-icon
        
        class="mr-2"
        @click="openDialog(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        
        @click="deleteItem(item, `text`)"
      >
        mdi-delete
      </v-icon>
    </template>

      </v-data-table>
    </v-card>

    </div>
</template>

<script>
import Headers from '../lib/Headers.js';
import YesNoIcon from '../components/base/YesNoIcon';
import Roles from '../lib/Rols.js';
import utilsMixin from '../mixins/utils.js';
import HelpButton from "../components/base/HelpButton";

export default {
  mixins: [utilsMixin],
  components: {
    YesNoIcon,
    HelpButton
//    SubmenuList
  },
  data: () => ({
    table: 'menu',
    roles: Roles.getAllRoles(),
//    thisRoles: [],      // roles del item que se está editando
    helpPage: "menu",
    headers: Headers.getTable("menu")
    /*        headers: [
          { text: 'Id', value: 'id' },
          { text: 'Orden', value: 'order' },
          { text: 'Texto', value: 'text' },
          { text: 'Ruta', value: 'path' },
          { text: 'Icono', value: 'icon', sortable: false },
          { text: 'Submenús', value: 'children', comment: 'IDs de los ítems de su submenú'},
          { text: 'Desplegado', value: 'model', comment: 'Si tiene hijos indica si aparece desplegado por defecto' },
          { text: 'Icono-alt', value: 'icon_alt', sortable: false, comment: 'El icono a mostrar cuando está desplegado su submenú' },
          { text: 'Rol', value: 'rol', comment: 'A quién le aparecerá este ítem' },
          { text: 'Activo', value: 'active', comment: 'Los submenús deben estar desactivados para que no aparezcan también como ítem principal' },
        ],
*/
  }),
  mounted() {
    this.$emit('setTitle', 'Menú');
  },
  computed: {
    items() {
      return this.$store.state.menu;
    },
    thisRoles: {
      get() {
        return Roles.getRoles(this.editItem.rol);
      },
      set(arrayValues) {
        this.editItem.rol = arrayValues.reduce((total,item)=>total*item);
      }
    }
  },
  methods: {
    editarItem(item) {
      this.thisRoles = Roles.getRoles(item.rol)
      this.openDialog(item);
    },
    saveItem() {
        this.editItem.children=this.submenus.length?
            JSON.stringify(this.submenus.map(elem=>elem.id)):null;
        this.editItem.rol = this.thisRoles.reduce((total,elem)=>elem*total);
        this.addItem();
    },
    descRoles(rolNumber) {
      return Roles.getRoles(rolNumber).reduce((cadena, item) => cadena+', '+item.rol, '').substr(2);
    }
  }
};
</script>
