<template>
  <div>
    <div v-for="(error, i) in errors" :key="i">
      <v-alert v-model="error.show" :type="error.type" dismissible>{{
        error.msg
      }}</v-alert>
    </div>

    <v-card>
      <v-card-title>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Filtrar taula..."
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :items="items"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
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
          <tr color="red">
            <td>
              <v-chip
                @dblclick.stop="openDialogValidar(props.item)"
                :color="props.item.interesado ? 'teal' : 'red'"
              >
                <v-icon v-if="props.item.interesado == undefined"
                  >help_outline</v-icon
                >
                <yes-no-icon
                  v-else
                  :value="props.item.interesado"
                ></yes-no-icon>
              </v-chip>
            </td>
            <td>{{ props.item.empresa.nombre }}</td>
            <td>{{ props.item.puesto }}</td>
            <td>{{ props.item.tipo_contrato }}</td>
            <td>
              <v-chip
                v-for="ciclo in props.item.ciclos"
                :key="'cicl-' + ciclo.id_ciclo"
                :title="descCiclo(ciclo.id_ciclo)"
              >
                <v-avatar color="grey">
                  <strong>{{ ciclo.any_fin }}</strong>
                </v-avatar>
                {{ nomCiclo(ciclo.id_ciclo) }}
              </v-chip>
            </td>
            <td>
              {{
                props.item.updated_at
                  ? new Date(props.item.updated_at).toLocaleDateString()
                  : "---"
              }}
            </td>
            <td class="justify-center layout px-0">
              <v-btn
                v-if="props.item.mostrar_contacto"
                icon
                class="mx-0"
                title="Més dades"
                @click="props.expanded = !props.expanded"
              >
                <v-icon>{{ props.expanded ? "remove" : "add" }}</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>
        <v-alert slot="no-results" :value="true" color="error" icon="warning"
          >La cerca de "{{ search }}" no dona cap resultat</v-alert
        >

        <template slot="expand" slot-scope="props">
          <v-layout row wrap>
            <v-flex xs6>
              <v-card flat>
                <v-card-text>
                  <strong>Descripció:</strong>
                  {{ props.item.descripcion }}
                  <template v-if="props.item.contacto">
                    <br />
                    <strong>Contacte:</strong>
                    {{ props.item.contacto }}
                  </template>
                  <template v-if="props.item.email">
                    <br />
                    <strong>E-mail:</strong>
                    {{ props.item.email }}
                  </template>
                  <template v-if="props.item.telefono">
                    <br />
                    <strong>Telèfon:</strong>
                    {{ props.item.telefono }}
                  </template>
                  <template v-if="props.item.resultat">
                    <br />
                    <strong>Resultat:</strong>
                    {{ props.item.resultat }}
                  </template>
                </v-card-text>
              </v-card>
            </v-flex>
            <v-flex xs6>
              <v-card flat>
                <v-card-text>
                  <template>
                    <strong>DADES EMPRESA</strong>
                    <br />
                    <strong>Domicil·li:</strong>
                    {{ props.item.empresa.domicilio }}
                    <br />
                    <strong>Localitat:</strong>
                    {{ props.item.empresa.localidad }}
                    <br />
                    <strong>Pàgina web:</strong>
                    <a target="_blank" :href="props.item.empresa.web">{{
                      props.item.empresa.web
                    }}</a>
                  </template>
                </v-card-text>
              </v-card>
            </v-flex>
          </v-layout>
          <v-divider></v-divider>
        </template>

        <template class="text-sm-left" slot="actions-prepend">
          <help-button v-if="helpPage" :page="helpPage"></help-button>
        </template>
        <template slot="pageText" slot-scope="props"
          >Registres del {{ props.pageStart }} al {{ props.pageStop }} de
          {{ props.itemsLength }}</template
        >
      </v-data-table>
    </v-card>

    <!-- Dialog interesado -->
    <v-layout row justify-center>
      <v-dialog v-model="dialogValidar" persistent max-width="290">
        <v-card>
          <v-card-title class="headline"
            >{{
              ofertaInteressat.interesado == 1 ? "Desapuntar-te" : "Apuntar-te"
            }}
            a l'Oferta</v-card-title
          >
          <v-card-text>
            Vas a
            {{
              ofertaInteressat.interesado == 1 ? "Desapuntar-te" : "Apuntar-te"
            }}
            a l'oferta '
            <strong>{{ ofertaInteressat.puesto }}</strong>
            '. ¿Deseas continuar?
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" flat @click.native="apuntaOferta"
              >Aceptar</v-btn
            >
            <v-btn
              color="green darken-1"
              flat
              @click.native="dialogValidar = false"
              >Cancel·lar</v-btn
            >
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </div>
</template>

<script>
import API from "../lib/API";
import formRulesMixin from "../mixins/formRules.js";
import utilsMixin from "../mixins/utils.js";
import YesNoIcon from "../components/base/YesNoIcon";
import HelpButton from "../components/base/HelpButton";

export default {
  mixins: [formRulesMixin, utilsMixin],
  components: {
    HelpButton,
    YesNoIcon,
  },
  data: () => ({
    //    table: "ofertas-alum",
    table: "ofertas",
    sortBy: 'updated_at',
    sortDesc: true,
    helpPage: "ofertas/ofertasxalumno",
    headers: [
      { text: "Publicada", value: "updated_at" },
      { text: "Interessat", value: "interesado" },
      { text: "Empresa", value: "id_empresa" },
      { text: "Lloc de treball", value: "puesto" },
      { text: "Contracte", value: "tipo_contrato" },
      { text: "Cicles", value: "cicles" },
    ],
    empresas: [],
    ciclos: [],
    // Dialog validar
    dialogValidar: false,
    ofertaInteressat: {},
  }),
  mounted() {
    this.$emit("setTitle", "Ofertes actives");
    this.loadData();
    this.editItem.ciclos = [];
  },
  methods: {
    loadData() {
      API.getTable(this.table, this.$route.query)
        .then((resp) => {
          this.items = resp.data;
          console.log(resp.data);
        })
        .catch((err) => this.msgErr(err));
      API.getTable("ciclos")
        .then(
          (resp) =>
            (this.ciclos = resp.data.data.map((ciclo) => {
              return {
                id: ciclo.id,
                ciclo: ciclo.ciclo,
                descrip: ciclo.vCiclo,
                dept: ciclo.Dept,
                familia: ciclo.vDept,
              };
            }))
        )
        .catch((err) => this.msgErr(err));
    },
    nomEmpresa(id) {
      return id && this.empresas.length
        ? this.empresas.find((empresa) => empresa.id == id).nombre
        : "";
    },
    nomCiclo(id) {
      return id && this.ciclos.length
        ? this.ciclos.find((ciclo) => ciclo.id == id).ciclo
        : "";
    },
    descCiclo(id) {
      return id && this.ciclos.length
        ? this.ciclos.find((ciclo) => ciclo.id == id).descrip
        : "";
    },
    rellenaContacto() {
      let newEmpresa = this.empresas.find(
        (empresa) => empresa.id == this.editItem.id_empresa
      );
      for (let campo of ["telefono", "email", "contacto"])
        if (!this.editItem[campo]) this.editItem[campo] = newEmpresa[campo];
    },
    newOferta() {
      // Asignamos los valores por defecto
      this.editItem = {
        activa: true,
        ciclos: [],
      };
      this.openDialog(false);
    },
    openDialogValidar(oferta) {
      this.dialogValidar = true;
      this.ofertaInteressat = oferta;
    },
    apuntaOferta() {
      API.updateInteresado(
        this.ofertaInteressat.id,
        this.ofertaInteressat.interesado == 1 ? false : true
      )
        .then((res) => (this.ofertaInteressat.interesado = res.data.interesado))
        .catch((err) => this.msgErr(err));
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
        this.editItem = { ...oferta };
        this.editItem.archivada = true;
        // Y guardamos la modificación
        this.isNew = false;
        this.addItem();
        this.items = this.items.filter((elem) => elem.id != oferta.id);
      }
    },
  },
};
</script>
