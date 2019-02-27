<template>
    <div>
<h1>resigtro</h1>
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
    methods: {
        checkPassword() {
            if (this.password2 !== this.item.password) {
                alert('Les contrasenyes no coincideixen');
                this.password2='';
            }
        },
        checkUser() {
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
            API.saveItem('users' ,{
                username: this.item.username,
                password: this.item.password,
                rol: this.item.rol
            })
            .then(resp => {
                let table=(rol==5?'empresas':'alumnos');
                this.item.id=resp.data.id;
                API.saveItem(table, this.item)
                .then(resp=>{
                    let msg='El teu usuari s\'ha creat correctament. ';
                    msg+=(rol==5
                        ?'Ja pots crear ofertes de treball des del menú.'
                        :'Ara edita el teu perfil per a afegir els cicles que has fet en nosaltres');
                    alert(msg);
                    this.$router.push({ path: '/about'})
                })
                .catch(err => this.msgErr(err));
            })
            .catch(err => this.msgErr(err));
        }
    },
}
</script>
