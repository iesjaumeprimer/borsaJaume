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
            console.error('login')
            API.getUser(this.item)
            .then(resp => {
              if (resp.data.access_token) {
                sessionStorage.access_token=resp.data.access_token;
                sessionStorage.expires_at=resp.data.expires_at;
                sessionStorage.user_rol=resp.data.rol;
                sessionStorage.user_id=resp.data.id;
                sessionStorage.token_type=resp.data.token_type;
                this.$emit('setRol', {
                  rol: Number(resp.data.rol),
                  name: resp.data.name
                });
                this.$router.push('/ofertas');
              } else {
                this.msgErr('ERROR, no s\'ha pogut loguejar: '+resp.data);
              }
            }) // store the token in localstorage
            .catch(err => {
              if (err.response && err.response.status==401) {
                this.msgErr('Error 401: El email o la contraseña no son correctos');
              } else {
                this.msgErr(err);
              }
            }); // if the request fails, remove any possible user token if possible
          },
          registerUser() {
            this.$router.push('/register');
          },
      }    
}
</script>
