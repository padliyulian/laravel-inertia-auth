<template>
    <div v-if="data.last_page > 1" class="row mt-2">
        <div class="col-12 col-md-6 pt-2">
            Show {{ data.to }} Of {{ data.total }}
        </div>
        <div class="col-12 col-md-6">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li v-if="data.current_page != 1" class="page-item">
                        <Link class="page-link" :href="`${data.first_page_url}&length=${q.limit}&column=${q.column}&dir=${q.dir}&search=${q.search}`">
                            First
                        </Link>
                    </li>
                    <li v-else class="page-item disabled">
                        <Link class="page-link" href="#">
                            First
                        </Link>
                    </li>
                    <li v-if="data.current_page == 1" class="page-item disabled">
                        <Link class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </Link>
                    </li>
                    <li v-else class="page-item">
                        <Link class="page-link" :href="`${data.prev_page_url}&length=${q.limit}&column=${q.column}&dir=${q.dir}&search=${q.search}`" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </Link>
                    </li>
                    <li class="page-item active">
                        <Link class="page-link" href="#">
                            {{ data.current_page }}
                        </Link>
                    </li>
                    <li v-if="data.current_page == data.last_page" class="page-item disabled">
                        <Link class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </Link>
                    </li>
                    <li v-else class="page-item">
                        <Link class="page-link" :href="`${data.next_page_url}&length=${q.limit}&column=${q.column}&dir=${q.dir}&search=${q.search}`" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </Link>
                    </li>
                    <li v-if="data.current_page != data.last_page" class="page-item">
                        <Link class="page-link" :href="`${data.last_page_url}&length=${q.limit}&column=${q.column}&dir=${q.dir}&search=${q.search}`">
                            Last
                        </Link>
                    </li>
                    <li v-else class="page-item disabled">
                        <Link class="page-link" href="#">
                            Last
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            Link
        },
        props: {
            data: Object,
            q: Object
        }
    }
</script>

<style>
    .pagination {
        justify-content: end;
    }
</style>
