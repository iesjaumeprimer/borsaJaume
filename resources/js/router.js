import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import About from './views/About.vue'
import Alumnos from './views/Alumnos'
import Perfil from './views/Perfil'
import Register from './views/Register'
import Ciclos from './views/Ciclos'
import Menu from './views/Menu'
//import MenuEdit from './views/MenuComponent/Edit'
import Empresas from './views/Empresas'
import Ofertas from './views/Ofertas'
import OfertasxAlumno from './views/OfertasxAlumno'
import AlumnosOferta from './views/AlumnosOferta'
//import OfertasArxiu from './views/OfertasArxiu'
import AppLogout from './views/AppLogout'
import AppLogin from './views/AppLogin'
import PageNotFound from './views/page404'
// Passport ???
import Pass1 from './components/passport/AuthorizedClients'
import Pass2 from './components/passport/Clients'
import Pass3 from './components/passport/PersonalAccessTokens'


Vue.use(Router)

const USERAUTH = sessionStorage.getItem('access_token');
const user_rol = sessionStorage.user_rol;
const ifNotAuthenticated = (to, from, next) => {
  if (!USERAUTH) {
    next()
    return
  }
  alert('Debes desloguearte primero');
  next('/')
}
const ifAuthenticated = (to, from, next) => {
  if (USERAUTH) {
    next()
    return
  }
  next('/login')
}

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/login',
      name: 'login',
      component: AppLogin,
      beforeEnter: ifNotAuthenticated,
    },
    {
      path: '/about',
      name: 'about',
      component: About
    },
    {
      path: '/alumnos',
      name: 'alumnos',
      component: Alumnos,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/perfil',
      name: 'perfil',
      component: Perfil,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
      beforeEnter: ifNotAuthenticated,
    },
    {
      path: '/ciclos',
      name: 'ciclos',
      component: Ciclos,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/empresas',
      name: 'empresas',
      component: Empresas,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/ofertas',
      name: 'ofertas',
      component: (user_rol==7?OfertasxAlumno:Ofertas),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/alumnos-oferta',
      name: 'alumnos-oferta',
      component: AlumnosOferta,
      beforeEnter: ifAuthenticated,
    },
    // {
    //   path: '/ofertas-arxiu',
    //   name: 'ofertas-arxiu',
    //   component: OfertasArxiu
    // },
    {
      path: '/menu',
      name: 'menu',
      component: Menu,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/pass1',
      name: 'pass1',
      component: Pass1,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/pass2',
      name: 'pass2',
      component: Pass2,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/pass3',
      name: 'pass3',
      component: Pass3,
      beforeEnter: ifAuthenticated,
    },
    // {
    //   path: '/menu-edit/:id',
    //   name: 'menu-edit',
    //   component: MenuEdit,
    //   props: true
    // },
    {
      path: '/logout',
      name: 'logout',
      component: AppLogout,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '*',
      component: PageNotFound,
    }
  ]
})
