<template>
  <div>
    <div v-for="(error,i) in errors" :key="i">
      <v-alert v-model="error.show" :type="error.type" dismissible>{{ error.msg }}</v-alert>
    </div>

    <v-toolbar flat color="white">
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Filtrar taula"
        single-line
        hide-details
      ></v-text-field>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="500px" @keydown.esc="closeDialog">
        <template v-slot:activator="{ on }">
          <v-btn color="primary" dark class="mb-2" v-on="on">
            <v-icon>add</v-icon>
          </v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">{{ isNew?'Nou':'Editar' }} usuari</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm8>
                  <v-text-field v-model="editItem.name" label="Nom"></v-text-field>
                </v-flex>
                <v-flex xs12 sm4>
                    <v-select
                        :items="roles"
                        v-model="editItem.rol"
                        item-text="rol"
                        item-value="id"
                        label="Rol"
                    >
                    </v-select>
                </v-flex>
                <v-flex xs12 sm9>
                  <v-text-field v-model="editItem.email" label="e-mail"></v-text-field>
                </v-flex>
                <v-flex xs12 sm3>
                    <v-checkbox
                        v-model="editItem.active"
                        label="Actiu"
                        placeholder="Actiu"
                        :disabled="editItem.rol>3"
                    ></v-checkbox>
                </v-flex>
                <v-flex xs12 sm6 v-if="isNew">
                  <v-text-field v-model="editItem.password" label="Contrasenya"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 v-if="isNew">
                  <v-text-field v-model="editItem.password_confirmation" label="Repeteix la contrasenya"></v-text-field>
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
        <td>{{ rolDescrip(props.item.rol) }}</td>
        <td>
          <yes-no-icon :value="props.item.active"></yes-no-icon>
        </td>
        <td class="justify-center layout px-0">
          <v-icon class="mr-2" @click="openDialog(props.item)">edit</v-icon>
          <v-icon @click="deleteItem(props.item, 'el responsable '+props.item.name)">delete</v-icon>
        </td>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="alert('clicked')">Reset</v-btn>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import API from "../lib/API";
import YesNoIcon from "../components/base/YesNoIcon";
import formRulesMixin from "../mixins/formRules.js";
import utilsMixin from "../mixins/utils.js";
import { ROLES } from '../app.constants';

export default {
  mixins: [formRulesMixin, utilsMixin],
  components: {
    YesNoIcon
  },
  data: () => ({
    table: "users",
    headers: [
      {
        text: "Nom",
        align: "left",
        value: "nombre"
      },
      { text: "e-mail", sortable: false, value: "email" },
      { text: "Rol", value: "rol" },
      { text: "Actiu", value: "active" },
      { text: "Accions", sortable: false }
    ],
    roles: ROLES,
  }),

  watch: {
    dialog(val) {
      val || this.closeDialog();
    }
  },

  created() {
    this.$emit("setTitle", "Manteniment d'usuaris");
    this.loadItems();
  },

  methods: {
      rolDescrip(rol) {
          return this.roles.find(r=>r.id==rol).rol;
      },
    addItem() {
      // OJO. SObreescrito de utils.js pq no hace POST sino SINGUP
      if (this.editIndex > -1) {
        API.updateItem(this.table, this.editItem.id, this.editItem)
          .then(resp => {
            let index = this.items.findIndex(item => item.id == resp.data.id);
            this.items.splice(index, 1, resp.data);
            this.msgOk("update");
          })
          .catch(err => this.msgErr(err));
      } else {
          let itemSaved={...this.editItem};
        API.saveUser(this.editItem)
          .then(resp => {
            this.items.push({
                id: resp.data.id,
                name: itemSaved.name,
                rol: itemSaved.rol,
                email: itemSaved.email,
                active: itemSaved.active
            });
            this.msgOk("save");
            if (resp.data.rol == 5) {
              // Es una empresa
                this.$router.push({name: 'empresas', params: {
                  new: true,
                  id: resp.data.id,
                  name: resp.data.name
                }})
              alert(
                "S'ha creat l'usuari. Ara has de crear l'empresa i omplir les seues dades"
              );
            } else if (resp.data.rol == 7) {
              // Es un alumno
                this.$router.push({name: 'alumnos', params: {
                  new: true,
                  id: resp.data.id,
                  name: resp.data.name
                }})
              alert(
                "S'ha creat l'usuari. Ara has de crear l'alumne i omplir les seues dades"
              );
            }
          })
          .catch(err => this.msgErr(err));
        this.closeDialog();
      }
    }
  }
};
</script>