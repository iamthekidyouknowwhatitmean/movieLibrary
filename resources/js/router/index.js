import Home from '@/pages/Home.vue';
import FilmDetails from '@/pages/FilmDetails.vue';
import { createRouter,createWebHistory } from 'vue-router';

const routes = [
    {path:'/',name:"Home",component:Home},
    {path:'/details',name:"FilmDetails",component:FilmDetails}
]
const router = createRouter({
    history:createWebHistory(),
    routes
})

export default router
