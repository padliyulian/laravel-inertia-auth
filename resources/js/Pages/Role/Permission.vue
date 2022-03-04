<template>
    <Layout>
        <Head title="Inertia | Role" />
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Roles</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <Link href="/roles">Roles</Link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Permissions
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <span class="text-capitalize">{{ role.name }}</span> Role
                                </div>
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
                                <form @submit.prevent="updateData" action="#" method="POST" encType="multipart/form-data">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Menu</th>
                                                <th>View</th>
                                                <th>Add</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Users</td>
                                                <td>
                                                    <template v-for="item in permissions">
                                                        <div v-if="item.name === 'view users'" :key="item.id" class="form-check">
                                                            <input name="permissions[]" class="form-check-input" type="checkbox" :value="item.id" v-model="form.permissions">
                                                        </div>
                                                    </template>
                                                </td>
                                                <td>
                                                    <template v-for="item in permissions">
                                                        <div v-if="item.name === 'add users'" :key="item.id" class="form-check">
                                                            <input name="permissions[]" class="form-check-input" type="checkbox" :value="item.id" v-model="form.permissions">
                                                        </div>
                                                    </template>
                                                </td>
                                                <td>
                                                    <template v-for="item in permissions">
                                                        <div v-if="item.name === 'edit users'" :key="item.id" class="form-check">
                                                            <input name="permissions[]" class="form-check-input" type="checkbox" :value="item.id" v-model="form.permissions">
                                                        </div>
                                                    </template>
                                                </td>
                                                <td>
                                                    <template v-for="item in permissions">
                                                        <div v-if="item.name === 'delete users'" :key="item.id" class="form-check">
                                                            <input name="permissions[]" class="form-check-input" type="checkbox" :value="item.id" v-model="form.permissions">
                                                        </div>
                                                    </template>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary">Update</button>
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
            role: Object,
            permissions: Array,
            errors: Object
        },

        data() {
            return {
                form: useForm({
                    _method: 'patch',
                    permissions: []
                })
            }
        },

        mounted() {
            this.role.permissions.forEach(el => {
                this.form.permissions.push(el.id)
            })
        },

        methods: {
            updateData() {
                this.$inertia.post(`/roles/permissions/${this.role.id}`, this.form)
            }
        }
    }
</script>
