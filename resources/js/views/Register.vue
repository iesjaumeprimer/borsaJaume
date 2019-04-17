<template>
    <div>
        <div v-for="(error,i) in errors" :key="i">
            <v-alert v-model="error.show" :type="error.type" dismissible>
                {{ error.msg }}
            </v-alert>
        </div>
      <v-card>
        <v-form ref="form" v-model="valid" lazy-validation>

        <v-card-title
          class="grey lighten-4 py-4 title"
        >
          {{ isNew?'Nou':'Editar' }} usuari
        </v-card-title>
        <v-container grid-list-sm class="pa-4">
          <v-layout row wrap>
            <v-flex xs12 ms9>
              <div>
              <v-text-field xs12 ms4
                  v-model="item.name" 
                  label="Nom d'usuari" 
                  title="Nom d'usuari" 
                  placeholder="Introduix un nom per a dirigir-nos a tu"
                  required
                  :rules="usernameRules"
              >
              </v-text-field>
              <v-text-field xs12 ms5
                  v-model="item.email" 
                  label="E-mail" 
                  title="E-mail" 
                  placeholder="Introduix el email amb el qual et loguejaràs"
                  required
                  :rules="emailRules"
              >
              </v-text-field>
              <v-text-field xs12 ms4
                  v-model="item.password" 
                  :append-icon="show ? 'visibility' : 'visibility_off'"
                  :type="show ? 'text' : 'password'"
                  @click:append="show = !show"
                  hint="Al menys 6 caràcters"
                  label="Contrasenya" 
                  title="Contrasenya" 
                  required
                  min="4"
                  max="25"
                  counter="25"
                  :rules="required25Rules"
              >
              </v-text-field>
              <v-text-field xs12 ms4
                  v-model="item.password_confirmation" 
                  :append-icon="show ? 'visibility' : 'visibility_off'"
                  :type="show ? 'text' : 'password'"
                  @click:append="show = !show"
                  hint="Al menys 6 caràcters"
                  label="Repeteix la contrasenya" 
                  title="Repeteix la contrasenya" 
                  required
                  @change="checkPassword"
              >
              </v-text-field>

              </div>

            </v-flex>
            <v-flex xs12 ms3>
              <div>
            <v-radio-group 
               v-if="isNew"
               v-model="item.rol"
               label="Quin tipus d'uauri ets:" 
              hint="Indica el teu rol en la Borsa:" 
              :persistent-hint="true" 
              required
            >
      <v-radio
        label="Empresa - Ofereix un treball"
        :value="5"
      ></v-radio>
      <v-radio
        label="Alumne - Busque un treball"
        :value="7"
      ></v-radio>
      <v-radio v-if="imAdmin"
        label="Responsable - Gestiona la borsa"
        :value="3"
      ></v-radio>
    </v-radio-group>

              </div>
            </v-flex>
          </v-layout>
        </v-container>
        </v-form>
        <v-card-actions>
            <help-button v-if="helpPage" :page="helpPage"></help-button>
            <v-spacer></v-spacer>
        <v-btn
          bottom
          right
          color="blue"
          dark
          @click.stop="saveUser()"
          >
          <v-icon>add</v-icon>Continuar
        </v-btn>

        </v-card-actions>
      </v-card>
    </div>
</template>

<script>
import API from '../lib/API';
import utilsMixin from '../mixins/utils.js';
import formRulesMixin from '../mixins/formRules.js';
import HelpButton from '../components/base/HelpButton';

export default {
  mixins: [utilsMixin, formRulesMixin],
  components: { HelpButton },
  props: ['username', 'password', 'rol'],
      data: () => ({
        helpPage: 'registre',
        item: {},
        show: false,
    }),
    mounted() {
      this.$emit('setTitle', 'Registre de nou usuari');
    },
    methods: {
        checkPassword() {
            if (this.item.password_confirmation !== this.item.password) {
                alert('Les contrasenyes no coincideixen');
                this.item.password_confirmation='';
            }
        },
        checkUser() {
          alert('checkeado');
          return;
              API.ckeckUsername(this.item.username)
                .then(resp => {
                    if (resp.data!='ok') {
                        alert('L\'usuari '+this.item.username+' no està lliure. Has de triar altre');
                        this.item.username='';
                    }
                })
                .catch(err => this.msgErr(err));

        },
        saveUser() {
            API.saveUser(this.item)
            .then(resp => {
              this.setToken(resp.data);               
              alert(`El teu usuari s'ha creat correctament.
                  Ara has d'omplir les teues dades`);
              if (resp.data.rol==5) {
                // Es una empresa
                this.$router.push({name: 'empresas', params: {
                  new: true,
                  id: resp.data.id,
                  name: resp.data.name
                }})
              } else {
                // Es un alumnos
                this.$router.push({name: 'alumnos', params: {
                  new: true,
                  id: resp.data.id,
                  name: resp.data.name
                }})
              }
            })
            .catch(err => {
              this.clearToken();
              this.msgErr(err);
            }); // if the request fails, remove any possible user token if possible
        }
    },
}
</script>
