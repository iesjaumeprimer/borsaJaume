<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      fixed
      app
    >
    <!-- Menú items-->
      <v-list dense>
        <menu-item
          v-for="item in items"
          :key="item.id"
          :icon="item.icon"
          :title="item.text"
          @click="go(item.path)">
        </menu-item>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar color="indigo" dark fixed app>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-toolbar-title>CIP FP Batoi - Borsa de Treball</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-title class="ml-0 pl-3">
        <h2>{{ title }}</h2>
      </v-toolbar-title>
    </v-toolbar>

    <!-- Contenido principal -->
    <v-content>
      <v-container fluid fill-height>
        <v-layout
          justify-center
          align-center
        >
          <router-view @setTitle="setTitle"></router-view>

        </v-layout>
      </v-container>
    </v-content>

    <v-footer color="indigo" app>
      <span class="white--text">&copy; CIP FP Batoi 2018</span>
    </v-footer>
  </v-app>
</template>

<script>
  import API from './lib/API';
  import MenuItem from './components/base/MenuItem';

  export default {
    data: () => ({
      drawer: null,
      items: [],
      title: 'Borsa de treball',
    }),
    props: {
      source: String
    },
    components: {
      MenuItem,
    },
    mounted() {
      this.loadData();
    },
    methods: {
      loadData() {
        API.getTable("menu")
          .then(resp => {
              let menu = resp.data.filter(item=>item.active);
              // Si tiene subitems sustituimos su código por el item entero 
              menu.filter(item=>item.children).map(item=>{
                  item.children=JSON.parse(item.children);
                  item.children=item.children.map(subitem=>resp.data.find(elem=>elem.id==subitem));
                  return item;
              })
              this.items = menu;
          })
          .catch(err=>console.error(err.data?err.data.message:err.message));
      },
      go(path) {
          this.$router.push(path?path:'/');
      },
      setTitle(title) {
        this.title=title;
      }
    }
  }
</script>
