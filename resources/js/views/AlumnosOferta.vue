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
          :disabled="!selected.length"

          color="blue"
          @click.stop="openMailDialog()"
          >
          <v-icon>mail_outline</v-icon>
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
        v-model="selected"
        select-all
        :items="items"
        item-key="id_alumno"
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

    <template slot="headers" slot-scope="props">
      <tr>
        <th>
          <v-checkbox
            :input-value="props.all"
            :indeterminate="props.indeterminate"
            primary
            hide-details
            @click="toggleAll"
          ></v-checkbox>
        </th>
        <th
          v-for="header in props.headers"
          :key="header.text"
          :class="[header.sortable?'column sortable':'', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
          @click="changeSort(header.value)"
        >
          <v-icon small>arrow_upward</v-icon>
          {{ header.text }}
        </th>
      </tr>
    </template>        

        <template slot="items" slot-scope="props">
          <tr :active="props.selected" @click="props.selected = !props.selected">
            <td>
            <v-checkbox
                :input-value="props.selected"
                primary
                hide-details
            ></v-checkbox>
            </td>
            <td><yes-no-icon v-if="props.item.interes!=undefined" :value="props.item.interes"></yes-no-icon></td>
            <td class="text-xs-right">{{ props.item.id_alumno }}</td>
            <td>{{ props.item.nombre }}</td>
            <td>{{ props.item.apellidos }}</td>
            <td>
              <v-chip 
                v-for="ciclo in props.item.ciclos" 
                :key="'cicl-'+ciclo.id_ciclo"
                :title="ciclo.vCiclo"
                :color="ciclo.validado?'':'red lighten-4'"
                >
                <v-avatar color="grey"><strong>{{ ciclo.any }}</strong></v-avatar>
                {{ ciclo.ciclo }}
              </v-chip>

            </td>
            <td><a 
                v-if="props.item.cv_enlace" 
                :href="props.item.cv_enlace" 
                target="_blank">
                    <v-icon>folder_shared</v-icon>
            </a></td>

            <td class="justify-center layout px-0">
              <v-btn icon class="mx-0"  @click="props.expanded = !props.expanded" title="Més dades">
                <v-icon>{{ props.expanded?'remove':'add' }}</v-icon>
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
  </div>
    
</template>

<script>
import API from '../lib/API';
import YesNoIcon from '../components/base/YesNoIcon'
import utilsMixin from'../mixins/utils.js';

export default {
  mixins: [utilsMixin],
  components: {
        YesNoIcon
  },
  data: () => ({
    table: 'view-alumnos-oferta',
    pagination: {
        sortBy: 'nombre'
    },
    selected: [],
    headers: [
      { text: "Interessat", value: "interessat" },
      { text: "Id", value: "id_alumno" },
      { text: "Nom", value: "nombre" },
      { text: "Cognoms", value: "apellidos" },
      { text: "Cicles", value: "cicles", sortable: false },
      { text: "CV", value: "cv_enlace", sortable: false },
    ],
  }),
  mounted() {
    this.$emit('setTitle', 'Alumnes d\'una Oferta')
    this.loadData();
  },
  methods: {
    loadData() {
      API.getTable(this.table)
        .then(resp => {
          this.items = resp.data.data;
        })
        .catch(err => this.msgErr(err));
    },
    openMailDialog() {
        alert('mail')
    }
  }
};
</script>
