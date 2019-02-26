<template>
    <div>
        <div v-for="(error,i) in errors" :key="i">
            <v-alert v-model="error.show" :type="error.type" dismissible>
                {{ error.msg }}
            </v-alert>
        </div>

  <v-card>
    <v-card-title>
    <v-btn
      top
      right
      color="blue"
      dark
      @click.stop="editarItem(false)"
    >
      <v-icon>add</v-icon>
    </v-btn>

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
                <span slot="activator">
                    <!-- texto a mostrar-->
                    {{ props.header.text }}
                </span>
                <span>
                    <!-- title a mostrar -->
                    {{ props.header.comment }}
                </span>
          </v-tooltip>
      </template>
        
      <template slot="items" slot-scope="props">
        <td class="text-xs-right">{{ props.item.id }}</td>
        <td class="text-xs-right">{{ props.item.order }}</td>
        <td>{{ props.item.text }}</td>
        <td>{{ props.item.path }}</td>
        <td><v-icon>{{ props.item.icon }}</v-icon></td>
        <td>{{ props.item.children }} 
            <a  v-if="props.item.children" @click="expande(props)"> 
                <v-icon>add</v-icon>
            </a>
        </td>
        <template v-if="props.item.children">
            <td><v-icon>{{ props.item.model?'done':'clear' }}</v-icon></td>
            <td><v-icon>{{ props.item.icon_alt }}</v-icon></td>
        </template>
        <td v-else colspan="2"></td>
        <td>{{ props.item.rol }}</td>
        <td><v-icon>{{ props.item.active?'done':'clear' }}</v-icon></td>
        <td class="justify-center layout px-0">
          <v-btn icon class="mx-0" @click="editarItem(props.item)">
            <v-icon>edit</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="deleteItem(props.item, 'text')">
            <v-icon>delete</v-icon>
          </v-btn>
        </td>
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        La búsqueda de "{{ search }}" no produjo ningún resultado.
      </v-alert>

      <template slot="expand" slot-scope="props">
          <table>
              <tr>
                <th>Submenú</th>
                <th v-for="(encab,i) in headers" :key="i">{{ encab.text }}</th>
              </tr>
        <tr v-for="item in childItems" :key="item.id">
            <td></td>
            <td class="text-xs-right">{{ item.id }}</td>
            <td class="text-xs-right">{{ item.order }}</td>
            <td>{{ item.text }}</td>
            <td>{{ item.path }}</td>
            <td><v-icon>{{ item.icon }}</v-icon></td>
            <td>{{ item.children }}</td>
            <td><yes-no-icon :value="item.model"></yes-no-icon></td>
            <td><v-icon>{{ item.icon_alt }}</v-icon></td>
            <td>{{ item.rol }}</td>
            <td><yes-no-icon :value="item.active"></yes-no-icon></td>
        </tr>
          </table>
      </template>

    <template slot="pageText" slot-scope="props">
        Mostrando del {{ props.pageStart }} al {{ props.pageStop }} de {{ props.itemsLength }}
        </template>
    
    </v-data-table>
  </v-card>

    <v-dialog v-model="dialog" width="800px">
              <v-form ref="form" v-model="valid" lazy-validation>

      <v-card>
        <v-card-title
          class="grey lighten-4 py-4 title"
        >
          {{ isNew?'Nou':'Editar' }} element del menú
        </v-card-title>
        <v-container grid-list-sm class="pa-4">
          <v-layout row wrap>
            <v-flex xs1>
              <v-text-field
                label="Id"
                placeholder="Id"
                v-model="editItem.id"
                readonly
              ></v-text-field>
            </v-flex>
            <v-flex xs2>
              <v-text-field
                label="Order"
                placeholder="Order"
                v-model="editItem.order"
                required
              ></v-text-field>
            </v-flex>
            <v-flex xs6>
              <v-text-field
                label="Text"
                placeholder="Text"
                v-model="editItem.text"
                required
              ></v-text-field>
            </v-flex>
            <v-flex xs3>
              <v-text-field
                label="Ruta"
                placeholder="Ruta"
                v-model="editItem.path"
                required
              ></v-text-field>
            </v-flex>
            <v-flex xs4>
                <v-layout class="row">
              <v-text-field
                label="Icona"
                placeholder="Icona"
                v-model="editItem.icon"
                required
              ></v-text-field>
<v-icon>{{ editItem.icon }}</v-icon>

                </v-layout>
            </v-flex>


            <v-flex xs4>
              <v-checkbox
                  v-model="editItem.model"
                  label="Desplegat"
                  placeholder="Si ha d'aparèixer desplegst per defecte"
                :disabled="submenus.length==0"
              ></v-checkbox>
            </v-flex>

            <v-flex xs4>
                <v-layout class="row">
              <v-text-field
                label="Icona desplegat"
                placeholder="Icona desplegat"
                v-model="editItem.icon_alt"
                :disabled="submenus.length==0"
              ></v-text-field>
<v-icon>{{ editItem.icon_alt }}</v-icon>

                </v-layout>
            </v-flex>
            <v-flex xs3>
              <v-checkbox
                  v-model="editItem.active"
                  label="Element actiu"
                  placeholder="Si està actiu o deshabil·litat"
              ></v-checkbox>
            </v-flex>



            <!-- Roles -->
      <v-flex xs9>
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
      </v-flex>

    <!-- Submenús -->
      <v-flex xs12>
        <v-subheader v-text="'Marca los submenús de este menú'"></v-subheader>
        <!-- <submenu-list v-model="submenus" :itemId="editItem.id"></submenu-list>           -->
      </v-flex>

          </v-layout>
        </v-container>
        <v-card-actions>
          <v-btn flat color="primary">More</v-btn>
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="saveItem">Guardar</v-btn>
          <v-btn flat @click="closeDialog">Cancel·lar</v-btn>
        </v-card-actions>
      </v-card>
              </v-form>
    </v-dialog>

    </div>
</template>

<script>
import API from '../lib/API';
import Headers from '../lib/Headers.js';
import YesNoIcon from '../components/base/YesNoIcon';
import Roles from '../lib/Rols.js';
import utilsMixin from '../mixins/utils.js';

export default {
  mixins: [utilsMixin],
  components: {
    YesNoIcon,
//    SubmenuList
  },
  data: () => ({
    table: 'menu',
    roles: Roles.getAllRoles(),
    submenus: [],       // submenus del item que se está editando
    thisRoles: [],      // roles del item que se está editando
    expand: [],
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
    this.$emit('setTitle', 'Manteniment del Menú');
    this.loadData();
  },
  computed: {
    childItems() {
      return this.items.filter(item => this.expand.includes(item.id));
    }
  },
  methods: {
    loadData() {
      API.getTable("menu")
        .then(resp => this.items = resp.data.data)
        .catch(err => this.msgErr(err));
    },
    editarItem(item) {
      if (item.children) {
        this.submenus = JSON.parse(item.children).map(elem => {
            return { id: elem };
        });
      } else {
          this.submenus=[];
      }
      this.thisRoles = Roles.getRoles(item.rol)
      this.openDialog(item);
    },
    expande(props) {
      if (props.item.children) {
        props.expanded = !props.expanded;
        this.expand = JSON.parse(props.item.children);
      }
    },
    saveItem() {
        this.editItem.children=this.submenus.length?
            JSON.stringify(this.submenus.map(elem=>elem.id)):null;
        this.editItem.rol = this.thisRoles.reduce((total,elem)=>elem*total);
        this.addItem();
    }
  }
};
</script>
