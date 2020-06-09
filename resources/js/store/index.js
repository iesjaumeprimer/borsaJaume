import Vue from 'vue'
import Vuex from 'vuex'
import API from '../lib/API';
//import { resolve } from 'dns';

Vue.use(Vuex);

const TABLES = ['menu', 'alumnos', 'ciclos', 'empresas', 'ofertas'];//, 'ofertas-arxiu'];
export default new Vuex.Store({
  state: {
    // auth: {
    //   access_token_ok: "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImFiZWQyM2Y3ODA0ODgxY2ZmMGY2NjkzNTMxNWJjZjg3N2JjZGY1ZGI5MDA0N2VmZWU1NjUwMDEwYWU1ODUzYzEzN2M5Mjk2MWQ0NjNkODY2In0.eyJhdWQiOiI2IiwianRpIjoiYWJlZDIzZjc4MDQ4ODFjZmYwZjY2OTM1MzE1YmNmODc3YmNkZjVkYjkwMDQ3ZWZlZTU2NTAwMTBhZTU4NTNjMTM3YzkyOTYxZDQ2M2Q4NjYiLCJpYXQiOjE1ODMzNTY1NjIsIm5iZiI6MTU4MzM1NjU2MiwiZXhwIjoxNjE0ODkyNTYyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.S_uRgomMs0ndsX-mJF1BoUWmOluSLsnOD_Y3pGV_dTjohKF2IbE2aIV2fsa9FHoW2OSGjjdPP4eWMSi7orWEEBxgJG0po-Df-UGzEIv38Gstk0WUiXdC-qlRA6TeefHXDJifz2C94W1ep4LqC3qhp2ma-1Sm-XiLoNV-m4lkL9iHo5uDeKyBTjwUPNuPUTV9Fvf45wJhcTR2avGU79YAneeCMIjECxNGnHYlkWxzG1xDaMrF-nhqVJJXX2cg9BziIGT7MkA_QEDlK8ySULjxdPUyKOP2DLntp2YM0GGwuj0X_PGQ5qq47RuZ672ZlJBdQ1fo5fDPigx8-WC0513hGNtTCV8ciwXtv7IH4Yh_iJ3ZgE4vS-6YE7NQrpX6rk5J8hsEWukq-lm3LKIipobgLuDWeYXLufu62XNXojl0Cy911ijRuZCTTRqxLqiE8b1DBIRdgUDFx8RXEecqdnVZ98X55wynoN_YbRWZmqBz6QKGy3tzA7EE1AHzF3IBIjOhxATge2Tf5Bmkpo-0ve9H72oJLOHEMdIuyRZRoXK2iNkr-kAjRjnyOXJFBXWJzNbI7OFxY4T_r3O6c-DBuuKsLBzQplVbZ9cpqr26UGwpuecGiIv1TAdNB4uA_1pYrL803l0kXgesnnU-UXc9Pi4s27IorXF899mFUJAR4IvKAUE",
    //   access_token_my: "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImM1NTE5MTAyZWEwNDk4Nzk3NDdjY2JhMDcyNDRjNzM0MjRhODIwODEwMTMzODdjZTUzOTY5NzU3NzhiOTJjYzJhNTNiZDlmNDljYzExY2E1In0.eyJhdWQiOiIxIiwianRpIjoiYzU1MTkxMDJlYTA0OTg3OTc0N2NjYmEwNzI0NGM3MzQyNGE4MjA4MTAxMzM4N2NlNTM5Njk3NTc3OGI5MmNjMmE1M2JkOWY0OWNjMTFjYTUiLCJpYXQiOjE1ODM5Mzg2NjIsIm5iZiI6MTU4MzkzODY2MiwiZXhwIjoxNjE1NDc0NjYyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.qd4U9Qs2VL6Cf9oMquJTIVG81fCfyqets4UgUFRWYBZOIb36gVwT7-gZTD0uhVCiYwneper74VYBeOe-OvVC-Tkuuk2BbDCBGyzZlsn8vHOGAJTwrPiw6QTsgqYaRG0fkmTFA7XcEqhXwPGt-DkB4uT5lmZJBsTZ4U8Zqg4c8Sf8U_8Lr0PRBS3l1ARTRBc948KkK9WeZ60UbOc2ltKQwlRWMQmM3xY8QHg36mBDprr9lpAvGa0iIJ3WIet7MssUxVUjNUCb8Rn8kMMe__DLi1P1wh_n3OASSc_WZnqSjrQ_xtyBykS5l6VBT6Bo1PVc6TEWbaDWgGRTTrM9KJ0RXZJza27LkNACZbXuLdwzq-yOvTP226nELst3rHBqbS4f2_VnjiYKH2s4D3VbAs6j2JePfiokOmbUe8okomhZ6UCgVQ_2P019zOoYzPojxtLzEG6uFLAyyfTHEZdS0TmExpDb4EA-EtFC278b3J6RwODk49LQoCEcGT7Lvwfn-uKTcU9MoAbsNz5D2Rhm4JCnzCCsG7PzZTdT1_Oq0THl8vXRkXT6SF2JfXqtrsJoqnoK0lDLV2ijGZnM-EufoXKN7C1CyDsREk1ZhDTMkW4R_dTb8yOkfJJDpP-UP0SXo63FEI-7y3cvgErLYZ1PF07bRGQJnhdTum_M11AdFAf8ABE",
    //   access_token: "",
    //   expires_at: "",
    //   token_type: "",
    //   user_id: "",
    //   user_rol: ""
    // },
    menu: [],
    dataLoaded: false,
    alumnos: [],
    ciclos: [],
    empresas: [],
    ofertas: [],
    'ofertas-arxiu': [],
  },
  getters: {
    getMenu: (state) => {
      return localStorage.user_rol
        ? state.menu.filter(item => !(item.rol % localStorage.user_rol))
        : state.menu.filter(item => item.rol == 9999);
    },
    getOfertas: (state) => (archivadas) => {
      return archivadas ? state['ofertas-arxiu'] : state.ofertas;
    },
    getAlumnos: (state) => (id) => {
      if (id) {
        if (Array.isArray(id) ) {
          return state.alumnos.filter(item => id.includes(item.id));
        }
        return state.alumnos.filter(item => item.id == id);
      }
      return state.alumnos;
    },
    getEmpresaById: (state) => (id) => {
      return (id && state.empresas.length)
        ? state.empresas.find(empresa => empresa.id == id)
        :{};
    },
    getCicloById: (state) => (id) => {
      return (id && state.ciclos.length)
        ? state.ciclos.find(ciclo => ciclo.id == id)
        :{};
    }
  },
  mutations: {
    setMenu(state, menu) {
      state.menu = menu;
    },
    setTabla(state, data) {
      state[data.tabla] = data.items;
      state.dataLoaded = true;
    },
    setAuth(state, data) {
      localStorage.access_token = data.access_token;
      localStorage.expires_at = data.expires_at;
      localStorage.user_rol = data.rol;
      localStorage.user_id = data.id;
      localStorage.token_type = data.token_type;
    },
    clearAuth(state) {
      for (let data of ['access_token', 'expires_at', 'user_rol', 'user_id', 'token_type']) {
        localStorage.removeItem(data);
      }
      state.dataLoaded = false;
      for (let tabla of TABLES) {
        state[tabla] = [];
      }
    },
  },
  actions: {
    login(context, user) {
      return new Promise((resolv, reject) => {
        API.loginUser(user)
      .then(resp => {
        if (resp.data.access_token) {
          context.commit('setAuth', resp.data);
          // Y cargamos de nuevo el menú
//          context.dispatch('loadMenu');
          resolv({
            rol: Number(resp.data.rol),
            name: resp.data.name
          });
        } else {
          context.commit('clearAuth');
          // Y cargamos de nuevo el menú
//          context.dispatch('loadMenu');
          reject(`ERROR, no s'ha pogut loguejar: ${resp.data}`);
        }
      }) // store the token in localstorage
      .catch(err => {
        context.commit('clearAuth');
          // Y cargamos de nuevo el menú
//          context.dispatch('loadMenu');
        if (err.response && err.response.status==401) {
          reject('Error 401: El email o la contraseña no son correctos');
        } else {
          reject(err.data?err.data.message:err.message||err);
        }
      }); // if the request fails, remove any possible user token if possible
    });
    },
    logout(context) {
      return new Promise((resolv, reject) => {
        API.logoutUser()
        .then(() => {
          context.commit('clearAuth');
//          context.dispatch('loadMenu');
          resolv(true);
        }).catch(err => {
          if (err.response && err.response.status==401) {
            reject('Error 401: El email o la contraseña no son correctos');
          } else {
            reject(err.data?err.data.message:err.message||err);
          }  
        });
      })
    },
    loadMenu({ commit }) {
      API.getTable('menu')
        .then((resp) => commit('setMenu', resp.data.data))
        .catch(err=>alert(err.data?err.data.message:err.message||err));
    },
    loadData(context) {
      if (!context.state.dataLoaded) {
        for (let tabla of TABLES) {
          API.getTable(tabla)
          .then((resp)=>context.commit('setTabla', { tabla, items: resp.data.data }))
          .catch(err=>alert('Error al carregar la taula '+tabla+': '+err.message||err));
        }
      }
    },
    checkUser(email) {
      return new Promise((resolv, reject) => {
        API.ckeckUsername(email)
        .then(resp => {
            if (resp.data=='ok') {
              resolv(true)
            } else {
                reject('El email '+email+' ja està registrat en la Borsa de treball. Has de triar altre');
            }
        })
        .catch(err => reject(err.message || err));
      })
    }
  },
  modules: {
  }
})
