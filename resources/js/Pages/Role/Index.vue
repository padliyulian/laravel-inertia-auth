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
                                <li class="breadcrumb-item active">
                                    Roles
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
                                <Link href="/roles/create" class="btn btn-primary btn-block">
                                    Tambah
                                </Link>
                            </div>
                            <div class="form-group col-lg-2">
                                <Link href="/roles" class="btn btn-success btn-block">Reset</Link>
                            </div>
                            <div class="form-group col-lg-2">
                                <select v-model="q.limit" @change="changeLength" name="limit" id="limit" class="custom-select">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <input v-model="q.search" @keyup="searchData" type="text" name="search" id="search" class="form-control" placeholder="Cari data by name ..."/>
                            </div>
                        </div>
                        <div>
                            <table class="table table-striped table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th @click="changeDir('name')" class="c--pointer">
                                            <i class="fas fa-sort"></i>
                                            Name
                                        </th>
                                        <th @click="changeDir('guard_name')" class="c--pointer">
                                            <i class="fas fa-sort"></i>
                                            Guard Name
                                        </th>
                                        <th @click="changeDir('created_at')" class="c--pointer">
                                            <i class="fas fa-sort"></i>
                                            Created
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in roles.data" :key="item.id">
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.guard_name }}</td>
                                        <td>
                                            {{ moment(item.created_at).format('DD/MM/Y') }}
                                        </td>
                                        <td>
                                            <Link :href="`/roles/permissions/${item.id}`" title="Permission">
                                                <span class="text-primary">
                                                    <i class="fas fa-user-shield" aria-hidden="true"></i>
                                                </span>
                                            </Link>
                                            <Link :href="`/roles/edit/${item.id}`" title="Edit">
                                                <span class="text-warning">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </span>
                                            </Link>
                                            <Link @click.prevent="delData(item.id)" href="#" title="Delete">
                                                <span class="text-danger">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </span>
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Pagination :data="roles" :q="q" />
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
            column: String,
            dir: String,
            search: String,
            length: Number,
            roles: Object,
        },

        data() {
            return {
                q: {
                    limit: 10,
                    column: '',
                    dir: '',
                    search: ''
                }
            }
        },

        created() {
            this.moment = moment
            this.q.limit = this.length
            this.q.column = this.column
            this.q.dir = this.dir
            this.q.search = this.search
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
            changeDir(val) {
                this.q.column = val
                this.reverseSort()
                this.getData()
            },

            changeLength() {
                this.getData()
            },

            searchData() {
                this.getData()
            },

            reverseSort()
            {
                if (this.q.dir === 'asc') {
                    this.q.dir = 'desc'
                } else {
                    this.q.dir = 'asc'
                }
            },

            getData() {
                this.$inertia.get('/roles',
                    {
                        length: this.q.limit,
                        column: this.q.column,
                        dir: this.q.dir,
                        search: this.q.search
                    },
                    {
                        preserveState: true,
                        preserveScroll: true,
                        replace: true
                    }
                )
            },

            delData(id) {
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
                        this.$inertia.delete(`/roles/${id}`)
                        setTimeout(() => {
                            if ($('#message-success').val()) {
                                Swal.fire(
                                    'Success',
                                    `${$('#message-success').val()}`,
                                    'success'
                                )
                            }
                        }, 1000)
                    }
                })
            }
        }
    }
</script>



