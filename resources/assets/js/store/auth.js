export default {
	state: {
		api_token: null,
		user_id: null,
		user_name: null
	},
	initialize() {
		this.state.api_token = localStorage.getItem('api_token')
		this.state.user_id = parseInt(localStorage.getItem('user_id'))
		this.state.user_name = localStorage.getItem('user_name')
	},
	set(api_token, user_id, user_name) {
		localStorage.setItem('api_token', api_token)
		localStorage.setItem('user_id', user_id)
		localStorage.setItem('user_name', user_name)
		this.initialize()
	},
	remove() {
		localStorage.removeItem('api_token')
		localStorage.removeItem('user_id')
		localStorage.removeItem('user_name')
		this.initialize()
	}
}
