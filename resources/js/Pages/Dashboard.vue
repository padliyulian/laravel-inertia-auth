<template>
    <Layout>
        <Head title="Inertia | Dashboard" />
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Dashboard</li>
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
                        <div class="alert alert-success" role="alert">
                            Success ...
                        </div>

                        You are logged in!
                    </div>
                    <div class="card-footer">
                    </div>
                </div>

            </section>
        </div>
    </Layout>
</template>


<script>
    import Layout from '../Layouts/Dasboard.vue'
    import { Head } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            Layout,
            Head
        },
        props: {

        },
    }
</script>
