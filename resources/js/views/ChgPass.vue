<template>
  <div>
    <div v-for="(error,i) in errors" :key="i">
      <v-alert v-model="error.show" :type="error.type" dismissible>{{ error.msg }}</v-alert>
    </div>
              <v-card>
  <v-form @submit.prevent="submit" ref="form" v-model="valid" lazy-validation>
            <v-card-title class="grey lighten-4 py-4 title">
              Canviar contrasenya
            </v-card-title>
            <v-card-text>
            <v-text-field
                autofocus
                v-model="user.password" 
                label="Nova contrasenya" 
                title="Nova contrasenya" 
                  :append-icon="show ? 'visibility' : 'visibility_off'"
                  :type="show ? 'text' : 'password'"
                  @click:append="show = !show"
                  hint="Al menys 6 caràcters"
                  min="6"
                  max="25"
                  counter="25"
                  :rules="required25Rules"
                required
            >
            </v-text-field>
            <v-text-field
                v-model="user.password_confirmation" 
                label="Confirma la contrasenya" 
                title="Confirma la contrasenya" 
                  :append-icon="show ? 'visibility' : 'visibility_off'"
                  :type="show ? 'text' : 'password'"
                  @click:append="show = !show"
                  hint="Al menys 6 caràcters"
                  @change="checkPassword"
                required
            >
            </v-text-field>
            </v-card-text>
            <v-card-actions>
    <help-button v-if="helpPage" :page="helpPage"></help-button>
    <v-spacer></v-spacer>
    <v-btn color="primary" type="submit" :disabled="!valid || !user.token">Canviar</v-btn>
    <v-btn type="reset">Reset</v-btn>

            </v-card-actions>
  </v-form>
              </v-card>
  </div>
</template>

<script>
import API from "../lib/API";
import utilsMixin from "../mixins/utils.js";

export default {
  mixins: [utilsMixin],
  data: () => ({
    show: false,
    helpPage: '',
    valid: false,
    user: {}
  }),
  created() {
    this.findToken();
  },
  methods: {
        checkPassword() {
            if (this.emailMatchError()) {
                alert(this.emailMatchError());
            }
        },
    emailMatchError() {
      return (this.user.password && this.user.password === this.user.password_confirmation)
        ? ""
        : "Les contrasenyes no coincideixen";
    },
    findToken() {
      API.findToken(this.$route.params.token)
        .then(resp => {
          (this.user.email = resp.data.email),
            (this.user.token = resp.data.token);
        })
        .catch(err => this.msgErr(err));
    },
    submit() {
      API.sendPassword(this.user)
        .then(resp =>
          this.msgOk(
            "chgpwd",
            "T'hem enviat un mail confirmant-te el canvi de la teua contrasenya"
          )
        )
        .catch(err => this.msgErr(err));
    }
  }
};
</script>
