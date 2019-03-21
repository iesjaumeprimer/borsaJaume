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
      v-if="user_rol<=3"
      top
      right
      color="blue"
      dark
      @click.stop="openDialog(false)"
    >
      <v-icon>add</v-icon>
    </v-btn>


        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Filtrar taula"
          single-line
          hide-details>
        </v-text-field>
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
              {{ props.header.text }}
            </span>
            <span>
              {{ props.header.text }}
            </span>
          </v-tooltip>
        </template>
        
        <template slot="items" slot-scope="props">
          <tr>
            <td class="text-xs-right">{{ props.item.id }}</td>
            <td>{{ props.item.nombre }}</td>
            <td>{{ props.item.apellidos }}</td>
            <td>
              <v-chip 
                v-for="ciclo in props.item.ciclos" 
                :key="'cicl-'+ciclo.id_ciclo"
                @dblclick="toogleValida(ciclo, props.item.nombre+' '+props.item.apellidos)"
                :title="descCiclo(ciclo.id_ciclo)"
                :color="ciclo.validado?'':'red lighten-4'"
                >
                <v-avatar color="grey"><strong>{{ ciclo.any }}</strong></v-avatar>

                {{ nomCiclo(ciclo.id_ciclo) }}
              </v-chip>

            </td>
            <td><a 
                v-if="props.item.cv_enlace" 
                :href="props.item.cv_enlace" 
                target="_blank">
                    <v-icon>folder_shared</v-icon>
            </a></td>
            <td><yes-no-icon :value="props.item.info"></yes-no-icon></td>
            <td><yes-no-icon :value="props.item.bolsa"></yes-no-icon></td>


            <td class="justify-center layout px-0">
              <v-btn icon class="mx-0"  @click="props.expanded = !props.expanded" title="Més dades">
                <v-icon>{{ props.expanded?'remove':'add' }}</v-icon>
              </v-btn>
              <v-btn icon class="mx-0" @click="openDialog(props.item)">
                <v-icon>edit</v-icon>
              </v-btn>
              <v-btn icon class="mx-0" @click="deleteItem(props.item, `l'alumne '${props.item.nombre} ${props.item.apellidos}'`)">
                <v-icon>delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>
        <v-alert slot="no-results" :value="true" color="error" icon="warning">
          La cerca de "{{ search }}" no dona cap resultat
        </v-alert>

        <template slot="expand" slot-scope="props">
          <v-card flat>
            <v-card-text>
              <strong>Domicil·li:</strong> {{ props.item.domicilio }}
              <v-spacer></v-spacer><strong>Telèfon:</strong> {{ props.item.telefono }}
              <v-spacer></v-spacer><strong>E-mail:</strong> {{ props.item.email }}
            </v-card-text>
          </v-card>
        </template>

        <template slot="pageText" slot-scope="props">      
          Registres del {{ props.pageStart }} al {{ props.pageStop }} de {{ props.itemsLength }}
        </template>
        
      </v-data-table>
    </v-card>

    <v-dialog v-model="dialog" width="800px" @keydown.esc="closeDialog">
      <v-form ref="form" v-model="valid" lazy-validation>

        <v-card>
          <v-card-title
          class="grey lighten-4 py-4 title"
          >
          {{ isNew?'Nou':'Editar' }} alumne
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
            <v-flex xs3>
              <v-text-field
              label="Nom"
              placeholder="Nom"
              v-model="editItem.nombre"
              required
              ></v-text-field>
            </v-flex>
            <v-flex xs8>
              <v-text-field
              label="Cognoms"
              placeholder="Cognoms"
              v-model="editItem.apellidos"
              required
              ></v-text-field>
            </v-flex>
            <v-flex xs7>
              <v-textarea
              label="Domicil·li"
              placeholder="Domicil·li"
              v-model="editItem.domicilio"
              counter="150"
              :rules="required150Rules"
              rows="3"
              required
              ></v-textarea>
            </v-flex>
            <v-flex xs5>
              <v-text-field
              label="E-mail"
              placeholder="E-mail"
              v-model="editItem.email"
              counter="100"
              :rules="required100Rules"
              ></v-text-field>
            </v-flex>
            <v-flex xs3>
              <v-text-field
              label="Telèfon"
              placeholder="Telèfon"
              v-model="editItem.telefono"
              ></v-text-field>
            </v-flex>
            <v-flex xs6>
              <v-text-field
              label="C.V."
              placeholder="Enllaç al CV en Linkedin, ..."
              v-model="editItem.cv_enlace"
              ></v-text-field>
            </v-flex>
            <v-flex xs2>
              <v-checkbox
              v-model="editItem.info"
              label="Rebre info."
              placeholder="Si vols rebre informació del Centre"
              ></v-checkbox>
            </v-flex>
      <v-flex xs9>
        <v-select
          :items="ciclos"
          v-model="editItem.ciclos"
          item-text="ciclo"
          item-value="id"
          label="Cicles demanats"
          multiple
          chips
          hint="Els aspirants han de tindre algú d'quests cicles"
          persistent-hint
        >
          <template slot="append">
            <span>append</span>
          </template>
          <p>sin nada</p>
          <template slot="append-item">
            <span>append-item</span>
          </template>
          <template slot="append-outer">
            <span>append-outer</span>
          </template>
          <template slot="default">
            <span>default</span>
          </template>
          <template slot="prepend">
            <span>prepend</span>
          </template>
          <template slot="prepend-item">
            <span>prepend-item</span>
          </template>
        </v-select>
      </v-flex>
            <v-flex xs2>
              <v-checkbox
              v-model="editItem.bolsa"
              label="Borsa treball"
              placeholder="Si vols participar en la borsa de treball"
              ></v-checkbox>
            </v-flex>
          </v-layout>
        </v-container>
        <v-card-actions>
          <v-btn flat color="primary">More</v-btn>
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="addItem">Guardar</v-btn>
          <v-btn flat @click="closeDialog">Cancel·lar</v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
    </v-dialog>

    <v-dialog v-model="dialogCiclo" width="400px">
      <v-card>
        <v-card-title
        class="grey lighten-4 py-4 title"
        >
        {{ ciclo.nombre }}
      </v-card-title>
      <v-container grid-list-sm class="pa-4">
        <v-layout row wrap>
          <v-flex xs7>
            <v-text-field
            label="Cicle"
            placeholder="Cicle"
            :value="nomCiclo(ciclo.id_ciclo)"
            readonly
            ></v-text-field>
          </v-flex>
          <v-flex xs2>
            <v-text-field
            label="Any"
            placeholder="Any de finalització"
            v-model="ciclo.any"
            required
            ></v-text-field>
          </v-flex>
          <v-flex xs3>
            <v-checkbox
            v-model="ciclo.validado"
            label="Validat"
            placeholder="Validat"
            ></v-checkbox>
          </v-flex>
        </v-layout>
      </v-container>
      <v-card-actions>
        <v-btn flat color="primary">More</v-btn>
        <v-spacer></v-spacer>
        <v-btn flat color="primary" @click="validaCiclo">Guardar</v-btn>
        <v-btn flat @click="closeDialogCiclo()">Cancel·lar</v-btn>
      </v-card-actions>
    </v-card>
    </v-dialog>

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
    table: 'alumnos',
    headers: [
      { text: "Id", value: "id" },
      { text: "Nom", value: "nombre" },
      { text: "Cognoms", value: "apellidos" },
      { text: "Cicles", value: "cicles", sortable: false },
      { text: "CV", value: "cv_enlace", sortable: false },
      { text: "Info", value: "info"},
      { text: "Borsa", value: "bolsa" },
      { text: "Accions", value: "" },
    ],
    ciclos: [],
    // Para el dialogo de ciclos
    dialogCiclo: false,
    ciclo: {},
    user_rol: null
  }),
  mounted() {
    console.log('Alumnos mounted');
    this.$emit('setTitle', 'Manteniment d\'Alumnes');
    this.user_rol=sessionStorage.user_rol;
    if (this.$route.params.new) {
      this.dialog=true;
      this.editItem.id=this.$route.params.id;
    } else {
      this.loadData();
    }
  },
  methods: {
    loadData() {
      console.log('carga alumnos');
      if (this.user_rol==7) {
        // Es un alumno y sólo puede verse a sí mismo
        API.getItem(this.table, sessionStorage.user_id)
          .then(resp => {
            this.items = [resp.data.data];
          })
          .catch(err => this.msgErr(err));
      } else {
        API.getTable(this.table)
          .then(resp => {
            this.items = resp.data.data;
          })
          .catch(err => this.msgErr(err));
      }
      API.getTable("ciclos")
        .then(resp => this.ciclos = resp.data.data.map(ciclo=>{
          return {
            id: ciclo.id, 
            ciclo: ciclo.ciclo,
            descrip: ciclo.vCiclo
          };
        }))          
        .catch(err => this.msgErr('2'+err));
    },
    closeDialogCiclo() {
      this.dialogCiclo = false;
      this.ciclo = {};
    },
    nomCiclo(id) {
      return (id&&this.ciclos.length)?this.ciclos.find(ciclo => ciclo.id==id).ciclo:'';
    },
    descCiclo(id) {
      return (id&&this.ciclos.length)?this.ciclos.find(ciclo => ciclo.id==id).descrip:'';
    },
    toogleValida(ciclo, alumno) {
      this.ciclo=ciclo;
      this.ciclo.nombre=alumno;
      this.dialogCiclo=true;
    },
    validaCiclo() {
        API.updateItem('alumnos_ciclos', this.ciclo.id, this.ciclo)
          .then(resp => {
            this.ciclos[this.ciclos.indexOf(resp.data)] = resp.data;
            this.closeDialogCiclo();  // No es el diálogo estándar
            this.msgOk('updateCiclo', 'Ciclo '+(resp.data.validado?'validado':'desvalidado')+' correctamente');
          })
          .catch(err => this.msgErr('3'+err));      
    }
  }
};
</script>
