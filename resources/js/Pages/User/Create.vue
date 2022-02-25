<template>
    <Layout>
        <Head title="Inertia | User" />
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Users</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <Link href="/users">Users</Link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Add
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="addUser" action="#" method="POST" encType="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <input v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid':errors.name}" placeholder="Name"/>
                                            <span v-if="errors.name" class="invalid-feedback" role="alert">
                                                <strong>{{ errors.name }}</strong>
                                            </span>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <input v-model="form.email" type="text" name="email" class="form-control" :class="{ 'is-invalid':errors.email}" placeholder="Email"/>
                                            <span v-if="errors.email" class="invalid-feedback" role="alert">
                                                <strong>{{ errors.email }}</strong>
                                            </span>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <input v-model="form.phone" type="text" name="phone" class="form-control" :class="{ 'is-invalid':errors.phone}" placeholder="Phone"/>
                                            <span v-if="errors.phone" class="invalid-feedback" role="alert">
                                                <strong>{{ errors.phone }}</strong>
                                            </span>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <textarea v-model="form.address" name="address" class="form-control" :class="{ 'is-invalid':errors.address}" cols="30" rows="10"></textarea>
                                            <span v-if="errors.address" class="invalid-feedback" role="alert">
                                                <strong>{{ errors.address }}</strong>
                                            </span>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <div class="custom-file">
                                                <input @input="form.photo = $event.target.files[0]" name="photo" type="file" class="form-control" :class="{ 'is-invalid':errors.photo}" id="photo"/>
                                                <label class="custom-file-label" for="photo">Choose photo...</label>
                                                <span v-if="errors.photo" class="invalid-feedback" role="alert">
                                                    <strong>{{ errors.photo }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <input v-model="form.password" type="password" name="password" class="form-control" :class="{ 'is-invalid':errors.password}" placeholder="Password"/>
                                            <span v-if="errors.password" class="invalid-feedback" role="alert">
                                                <strong>{{ errors.password }}</strong>
                                            </span>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <input v-model="form.password_confirmation" type="password" name="password_confirmation" class="form-control" :class="{ 'is-invalid':errors.password_confirmation}" placeholder="Retype Password"/>
                                            <span v-if="errors.password_confirmation" class="invalid-feedback" role="alert">
                                                <strong>{{ errors.password_confirmation }}</strong>
                                            </span>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <select v-model="form.role" name="role" class="form-control" :class="{ 'is-invalid':errors.role}">
                                                <option value="" disabled>Role</option>
                                                <option v-for="role in roles" :key="role.id" :value="role.id">
                                                    {{ role.name }}
                                                </option>
                                            </select>
                                            <span v-if="errors.role" class="invalid-feedback" role="alert">
                                                <strong>{{ errors.role }}</strong>
                                            </span>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <select v-model="form.status" name="status" class="form-control" :class="{ 'is-invalid':errors.status}">
                                                <option value="" disabled>Status</option>
                                                <option value="1">Created</option>
                                                <option value="2">Active</option>
                                            </select>
                                            <span v-if="errors.status" class="invalid-feedback" role="alert">
                                                <strong>{{ errors.status }}</strong>
                                            </span>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </Layout>
</template>

<script>
    import Layout from '../../Layouts/Dasboard.vue'
    import { Head } from '@inertiajs/inertia-vue3'
    import { Link } from '@inertiajs/inertia-vue3'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            Layout,
            Head,
            Link
        },

        props: {
            roles: Array,
            errors: Object
        },

        data() {
            return {
                form: useForm({
                    name: '',
                    email: '',
                    phone: '',
                    address: '',
                    photo: '',
                    password: '',
                    password_confirmation: '',
                    role: '',
                    status: ''
                })
            }
        },

        methods: {
            addUser() {
                this.$inertia.post('/users', this.form)
            }
        }
    }
</script>



