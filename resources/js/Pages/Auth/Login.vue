<template>
    <div class="login-box">
        <Head title="Inertia | Login" />
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Admin</b>LTE</a>
            </div>
            <div class="card-body">
                <div v-if="$page.props.flash.error">
                    <input type="hidden" name="message-error" id="message-error" :value="$page.props.flash.error">
                </div>
                <p class="login-box-msg">Sign in to start your session</p>
                <form @submit.prevent="login" method="POST" action="">
                    <div class="input-group mb-3">
                        <input v-model="form.email" type="text" id="email" name="email" class="form-control" :class="{ 'is-invalid':errors.email}" placeholder="Email"/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <span v-if="errors.email" class="invalid-feedback" role="alert">
                            <strong>{{ errors.email }}</strong>
                        </span>
                    </div>
                    <div class="input-group mb-3">
                        <input v-model="form.password" type="password" id="password" name="password" class="form-control" :class="{ 'is-invalid':errors.password}" placeholder="Password"/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <span v-if="errors.password" class="invalid-feedback" role="alert">
                            <strong>{{ errors.password }}</strong>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember"/>
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
                <div class="social-auth-links text-center mt-2 mb-3">
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div>

                <p class="mb-1">
                    <a href="/forgot">
                        I forgot my password
                    </a>
                </p>
                <p class="mb-0">
                    <a href="/register" class="text-center">
                        Register a new membership
                    </a>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import { Head } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            Head
        },

        props: {
            errors: Object
        },

        data() {
            return {
                form: {
                    email: '',
                    password: ''
                }
            }
        },

        created() {
            document.body.classList.remove('sidebar-mini')
            document.body.classList.remove('layout-fixed')

            document.body.classList.add('hold-transition')
            document.body.classList.add('login-page')
        },

        methods: {
            login() {
                this.$inertia.post('/login', this.form)
                this.cekError()
            },

            cekError() {
                setTimeout(() => {
                    if ($('#message-error').val()) {
                        Swal.fire(
                            'Error',
                            `${$('#message-error').val()}`,
                            'error'
                        )
                        this.form.email = ''
                        this.form.password = ''
                    }
                }, 1000)
            }
        }
    }
</script>
