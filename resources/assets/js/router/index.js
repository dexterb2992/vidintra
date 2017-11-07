import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from '../views/Auth/Login.vue'
import Register from '../views/Auth/Register.vue'
import NotFound from '../views/NotFound.vue'
import VideoIntroIndex from '../views/VideoIntro/Index.vue'
import VideoIntroForm from '../views/VideoIntro/Form.vue'

Vue.use(VueRouter)

const router = new VueRouter({
	mode: 'history',
	base: '/',
	routes: [
		{ path: '/video-intros/create', component: VideoIntroForm, meta: { mode: 'create' } },
		{ path: '/video-intros/:id/edit', component: VideoIntroForm, meta: { mode: 'edit' } },
		{ path: '/video-intros/:id' },
		{ path: '/', component: VideoIntroIndex },
		{ path: '/register', component: Register },
		{ path: '/login', component: Login },
		{ path: '/not-found', component: NotFound },
		{ path: '*', component: NotFound },
	]
})

export default router
