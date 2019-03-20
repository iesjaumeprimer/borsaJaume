<template>
        <div>
            <h1>Inicia sessió</h1>
        <div v-for="(error,i) in errors" :key="i">
            <v-alert v-model="error.show" :type="error.type" dismissible>
                {{ error.msg }}
            </v-alert>
        </div>
  <v-form ref="form" v-model="valid" lazy-validation>
            <v-text-field
                v-model="item.email" 
                label="e-Mail" 
                title="e-Mail" 
                required
                :rules="emailRules"
            >
            </v-text-field>
            <v-text-field
                v-model="item.password" 
                label="Contrasenya" 
                title="Contrasenya" 
                required
                :rules="usernameRules"
            >
            </v-text-field>
            <p><a href="#">He oblidat la meua contrasenya</a></p>
    <v-btn
      :disabled="!valid"
      @click="submit"
    >
      Login
    </v-btn>
    <v-btn @click.stop="openDialog(false)">Registrar-se</v-btn>
  </v-form>

  <v-dialog v-model="dialog" width="800px">
      <v-card>
        <v-form ref="form" v-model="valid" lazy-validation>

        <v-card-title
          class="grey lighten-4 py-4 title"
        >
          {{ isNew?'Nou':'Editar' }} compte
        </v-card-title>
        <v-container grid-list-sm class="pa-4">
          <v-layout row wrap>
            <v-text-field
                v-model="editItem.username" 
                label="Nom d'usuari" 
                title="Nom d'usuari" 
                required
                :rules="usernameRules"
            >
            </v-text-field>
            <v-text-field
                v-model="editItem.password" 
                label="Contrasenya" 
                title="Contrasenya" 
                required
                :rules="usernameRules"
            >
            </v-text-field>
            <v-text-field
                v-model="password2" 
                label="Repeteix la contrasenya" 
                title="Repeteix la contrasenya" 
                required
                :rules="usernameRules"
            >
            </v-text-field>
            <v-text-field
                v-model="editItem.email" 
                label="E-mail" 
                title="E-mail" 
                required
                :rules="emailRules"
            >
            </v-text-field>
            <v-radio-group 
               v-if="isNew"
               v-model="editItem.rol" 
              hint="Indica el teu rol en la borsa:" 
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
    </v-radio-group>
          </v-layout>
        </v-container>
        <v-card-actions>
          <v-btn flat color="primary">More</v-btn>
          <v-spacer></v-spacer>
          <v-btn flat color="primary" :disabled="!valid" @click="registerUser">Guardar</v-btn>
          <v-btn flat @click="closeDialog()">Cancel·lar</v-btn>
        </v-card-actions>
                    </v-form>
      </v-card>
    </v-dialog>


    </div>    
</template>

<script>
import API from '../lib/API';
import utilsMixin from '../mixins/utils.js';
import formRulesMixin from '../mixins/formRules.js';

export default {
  mixins: [utilsMixin, formRulesMixin],
      data() { 
          return {
//            editItem: {},
            item: {},
            password2: '',

            }
      },
      methods: {
          submit() {
            API.getUser(this.item)
            .then(resp => {
              if (resp.data.access_token) {
                sessionStorage.access_token=resp.data.access_token;
                sessionStorage.expires_at=resp.data.expires_at;
                sessionStorage.user_rol=resp.data.rol;
                sessionStorage.user_id=resp.data.id;
                sessionStorage.token_type=resp.data.token_type;
                this.$router.push('/ofertas');
              } else {
                this.msgErr('ERROR, no s\'ha pogut loguejar: '+resp.data);
              }
            }) // store the token in localstorage
            .catch(err => {
              sessionStorage.removeItem('access_token');
              sessionStorage.removeItem('expires_at');
              sessionStorage.removeItem('user_rol');
              sessionStorage.removeItem('user_id');
              sessionStorage.removeItem('token_type');
              this.msgErr('ERROR: '+err);
            }); // if the request fails, remove any possible user token if possible
          },
          registerUser() {
            API.saveUser(this.editUser)
            .then(resp => {
              sessionStorage.access_token=resp.data.access_token;
              sessionStorage.expires_at=resp.data.expires_at;
              sessionStorage.user_rol=resp.data.rol;
              sessionStorage.user_id=resp.data.id;
              sessionStorage.token_type=resp.data.token_type;
              this.$router.push('/home');
            }) // store the token in localstorage
            .catch(err => {
              sessionStorage.removeItem('access_token');
              sessionStorage.removeItem('expires_at');
              sessionStorage.removeItem('user_rol');
              sessionStorage.removeItem('user_id');
              sessionStorage.removeItem('token_type');
              this.msgErr('ERROR: '+err);
            }); // if the request fails, remove any possible user token if possible
          },
      }    
}
</script>
