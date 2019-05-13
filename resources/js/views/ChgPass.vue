<template>
  <div>
    <div v-for="(error,i) in errors" :key="i">
      <v-alert v-model="error.show" :type="error.type" dismissible>{{ error.msg }}</v-alert>
    </div>
    <v-form v-model="valid">
      <v-text-field label="Contrasenya" v-model="user.password" required></v-text-field>

      <v-text-field
        label="Confirma contrasenya"
        v-model="user.password_confirmation"
        :error-messages="emailMatchError()"
        required
      ></v-text-field>

      <v-btn :disabled="!valid" color="primary" @click="chgPass">Canviar</v-btn>
      <v-btn>Reset</v-btn>
    </v-form>
  </div>
</template>

<script>
import API from "../lib/API";
import utilsMixin from "../mixins/utils.js";

export default {
  mixins: [utilsMixin],
  data: () => ({
    password: "",
    password_confirmation: "",
    valid: false,
    user: {}
  }),
  created() {
    this.findToken();
  },
  methods: {
    emailMatchError() {
      return this.password === this.password_confirmation
        ? ""
        : "Email must match";
    },
    findToken() {
      API.findToken(this.$route.params.token)
        .then(resp => {
          (this.user.email = resp.data.email),
            (this.user.token = resp.data.token);
        })
        .catch(err => this.msgErr(err));
    },
    chgPass() {
      console.error("kk");
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
