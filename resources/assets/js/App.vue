<template>
	<div>
		<nprogress-container></nprogress-container>

		<nav class="navbar navbar-default navbar-static-top">
	        <div class="container">
	            <div class="navbar-header">

	                <!-- Collapsed Hamburger -->
	                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
	                    <span class="sr-only">Toggle Navigation</span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </button>

	                <!-- Branding Image -->
	                <div class="navbar-brand">
	                    <router-link to="/">Video Intro</router-link>
	                </div>
	            </div>

	            <div class="collapse navbar-collapse" id="app-navbar-collapse">
	                <!-- Left Side Of Navbar -->
	                <ul class="nav navbar-nav">
	                    &nbsp;
	                </ul>

	                <!-- Right Side Of Navbar -->
	                <ul class="nav navbar-nav navbar-right">
	                    <li v-if="guest">
	                        <router-link to="/login">Login</router-link>
	                    </li>
	                    <li v-if="guest">
	                        <router-link to="/register">Register</router-link>
	                    </li>
	                    
	                    <li class="navbar__item"  v-if="auth">
	                        <router-link to="/video-intros/create">Add new Intro</router-link>
	                    </li>

	                    <li class="dropdown" v-if="auth">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
	                            {{loggedUserName}} <span class="caret"></span>
	                        </a>

	                        <ul class="dropdown-menu" role="menu">
	                            <li>
	                                <a @click.stop="logout">Logout</a>
	                            </li>
	                        </ul>
	                    </li>
	                </ul>
	            </div>
	        </div>
	    </nav>
	    
		<div class="container">
			<div class="flash flash__error" v-if="flash.error">
				{{flash.error}}
			</div>
			<div class="flash flash__success" v-if="flash.success">
				{{flash.success}}
			</div>
			<router-view></router-view>
		</div>
	</div>
</template>

<script type="text/javascript">
	import Auth from './store/auth'
	import Flash from './helpers/flash'
	import { post, interceptors } from './helpers/api'
	import NProgress from 'vue-nprogress';
	import NprogressContainer from 'vue-nprogress/src/NprogressContainer'

    const nprogress = new NProgress()

	export default {
		nprogress,
		created() {
			console.log("base_url: "+window.base_url);
			// global error http handler
			interceptors((err) => {
				nprogress.done();
				if(err.response.status === 401) {
					Auth.remove()
					this.$router.push(this.$router.options.base+'login')
				}

				if(err.response.status === 500) {
					Flash.setError(err.response.statusText)
				}

				if(err.response.status === 404) {
					this.$router.push(this.$router.options.base+'not-found')
				}
			});

			axios.interceptors.request.use(function (config) {
	            nprogress.start();
	            return config;
	        }, function (error) {
	            return Promise.reject(error);
	        });
	        
	        axios.interceptors.response.use(function (response) {
	            nprogress.done();
	            return response;
	        }, function (error) {
	            return Promise.reject(error);
	        });

			Auth.initialize();
			// this.loggedUserName = Auth.state.user_name;
		},
		data() {
			return {
				authState: Auth.state,
				flash: Flash.state,
				loggedUserName: ''
			}
		},
		computed: {
			auth() {
				if(this.authState.api_token) {
					this.loggedUserName = this.authState.user_name
					return true
				}
				return false
			},
			guest() {
				return !this.auth
			}
		},
		methods: {
			logout() {
				post(this.$router.options.base+'api/logout')
				    .then((res) => {
				        if(res.data.done) {
				            // remove token
				            Auth.remove()
				            Flash.setSuccess('You have successfully logged out.')
				            this.$router.push('/login')
				        }
				    })
			}
		},
		components: {
			NprogressContainer
		}
	}
</script>

