<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" @submit.prevent="register">

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control"  v-model="form.name">
                                <small class="error__control" v-if="error.name">{{error.name[0]}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Email Address</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control"  v-model="form.email">
                                <small class="error__control" v-if="error.email">{{error.email[0]}}</small>
                            </div>
                        </div>

                       

                        <div class="form-group">
                            <label for="license_key" class="col-md-4 control-label">License key</label>
                            <div class="col-md-6">
                                <input type="license_key" class="form-control" v-model="form.license_key">
                                <small class="error__control" v-if="error.license_key">{{error.license_key[0]}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control"  v-model="form.password">
                                <small class="error__control" v-if="error.password">{{error.password[0]}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control"  v-model="form.password_confirmation">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button :disabled="isProcessing" class="btn btn-primary">Register</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Flash from '../../helpers/flash'
    import { post } from '../../helpers/api'
    export default {
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    license_key: ''
                },
                error: {},
                isProcessing: false
            }
        },
        methods: {
            register() {
                this.isProcessing = true
                this.error = {}
                post(this.$router.options.base+'api/register', this.form)
                    .then((res) => {
                        if(res.data.registered) {
                            Flash.setSuccess('Congratulations! You have now successfully registered.')
                            this.$router.push('/login')
                        }
                        this.isProcessing = false
                    })
                    .catch((err) => {
                        if(err.response.status === 422) {
                            this.error = err.response.data
                        }
                        this.isProcessing = false
                    })
            }
        }
    }
</script>
