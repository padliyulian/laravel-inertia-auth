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
                                <li class="breadcrumb-item active">
                                    Users
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
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
                        <div v-if="$page.props.flash.message">
                            <input type="hidden" name="message-success" id="message-success" :value="$page.props.flash.message">
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-2">
                                <Link href="/users/create" class="btn btn-primary btn-block">
                                    Tambah
                                </Link>
                            </div>
                            <div class="form-group col-lg-2">
                                <Link href="/users" class="btn btn-success btn-block">Reset</Link>
                            </div>
                            <div class="form-group col-lg-2">
                                <select v-model="length" @change="changeLength" name="limit" id="limit" class="custom-select">
                                    <option value="2">2</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <input v-model="search" @keyup="searchData" type="text" name="search" id="search" class="form-control" placeholder="Cari data by name ..."/>
                            </div>
                        </div>
                        <div>
                            <table class="table table-striped table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th class="c--pointer">
                                            <i class="fas fa-sort"></i>
                                            Name
                                        </th>
                                        <th class="c--pointer">
                                            <i class="fas fa-sort"></i>
                                            Email
                                        </th>
                                        <th>Photo</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th class="c--pointer">
                                            <i class="fas fa-sort"></i>
                                            Created
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users.data" :key="user.id">
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>
                                            <img v-if="user.photo" :src="`/storage/images/${user.photo}`" alt="" class="img-circle elevation-2" width="40">
                                            <img v-else src="/storage/images/woman.png" alt="" class="img-circle elevation-2" width="40">
                                        </td>
                                        <td>
                                            <span v-if="user.roles.length">
                                                {{ user.roles[0].name }}
                                            </span>
                                            <span v-else>-</span>
                                        </td>
                                        <td>
                                            <span v-if="user.status == 1" class="badge px-2 py-1 badge-pill badge-warning text-white">
                                                Created
                                            </span>
                                            <span v-if="user.status == 2" class="badge px-2 py-1 badge-pill badge-success">
                                                Active
                                            </span>
                                        </td>
                                        <td>
                                            {{ moment(user.created_at).format('DD/MM/Y') }}
                                        </td>
                                        <td>
                                            <Link :href="`/users/edit/${user.id}`" title="Edit">
                                                <span class="text-warning">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </span>
                                            </Link>
                                            <Link @click.prevent="delUser(user.id)" href="#" title="Delete">
                                                <span class="text-danger">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </span>
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Pagination :data="users" />
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </section>
        </div>
    </Layout>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'
    import moment from "moment"
    import Layout from '../../Layouts/Dasboard.vue'
    import { Head } from '@inertiajs/inertia-vue3'
    import Pagination from '../../Components/Pagination/Index.vue'
    export default {
        components: {
            Layout,
            Head,
            Link,
            Pagination
        },

        props: {
            users: Object,
        },

        data() {
            return {
                length: 10,
                search: ''
            }
        },

        created() {
            this.moment = moment
        },

        mounted() {
            if ($('#message-success').val()) {
                Swal.fire(
                    'Success',
                    `${$('#message-success').val()}`,
                    'success'
                )
            }
        },

        methods: {
            changeLength() {
                this.$inertia.get('/users', {length: this.length}, {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true
                })
            },

            searchData() {
                this.$inertia.get('/users', {search: this.search}, {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true
                })
            },

            delUser(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$inertia.delete(`/users/${id}`)
                    }
                })
            }
        }
    }
</script>



