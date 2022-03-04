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
                                <form @submit.prevent="addRole" action="#" method="POST" encType="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <input v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid':errors.name}" placeholder="Name"/>
                                            <span v-if="errors.name" class="invalid-feedback" role="alert">
                                                <strong>{{ errors.name }}</strong>
                                            </span>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <select v-model="form.guardName" name="guardName" class="form-control" :class="{ 'is-invalid':errors.guardName}">
                                                <option value="" disabled>Guard Name</option>
                                                <option value="web">web</option>
                                                <option value="api">api</option>
                                            </select>
                                            <span v-if="errors.guardName" class="invalid-feedback" role="alert">
                                                <strong>{{ errors.guardName }}</strong>
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

    export default {
        components: {
            Layout,
            Head,
            Link
        },

        props: {
            errors: Object
        },

        data() {
            return {
                form: {
                    name: '',
                    guardName: '',
                }
            }
        },

        methods: {
            addRole() {
                this.$inertia.post('/roles', this.form)
            }
        }
    }
</script>



