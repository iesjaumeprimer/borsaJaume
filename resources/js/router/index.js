import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import About from '../views/About.vue'
import Alumnos from '../views/Alumnos'
import Perfil from '../views/AppPerfil'
import ChgPass from '../views/ChgPass'
import Register from '../views/Register'
import Ciclos from '../views/Ciclos'
import Responsables from '../views/Responsables'
import Menu from '../views/Menu'
//import MenuEdit from '../views/MenuComponent/Edit'
import Empresas from '../views/Empresas'
import Ofertas from '../views/Ofertas'
import OfertasxAlumno from '../views/OfertasxAlumno'
//import OfertasArxiu from '../views/OfertasArxiu'
import AppLogout from '../views/AppLogout'
import AppLogin from '../views/AppLogin'
import AppLegal from '../views/AppLegal'
import PageNotFound from '../views/page404'
//import store from '@/store'


Vue.use(VueRouter)

const USERAUTH = localStorage.getItem('access_token');
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

const routes = [
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
      path: '/alumnos/:id',
      name: 'alumno',
      component: Alumnos,
      props: true,
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
      path: '/empresas/:id',
      name: 'empresa',
      component: Empresas,
      props: true,
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
      component: Ofertas,
      beforeEnter: ifAuthenticated,
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
    {
      path: '/privacitat',
      name: 'privacitat',
      component: AppLegal,
    },
    {
      path: '/logout',
      name: 'logout',
      component: AppLogout,
      beforeEnter: ifAuthenticated,
    },
    {
      path: '*',
      component: PageNotFound,
    },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
