<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>

                <div class="panel-body">
                    <form class="form-horizontal" @submit.prevent="update">

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
                                <input id="email" type="email" class="form-control"  v-model="form.email" readonly>
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
                                <input id="password" type="password" class="form-control"  v-model="form.password" placeholder="Leave empty to keep current password.">
                                <small class="error__control" v-if="error.password">{{error.password[0]}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control"  v-model="form.password_confirmation" placeholder="Leave empty to keep current password.">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button :disabled="isProcessing" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue'
    import Flash from '../helpers/flash'
    import Auth from '../store/auth'
    import { get, post } from '../helpers/api'
    import { scrollToTop } from '../helpers/helper'

    export default {
        data() {
            return {
                isProcessing: false,
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    license_key: ''
                },
                error: {},
                isProcessing: false,
                initializeURL: this.$router.options.base+`api/profile?api_token=${Auth.state.api_token}`
            }
        },
        created() {
            get(this.initializeURL).then((res) => {
                Vue.set(this.$data, 'form', res.data.form);
            });
        },
        methods: {
            update() {
                post(this.initializeURL, this.form)
                    .then((res) => {
                        if(res.data.success) {
                            Flash.setSuccess(res.data.message)
                            localStorage.setItem('user_name', this.form.name)
                            this.$emit('profile-updated', this.form.name);
                            this.error = {};
                            scrollToTop();
                        }
                        this.isProcessing = false
                    })
                    .catch((err) => {
                        if(err.response.status === 422) {
                            this.error = err.response.data.errors
                            Flash.setError(err.response.data.message)
                            scrollToTop();
                        }
                        this.isProcessing = false
                    });
            }
        }
    }
</script>