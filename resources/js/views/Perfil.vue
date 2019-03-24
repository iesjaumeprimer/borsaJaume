<template>
    <div>
        <div v-for="(error,i) in errors" :key="i">
            <v-alert v-model="error.show" :type="error.type" dismissible>
                {{ error.msg }}
            </v-alert>
        </div>
  <v-form ref="form" v-model="valid" lazy-validation>
              <v-container grid-list-sm class="pa-4">
          <v-layout row wrap>
<v-flex xs3>
            <v-text-field
                v-model="item.username" 
                label="Nom d'usuari" 
                title="Nom d'usuari" 
                required
                :rules="usernameRules"
            >
            </v-text-field>
</v-flex>
<v-flex xs5>
            <v-text-field
                v-model="item.email" 
                label="E-mail" 
                title="E-mail" 
                required
                :rules="emailRules"
            >
            </v-text-field>
</v-flex>
<v-flex xs4>
            <v-text-field
                v-model="item.rol" 
                label="Rol" 
                title="Rol" 
                read-only
            >
            </v-text-field>
</v-flex>
            <template>   
                <!-- Si es una empresa -->
                            <v-flex xs2>
              <v-text-field
                label="Id"
                placeholder="Id"
                v-model="item.id"
                readonly
              ></v-text-field>
            </v-flex>
            <v-flex xs3>
              <v-text-field
                label="Cif"
                placeholder="Cif"
                v-model="item.cif"
                mask="N#######N"
                counter="9"
              ></v-text-field>
            </v-flex>
            <v-flex xs7>
              <v-text-field
                label="Nom"
                placeholder="Nom"
                v-model="item.nombre"
                counter="50"
                :rules="required50Rules"
                required
              ></v-text-field>
            </v-flex>
            <v-flex xs8>
              <v-textarea
                label="Domicil·li"
                placeholder="Domicil·li"
                v-model="item.domicilio"
                counter="150"
                :rules="required150Rules"
                required
              ></v-textarea>
            </v-flex>
            <v-flex xs4>
              <v-text-field
                label="Localitat"
                placeholder="Localitat"
                v-model="item.localidad"
                counter="50"
                :rules="required50Rules"
                required
              ></v-text-field>
              <v-text-field
                label="Persona de contacte"
                placeholder="Persona de contacte"
                v-model="item.contacto"
                counter="50"
                :rules="required50Rules"
                required
              ></v-text-field>
            </v-flex>
            <v-flex xs3>
              <v-text-field
                label="Telèfon"
                placeholder="Telèfon"
                v-model="item.telefono"
                counter="20"
                :rules="required20Rules"
                required
              ></v-text-field>
            </v-flex>
            <v-flex xs4>
              <v-text-field
                label="Pàgina web"
                placeholder="Pàgina web"
                v-model="item.web"
                counter="50"
                :rules="required50Rules"
              ></v-text-field>
            </v-flex>
            <v-flex xs5>
              <v-text-field
                label="E-mail"
                placeholder="E-mail"
                v-model="item.email"
                counter="100"
                :rules="required100Rules"
              ></v-text-field>
            </v-flex>
            <v-flex xs12>
              <v-textarea
                label="Descripció"
                placeholder="Descripció"
                v-model="item.descripcion"
                counter="400"
                rows="3"
              ></v-textarea>
            </v-flex>
            </template>
            <template>
                            <v-flex xs1>
              <v-text-field
                label="Id"
                placeholder="Id"
                v-model="item.id"
                readonly
              ></v-text-field>
            </v-flex>
            <v-flex xs3>
              <v-text-field
                label="Nom"
                placeholder="Nom"
                v-model="item.nombre"
                required
              ></v-text-field>
            </v-flex>
            <v-flex xs8>
              <v-text-field
                label="Cognoms"
                placeholder="Cognoms"
                v-model="item.apellidos"
                required
              ></v-text-field>
            </v-flex>
            <v-flex xs7>
              <v-textarea
                label="Domicil·li"
                placeholder="Domicil·li"
                v-model="item.domicilio"
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
                v-model="item.email"
                counter="100"
                :rules="required100Rules"
              ></v-text-field>
            </v-flex>
            <v-flex xs3>
              <v-text-field
                label="Telèfon"
                placeholder="Telèfon"
                v-model="item.telefono"
              ></v-text-field>
            </v-flex>
            <v-flex xs5>
              <v-text-field
                label="C.V."
                placeholder="Enllaç al CV en Linkedin, ..."
                v-model="item.cv_enlace"
              ></v-text-field>
            </v-flex>
            <v-flex xs2>
              <v-checkbox
                  v-model="item.info"
                  label="Rebre info."
                  placeholder="Si vols rebre informació del Centre"
              ></v-checkbox>
            </v-flex>
            <v-flex xs2>
              <v-checkbox
                  v-model="item.bolsa"
                  label="Borsa treball"
                  placeholder="Si vols participar en la borsa de treball"
              ></v-checkbox>
            </v-flex>

            </template>

          <v-chip 
            v-for="ciclo in item.ciclos" 
            :key="'cicl-'+ciclo.id_ciclo"
            @dblclick="toogleValida(ciclo, item.nombre+' '+item.apellidos)"
            :title="descCiclo(ciclo.id_ciclo)"
            :color="ciclo.validado?'':'red lighten-4'"
          >
            <v-avatar color="grey"><strong>{{ ciclo.any }}</strong></v-avatar>

            {{ nomCiclo(ciclo.id_ciclo) }}
        </v-chip>

    <v-btn
      :disabled="!valid"
      @click="submit"
    >
      submit
    </v-btn>
    <v-btn @click="clear">clear</v-btn>
          </v-layout></v-container>
  </v-form>
</div>

</template>

<script>
import API from '../lib/API'
import Roles from '../lib/Rols.js';
import formRulesMixin from '../mixins/formRules.js';

export default {
    mixins: [ formRulesMixin ],
    data: () => ({
        roles: Roles.getAllRoles(),
        errors: [],
      valid: false,
      item: {},
      isNew: false,
    }),
    mounted() {
        this.$emit("setTitle", "El meu perfil");
        this.loadData();
    },
    methods: {
        loadData() {
            API.getItem('users')
            .then(resp => this.item = resp.data.data)
            .catch(err=>this.errors.push({msg: err.data.message || err.message, type: 'error', show: true}))
        },        
      submit () {
        if (this.$refs.form.validate()) {
          this.item.rol = Roles.desc2Cod(this.rolDesc);
            API.updateItem(this.table, this.id, this.item)
                .then(resp=>{
                    this.item = resp.data;
                    this.item.acepta = false;
                    this.errors.push({msg: 'Datos guardados', type: 'success', show: true});
                    window.scroll(0,0);
                })              
                .catch(err=>{
                    this.errors.push({
                        msg: err.data.message || err.message, 
                        type: 'error', 
                        show: true
                    })
                    window.scroll(0,0);
                })
        }
      },
      clear () {
        this.$refs.form.reset();
        this.loadData(this.id);
      },
        delError(index) {
            this.errors.splice(index,1);
        },
        getRules(rule) {
            return this[rule];
        }
    }
  }
</script>
