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
            <v-btn           v-if="imEmpresa || imResponsable && !isArxiu"
            color="indigo" dark class="mb-2" v-on="on">
                        <v-icon>mdi-plus</v-icon>
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ isNew?'Nova':'Editar' }} oferta</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
              <v-col cols="4" sm="2">
                <v-text-field label="Id" placeholder="Id" v-model="editItem.id" disabled></v-text-field>
              </v-col>
            <v-col cols="4" sm="2">
              <v-checkbox 
                v-model="editItem.activa" 
                label="Activa" 
                placeholder="Activa"
                :disabled="isArxiu"
              ></v-checkbox>
            </v-col>
            <v-col cols="4" sm="2">
              <v-checkbox
                v-model="editItem.validada"
                label="Validada"
                placeholder="Validada"
                disabled
              ></v-checkbox>
            </v-col>
            <v-col cols="12" sm="6">
              <v-select
                :disabled="isArxiu"
                :readonly="!imResponsable"
                label="Descripció"
                placeholder="Empresa"
                :items="empresas"
                v-model="editItem.id_empresa"
                item-text="nombre"
                item-value="id"
                required
                single-line
                @change="rellenaContacto"
              ></v-select>
            </v-col>
            <v-col cols="5" sm="3" md="2">
              <v-text-field
                :disabled="isArxiu"
                label="Telèfon"
                placeholder="Telèfon"
                v-model="editItem.telefono"
                counter="25"
                :rules="required25Rules"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="7" sm="5" md="4">
              <v-text-field
                :disabled="isArxiu"
                label="E-mail"
                placeholder="E-mail"
                v-model="editItem.email"
                counter="50"
                :rules="required50Rules"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="7" sm="4" md="4">
              <v-text-field
                :disabled="isArxiu"
                label="Persona de contacte"
                placeholder="Persona de contacte"
                v-model="editItem.contacto"
                counter="50"
                :rules="required50Rules"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="5" sm="4" md="2">
              <v-checkbox
                :disabled="isArxiu"
                v-model="editItem.mostrar_contacto"
                label="Mostrar contacte"
                :hint="'Els interessats '+(editItem.mostrar_contacto?'':'NO ')+'podran veure el mail, tfn. i persona de contacte'"
                persistent-hint
              ></v-checkbox>
            </v-col>
            <v-col cols="12" sm="8" md="12">
              <v-text-field
                :disabled="isArxiu"
                label="Lloc de treball"
                placeholder="Lloc de treball"
                v-model="editItem.puesto"
                counter="50"
                :rules="required50Rules"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-textarea
                :disabled="isArxiu"
                label="Descripció"
                placeholder="Descripció"
                counter="800"
                v-model="editItem.descripcion"
                required
              ></v-textarea>
            </v-col>
            <v-col cols="12">
              <v-text-field
                :disabled="isArxiu"
                label="Tipus de contracte"
                placeholder="Tipus de contracte"
                v-model="editItem.tipo_contrato"
                counter="50"
                :rules="required50Rules"
                required
              ></v-text-field>
            </v-col>
            <!-- Ciclos -->
            <v-col cols="12" sm="9">
              <v-select
                :disabled="isArxiu"
                :items="ciclos"
                v-model="editItem.ciclos"
                item-text="ciclo"
                item-value="id"
                label="Cicles demanats"
                multiple
                chips
                hint="Els aspirants han de tindre algú d'quests cicles"
                persistent-hint
              ></v-select>
            </v-col>
            <v-col cols="12" sm="3">
              <v-checkbox
                :disabled="isArxiu"
                v-model="editItem.estudiando"
                label="Inclou estudiants"
                title="Inclou també als alumnes que encara estan estudiant algun d'aquests cicles"
                persistent-hint
              ></v-checkbox>
              <v-text-field
                label="Any màxim"
                title="Només alumnes que hagen acabat els estudis amb posterioritat a aquest any"
                placeholder="d'acabar el cicle"
                v-model="editItem.any"
                mask="####"
                :disabled="!editItem.ciclos || editItem.ciclos.length==0 || isArxiu"
              ></v-text-field>
            </v-col>
            <v-col v-if="editItem.validada" cols="12">
              <v-textarea
                :disabled="isArxiu"
                rows="2"
                label="Resultat"
                placeholder="Per favor, quan finalitze el procés indica ací el resultat de l'oferta (si s'ha cobert o no i per què)"
                v-model="editItem.resultat"
              ></v-textarea>
            </v-col>
                </v-row>
              </v-container>
            </v-card-text>
          <v-card-actions>
            <help-button v-if="helpPage" :page="helpPage+'#editar-una-oferta'"></help-button>
            <v-spacer></v-spacer>
            <v-btn color="indigo" @click="addItem" :disabled="!valid">Guardar</v-btn>
            <v-btn @click="closeDialog">Cancel·lar</v-btn>
          </v-card-actions>

          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>

        <template v-slot:item.activa="{ item }">
              <v-chip
                :color="item.validada?'teal':'red'"
                @dblclick.stop="openDialogValidar(item)"
                :title="(item.activa?'Activa':'No activa')+' / '
            +(item.validada?'Validada':'No validada')"
              >
                <yes-no-icon :value="item.activa"></yes-no-icon>
              </v-chip>
        </template>

        <template v-slot:item.id_empresa="{ item }">
          <a href="#" @click.prevent="goto('/empresas/'+item.id_empresa)">
{{ nomEmpresa(item.id_empresa) }}</a>
        </template>

        <template v-slot:item.cicles="{ item }">
          <ciclo-chip
            v-for="ciclo in item.ciclos"
            :key="ciclo.id_ciclo"
            :ciclo="ciclo"
          ></ciclo-chip>
        </template>
        <template v-slot:item.updated_at="{ item }">
          {{ toFecha(item.updated_at )}}
        </template>

    <template v-slot:item.action="{ item }">
      <v-icon  v-if="imEmpresa || imResponsable"
        
        class="mr-2"
        @click="preOpenDialog(item)"
      >
        mdi-{{ isArxiu?'eye':'pencil' }}
      </v-icon>
      <v-icon v-if="!isArxiu"
        
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
      <v-icon :disabled="!item.alumnos.length"
         title="Veure candidats"
        @click="goto({ name: 'alumnos', params: { ids: idAlumnos(item.alumnos) } } )"
      >
        mdi-account-multiple
      </v-icon>

    </template>
        <template v-slot:expanded-item="{ headers, item }">
          <td :colspan="headers.length">
            <v-row>

            <v-col cols="12" sm="7">
            <v-card>
              <v-card-text>
                <h3>Altres dades de l'oferta</h3>
              <strong>Tipus de contracte:</strong>
              {{ item.tipo_contrato }}
              <br>
              <strong>Descripció:</strong>
              {{ item.descrip }}
              <template v-if="item.mostrar_contacto">
              <br>
              <strong>Persona de contacte:</strong>
              {{ item.contacto }}
              <br>
              <strong>email:</strong>
              {{ item.email }}
              <br>
              <strong>Telèfon:</strong>
              {{ item.telefono }}

              </template>
                          </v-card-text>
            </v-card>

            </v-col>
            <v-col cols="12" sm="5">
            <v-card>
            <v-card-title>Candidats interessats</v-card-title>
            <v-card-text>
              <ul>
              <li v-for="alum in item.alumnos" :key="alum.id">
                <strong>
                  <a
                    :href="'/alumnos/'+alum.id"
                    title="Ver datos del candidato"
                  >{{ alum.nombre+' '+alum.apellidos }}</a>
                </strong>
                &mdash;
                <strong>e-mail:</strong>
                {{ alum.email }}
              </li>

              </ul>
            </v-card-text>
            </v-card>

            </v-col>
            </v-row>
          </td>
        </template>

      </v-data-table>
    </v-card>

    <!-- Dialog validar -->
    <v-row justify="center">
      <v-dialog v-model="dialogValidar" persistent max-width="290" @keydown.esc="dialogValidar = false">
        <v-card>
          <v-card-title class="headline">{{ ofertaValidar.validada?'Invalidar':'Validar'}} Oferta</v-card-title>
          <v-card-text>
            Vas a {{ ofertaValidar.validada?'in':''}}validar l'oferta '
            <strong>{{ ofertaValidar.puesto }}</strong>
            '. ¿Deseas continuar?
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" flat @click.native="validaOferta">Aceptar</v-btn>
            <v-btn color="green darken-1" flat @click.native="dialogValidar = false">Cancel·lar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
    <!-- <ofertas-validar-dialog :dialogValidar.sync="dialogValidar" :ofertaValidar="ofertaValidar">
    </ofertas-validar-dialog> -->
  </div>
</template>

<script>
import API from "../lib/API";
import formRulesMixin from "../mixins/formRules.js";
import utilsMixin from "../mixins/utils.js";
import YesNoIcon from "../components/base/YesNoIcon";
import HelpButton from "../components/base/HelpButton";
import CicloChip from "../components/base/CicloChip";
// import OfertasValidarDialog from './OfertasValidarDialog';

export default {
  mixins: [formRulesMixin, utilsMixin],
  components: {
    YesNoIcon,
    HelpButton,
    CicloChip,
    // OfertasValidarDialog
  },
  data: () => ({
    helpPage: "ofertas",
    headers: [
      { text: "Activa", value: "activa" },
      { text: "Empresa", value: "id_empresa" },
      { text: "Lloc de treball", value: "puesto" },
      { text: "Cicles", value: "cicles" },
      { text: "Modificat", value: "updated_at" },
      { text: "Accions", value: "action" }
    ],
    // Dialog validar
    dialogValidar: false,
    ofertaValidar: {}
  }),
  computed: {
    items() {
      return this.$store.getters.getOfertas(this.isArxiu);
    },
    ciclos() {
      return this.$store.state.ciclos;
    },
    empresas() {
      return this.$store.state.empresas;
    },
        isArxiu () {
            return this.$route.path === '/ofertas-arxiu';
        },
        table() {
          return this.isArxiu?'ofertas-arxiu':'ofertas';
        }
  },
  mounted() {
    this.$emit("setTitle", this.isArxiu?"Ofertes arxivades":"Ofertes");
    this.$store.dispatch("loadData");
    this.editItem.ciclos = [];
    this.editItem.archivada = 0;
    this.editItem.estudiando = 0;
},
  methods: {
    idAlumnos(arrayAlumnos) {
      return arrayAlumnos.map(item => item.id)
    },
    preOpenDialog(item) {
      let itemCiclos = { ...item };
      itemCiclos.ciclos = itemCiclos.ciclos.map(ciclo => ciclo.id_ciclo);
      this.openDialog(itemCiclos);
    },
    nomEmpresa(id) {
      return this.$store.getters.getEmpresaById(id).nombre;
    },
    rellenaContacto() {
      let newEmpresa = this.$store.getters.getEmpresaById(this.editItem.id_empresa);
      for (let campo of ["telefono", "email", "contacto"])
        this.editItem[campo] = newEmpresa[campo];
    },
    dialogNewOferta() {
      let defaultItem = {
        activa: true,
        mostrar_contacto: true,
        ciclos: []
      };
      this.openDialog(defaultItem);
      if (this.imEmpresa) {
        this.editItem.id_empresa = this.myId;
        this.rellenaContacto(this.myId);
      } else if (this.$route.query && this.$route.query.id_empresa) {
        this.editItem.id_empresa = Number(this.$route.query.id_empresa);
        this.rellenaContacto();
      }
    },
    openDialogValidar(oferta) {
      if (this.imResponsable) {
        if (oferta.activa || oferta.validada) {
          // Si la oferta está activa puede validarse o invalidarse
          // Si no está activa sólo puede invalidarse
          this.ofertaValidar = { ...oferta };
          this.dialogValidar = true;
        }
      }
    },
    validaOferta() {
      this.editItem = this.ofertaValidar;
      this.editIndex = this.items.findIndex(
        elem => elem.id == this.editItem.id
      );
      // La cambiamos la validación
      API.updateOfertaValida(this.editItem.id, !this.editItem.validada)
      .then(resp=>this.items[this.editIndex].validada=resp.data.data.validada)
      .catch(err=>this.msgErr(err))
      this.dialogValidar = false;
    },
    deleteItem(oferta) {
      // Las ofertas no se borran, se archivan
      if (
        confirm(
          "Segur que vols arxivar definitivament l'oferta '" +
            oferta.puesto +
            "' de l'empresa '" +
            this.nomEmpresa(oferta.id_empresa) +
            "'?"
        )
      ) {
        // La marcamos como archivada
        this.editIndex = this.items.indexOf(oferta);
        this.editItem = { ...oferta };
        this.editItem.archivada = true;
        // Y guardamos la modificación
        this.addItem();
        this.items = this.items.filter(elem => elem.id != oferta.id);
      }
    }
  }
};
</script>
