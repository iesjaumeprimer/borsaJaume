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
            <v-text-field
                v-model="item.name" 
                label="Nom d'usuari" 
                title="Nom d'usuari" 
                required
                :rules="usernameRules"
                @change="checkUser"
            >
            </v-text-field>
            <v-text-field
                v-model="item.password" 
                label="Contrasenya" 
                title="Contrasenya" 
                required
                min="4"
                max="25"
                counter="25"
                :rules="required20Rules"
            >
            </v-text-field>
            <v-text-field
                v-model="item.password_confirmation" 
                label="Repeteix la contrasenya" 
                title="Repeteix la contrasenya" 
                required
                @change="checkPassword"
            >
            </v-text-field>
            <v-text-field
                v-model="item.email" 
                label="E-mail" 
                title="E-mail" 
                required
                :rules="emailRules"
            >
            </v-text-field>
            <v-radio-group 
               v-if="isNew"
               v-model="item.rol" 
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

        <v-btn
          bottom
          right
          color="blue"
          dark
          @click.stop="saveUser()"
          >
          <v-icon>add</v-icon>Continuar
        </v-btn>

          </v-layout>
        </v-container>
        </v-form>
      </v-card>
    </div>
</template>

<script>
import API from '../lib/API';
import utilsMixin from '../mixins/utils.js';
import formRulesMixin from '../mixins/formRules.js';

export default {
  mixins: [utilsMixin, formRulesMixin],
  props: ['username', 'password', 'rol'],
      data: () => ({
        item: {},
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
          console.log('registrnado...')
            API.saveUser(this.item)
            .then(resp => {
              sessionStorage.access_token=resp.data.access_token;
              sessionStorage.expires_at=resp.data.expires_at;
              sessionStorage.user_rol=resp.data.rol;
              sessionStorage.user_id=resp.data.id;
              sessionStorage.token_type=resp.data.token_type;
               
              alert(`El teu usuari s'ha creat correctament.
                  Ara has d'omplir les teues dades`);
              if (resp.data.rol==5) {
                // Es una empresa
                this.$router.push({name: 'empresas', params: {
                  new: true,
                  id: resp.data.id
                }})
              } else {
                // Es un alumnos
                this.$router.push({name: 'alumnos', params: {
                  new: true,
                  id: resp.data.id
                }})
              }
            })
            .catch(err => {
              sessionStorage.removeItem('access_token');
              sessionStorage.removeItem('expires_at');
              sessionStorage.removeItem('user_rol');
              sessionStorage.removeItem('user_id');
              sessionStorage.removeItem('token_type');
              this.msgErr(err);
            }); // if the request fails, remove any possible user token if possible
        }
    },
}
</script>
