<template>
        <div>
        <div v-for="(error,i) in errors" :key="i">
            <v-alert v-model="error.show" :type="error.type" dismissible>
                {{ error.msg }}
            </v-alert>
        </div>
              <v-card>
  <v-form @submit.prevent="submit" ref="form" v-model="valid" lazy-validation>
            <v-card-title class="grey lighten-4 py-4 title">
              Canviar perfil
            </v-card-title>
            <v-card-text>
            <v-text-field
                autofocus
                v-model="item.name" 
                label="Usuari" 
                title="Usuari" 
                required
            >
            </v-text-field>
            <v-text-field
                autofocus
                v-model="item.email" 
                label="e-Mail" 
                title="e-Mail" 
                required
                :rules="emailRules"
            >
            </v-text-field>
        <v-btn @click="chgPassword">Canviar la contrasenya</v-btn>
            </v-card-text>
            <v-card-actions>
    <help-button v-if="helpPage" :page="helpPage"></help-button>
    <v-spacer></v-spacer>
    <v-btn color="primary" type="submit" :disabled="!valid">Canviar</v-btn>

            </v-card-actions>
  </v-form>
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
  components: {HelpButton },
      data() { 
          return {
            helpPage: "login",
            item: {
              name: '',
              email: ''
            },
            password2: '',
            show: false,
            }
      },
    mounted() {
      this.$emit('setTitle', 'El meu perfil');
      this.loadData();
    },
      methods: {
        loadData() {
            API.getItem('users', this.myId)
            .then(resp=>{
              this.item.name=resp.data.data.name;
              this.item.email=resp.data.data.email;
            })
            .catch(err=>msgErr(err));
        },
          submit() {
            console.error('login')
                API.updateItem('users', this.myId, this.item)
                .then(resp => {
                    this.msgOk('update');
                })
                .catch(err => this.msgErr(err));
          },
          chgPassword() {
            API.changePassword()
            .then(resp=>console.error(resp))
            .catch(err=>console.error(err))
          },
          registerUser() {
            this.$router.push('/register');
          },
      }    
}
</script>
