<template>
  <div>
    <div v-for="(error,i) in errors" :key="i">
      <v-alert v-model="error.show" :type="error.type" dismissible>
        {{ error.msg }}
      </v-alert>
    </div>

    <v-toolbar flat color="white">
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Filtrar taula"
          single-line
          hide-details>
        </v-text-field>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="500px">
        <template v-slot:activator="{ on }">
          <v-btn color="primary" dark class="mb-2" v-on="on">
              <v-icon>add</v-icon>
          </v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">{{ isNew?'Nuevo':'Editar' }} responsable</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editItem.name" label="Nom"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editItem.email" label="e-mail"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editItem.rol" label="Rol"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editItem.active" label="Actiu"></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click="closeDialog">Cancel·lar</v-btn>
            <v-btn color="blue darken-1" flat @click="addItem">Guardar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="items"
      :search="search"
      class="elevation-1"
      no-data-text="No hi ha dades disponibles"
      rows-per-page-text="Registres per pàgina"
    >
      <template v-slot:items="props">
        <td>{{ props.item.name }}</td>
        <td>{{ props.item.email }}</td>
        <td class="text-xs-right">{{ props.item.rol }}</td>
        <td><yes-no-icon :value="props.item.active"></yes-no-icon></td>
        <td class="justify-center layout px-0">
          <v-icon
            class="mr-2"
            @click="openDialog(props.item)"
          >
            edit
          </v-icon>
          <v-icon
            @click="deleteItem(props.item, 'el responsable '+props.item.name)"
          >
            delete
          </v-icon>
        </td>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="alert('clicked')">Reset</v-btn>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import API from '../lib/API';
import YesNoIcon from '../components/base/YesNoIcon'
import formRulesMixin from '../mixins/formRules.js';
import utilsMixin from '../mixins/utils.js';

export default {
  mixins: [formRulesMixin, utilsMixin],
  components: {
        YesNoIcon
  },
    data: () => ({
      table: 'users',
//      dialog: false,
      headers: [
        {
          text: 'Nom',
          align: 'left',
          value: 'nombre'
        },
        { text: 'e-mail', sortable: false, value: 'email' },
        { text: 'Rol', value: 'rol' },
        { text: 'Actiu', value: 'active' },
        { text: 'Accions', sortable: false }
      ],
      editIndex: -1,
    //   editItem: {
    //     name: '',
    //     calories: 0,
    //     fat: 0,
    //     carbs: 0,
    //     protein: 0
    //   },
    }),

    watch: {
      dialog (val) {
        val || this.closeDialog()
      }
    },

    created () {
      this.$emit('setTitle', 'Manteniment de Responsables');
      this.loadItems();
    },

  }
</script>