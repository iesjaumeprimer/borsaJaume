<template>
        <div>
            <h1>Inicia sessió</h1>
        <div v-for="(error,i) in errors" :key="i">
            <v-alert v-model="error.show" :type="error.type" dismissible>
                {{ error.msg }}
            </v-alert>
        </div>
  <v-form @submit.prevent="submit" ref="form" v-model="valid" lazy-validation>
            <v-text-field
                autofocus
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
    <v-btn type="submit" :disabled="!valid">Login</v-btn>
    <v-btn @click.stop="registerUser">Registrar-se</v-btn>
  </v-form>

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
              // sessionStorage.removeItem('access_token');
              // sessionStorage.removeItem('expires_at');
              // sessionStorage.removeItem('user_rol');
              // sessionStorage.removeItem('user_id');
              // sessionStorage.removeItem('token_type');
              let msg='';
              console.log(err)
              switch (err.response.status) {
                case 401:
                  msg='El email o la contraseña no son correctos'
                  break;
                default:
                  msg='ERROR: '+err;
              }
              this.msgErr(msg);
            }); // if the request fails, remove any possible user token if possible
          },
          registerUser() {
            this.$router.push('/register');
          },
      }    
}
</script>
