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
                v-model="item.username" 
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
                v-model="password2" 
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
        password2: '',
    }),
    mounted() {
      this.$emit('setTitle', 'Registre de nou usuari')
    },
    methods: {
        checkPassword() {
            if (this.password2 !== this.item.password) {
                alert('Les contrasenyes no coincideixen');
                this.password2='';
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
            API.saveUser('users' ,{
                username: this.item.username,
                password: this.item.password,
                email: this.item.email,
                rol: this.item.rol
            })
            .then(resp => {
                let table=(rol==5?'empresas':'alumnos');
                this.item.id=resp.data.id;
                let msg=`El teu usuari s'ha creat correctament.
                  Ara has d'omplir les teues dades com `;
                msg+=(rol==5
                    ?'empresa':'ex-alumne');
                alert(msg);
                this.$router.push({ path: '/about'})
                // API.saveItem(table, this.item)
                // .then(resp=>{
                //     let msg='El teu usuari s\'ha creat correctament. ';
                //     msg+=(rol==5
                //         ?'Ja pots crear ofertes de treball des del menú.'
                //         :'Ara edita el teu perfil per a afegir els cicles que has fet en nosaltres');
                //     alert(msg);
                //     this.$router.push({ path: '/about'})
                // })
                // .catch(err => this.msgErr(err));
            })
            .catch(err => this.msgErr(err));
        }
    },
}
</script>
