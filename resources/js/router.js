import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import About from './views/About.vue'
import Alumnos from './views/Alumnos'
import Perfil from './views/AppPerfil'
import ChgPass from './views/ChgPass'
import Register from './views/Register'
import Ciclos from './views/Ciclos'
import Responsables from './views/Responsables'
import Menu from './views/Menu'
//import MenuEdit from './views/MenuComponent/Edit'
import Empresas from './views/Empresas'
import Ofertas from './views/Ofertas'
import OfertasxAlumno from './views/OfertasxAlumno'
//import OfertasArxiu from './views/OfertasArxiu'
import AppLogout from './views/AppLogout'
import AppLogin from './views/AppLogin'
import PageNotFound from './views/page404'

Vue.use(Router)

const USERAUTH = sessionStorage.getItem('access_token');
var ifNotAuthenticated = (to, from, next) => {
  if (!sessionStorage.getItem('access_token')) {
    next()
    return
  }
  alert('Debes desloguearte primero');
  next('/')
}
var ifAuthenticated = (to, from, next) => {
  if (sessionStorage.getItem('access_token')) {
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
      path: '/users',
      name: 'responsables',
      component: Responsables,
      beforeEnter: ifAuthenticated,
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
      component: Ofertas,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/ofertas-alum',
      name: 'ofertas-alum',
      component: OfertasxAlumno,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/ofertas-arxiu',
      name: 'ofertas-arxiu',
      component: Ofertas
    },
    {
      path: '/menu',
      name: 'menu',
      component: Menu,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/resetPassword/:token',
      name: 'resetPassword',
      component: ChgPass,
//      beforeEnter: ifAuthenticated,
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
