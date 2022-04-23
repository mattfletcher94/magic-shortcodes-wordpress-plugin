import { createRouter, createWebHashHistory } from 'vue-router'
import ViewIndex from '../views/ViewIndex.vue'
import ViewCreateShortcode from '../views/ViewCreateShortcode.vue'

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
      path: '/',
      alias: '/home',
      component: ViewIndex,
    },
    {
      path: '/create',
      component: ViewCreateShortcode,
    },
  ],
})

export default router
