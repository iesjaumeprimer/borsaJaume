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
        <v-container  class="pa-4">
          <v-row>
            <v-col cols="12">
              <v-text-field 
                  v-model="item.email" 
                  label="E-mail" 
                  title="E-mail" 
                  placeholder="Introduix el email amb el qual et loguejaràs"
                  required
                  :rules="emailRules"
              >
              </v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field 
                  v-model="item.password" 
                  :append-icon="show ? 'mdi-eye-off' : 'mdi-eye'"
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
            </v-col>
            <v-col cols="6">
              <v-text-field 
                  v-model="item.password_confirmation" 
                  :append-icon="show ? 'mdi-eye-off' : 'mdi-eye'"
                  :type="show ? 'text' : 'password'"
                  @click:append="show = !show"
                  hint="Al menys 6 caràcters"
                  label="Repeteix la contrasenya" 
                  title="Repeteix la contrasenya" 
                  required
                  @change="checkPassword"
              >
              </v-text-field>
            </v-col>

            <v-col cols="12">
            <v-radio-group 
               v-if="isNew"
               v-model="item.rol"
               label="Quin tipus d'uauri ets:" 
              hint="Indica el teu rol en la Borsa" 
              :persistent-hint="true" 
              required
              row
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

            </v-col>

            <v-col cols="12">
                <v-checkbox
                  v-model="accepted"
                  label="Acepte la Política de privacitat de la Borsa de Treball"
                  :rules="requiredCheckRules"
                ></v-checkbox>
                <div class="font-weight-bold">Al registrar-se enviant aquest formulari està acceptant la <a href="/privacitat">Política de privacitat</a>
                i donant la seua <br>conformitat al tractament de les seues dades personals en els teminis
                i condicions allí indicades.</div>
              </v-col>

          </v-row>
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
          @click.stop="guardar()"
          >
          <v-icon>mdi-add</v-icon>Continuar
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
        accepted: false,
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
//          return;

        },
        guardar() {
          if (this.$refs.form.validate())
            if (this.item.rol) 
              this.saveUser()
            else
              alert('Has de indicar si ets empresa o alumne')
          else
            alert('Hi ha errors en les dades')
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
