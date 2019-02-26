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
import AlumnosOferta from './views/AlumnosOferta'
//import OfertasArxiu from './views/OfertasArxiu'
import AppLogout from './views/AppLogout'
import AppLogin from './views/AppLogin'

Vue.use(Router)

const USERAUTH = true // sessionStorage.getItem('user-data');
const ifNotAuthenticated = (to, from, next) => {
  if (!USERAUTH) {
    next()
    return
  }
  next('/home')
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
      path: '/login',
      name: 'login',
      component: AppLogin,
      beforeEnter: ifNotAuthenticated,
    },
    {
      path: '/home',
      name: 'home',
      component: Home
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
      component: Register
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
    }
  ]
})
