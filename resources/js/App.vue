<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
    >
      <v-list dense  v-if="menu && menu.length">
        <menu-item link
          v-for="item in menu"
          :key="item.id"
          :icon="item.icon"
          :title="item.text"
          @click="go(item.path)"
        ></menu-item>
      </v-list>
        <span v-else>Has de <a href="/login">loguejar-te</a> per a accedir al menú</span>
    </v-navigation-drawer>

    <v-app-bar
      app
      color="indigo"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title class="ml-0 pl-3">
        <h2>{{ title }}</h2>
      </v-toolbar-title>
            <v-spacer></v-spacer>
      <v-toolbar-title>CIP FP Batoi - Borsa de Treball</v-toolbar-title>

    </v-app-bar>

    <v-content>
      <v-container
        class="fill-height"
        fluid
      >
        <v-row
          align="center"
          justify="center"
        >
        <v-col cols="12" class="text-center">
          <router-view 
            @setTitle="setTitle"
            @setRol="setRol">
          </router-view>
        </v-col>
                  </v-row>
      </v-container>
    </v-content>
    <v-footer
      color="indigo"
      app
    >
      <span class="white--text">&#x1f12f; 2020 - <a  class="white--text" href="http://cipfpbatoi.es" target="_blank">CIP FP Batoi</a></span>
      <v-spacer></v-spacer>
      <span class="white--text"><h2>{{ myName?'Hola '+myName:'' }}</h2></span>
    </v-footer>
  </v-app>
  </template>

<script>
  import MenuItem from './components/base/MenuItem';

  export default {
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
      title: 'Borsa de treball',
      myName: '',
    }),
    components: {
      MenuItem,
    },
    created() {
//      this.$store.dispatch('loadMenu');
    },
    computed: {
      menu() {
        return this.$store.menu;
      }
    },
    methods: {
      go(path) {
          this.$router.push(path?path:'/');
      },
      setTitle(title) {
        this.title=title;
      },
      setRol(datos) {
        let rolDescrip='';
        this.myRol=datos?datos.rol:9999;
        switch (this.myRol) {
          case 2: 
            rolDescrip='Administrador';
            break;
          case 3: 
            rolDescrip='Responsable';
            break;
          case 5: 
            rolDescrip='Empresa';
            break;
          case 7: 
            rolDescrip='Alumne';
            break;
        }
        this.myName=datos?rolDescrip+': '+datos.name:'';
      }
    }
  }
</script>
