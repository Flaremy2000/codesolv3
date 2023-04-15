<template>
    <h2 class="text-center my-4">Noticias</h2>
    <CategoriasSelect @categoriaSeleccionado="selecion"></CategoriasSelect>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-2 mb-3 justify-content-center">
        <div class="col-12 text-center" v-if="loading">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="col" v-else v-for="(noticia) in noticias" :key="noticia.id_noticia">
            <div class="card shadow-sm" @click="iranoticia(noticia.id_noticia)">
                <img v-if="noticia.imagen" class="bd-placeholder-img card-img-top" width="100%" height="255" role="img"
                    preserveaspectratio="xMidYMid slice" focusable="false" :src="'images/noticias/' + noticia.imagen">
                <img v-else class="bd-placeholder-img card-img-top" width="100%" height="255" role="img"
                    preserveaspectratio="xMidYMid slice" focusable="false" src='images/noticias/loader_image.webp'>
                <div class="card-body">
                    <a class="h4">{{ noticia.titulo }}</a>
                    <p class="card-text">
                        {{ noticia.texto_largo && noticia.texto_largo.length > 60 ? noticia.texto_largo.substring(0, 60) + '...' : noticia.texto_largo }}
                    </p>

                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">{{ noticia.fecha }}</small>
                </div>
            </div>
        </div>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a v-if="prev_page_url" class="page-link" @click="loadPage(prev_page_url)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-caret-left" viewBox="0 0 16 16">
                        <path
                            d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z" />
                    </svg>
                </a></li>
            <li class="page-item" v-for="(link, index) in filtered_links" :key="index" :class="{ active: link.active }"><a
                    v-if="link.url != null && link.label != 'pagination.next' && link.label != 'pagination.previous'"
                    class="page-link" @click="loadPage(link.url)">{{ link.label }}</a></li>
            <li class="page-item"><a v-if="next_page_url" class="page-link" @click="loadPage(next_page_url)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-caret-right" viewBox="0 0 16 16">
                        <path
                            d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z" />
                    </svg>
                </a></li>
        </ul>
    </nav>
</template>

<script>
import CategoriasSelect from "./FiterSelect.vue";
import axios from 'axios';
export default {
    name: 'Cardnews',
    components: { CategoriasSelect },
    data() {
        return {
            seleccionados: '',
            loading: true,
            noticias: [],
            current_page: 1,
            last_page: 1,
            total: 0,
            per_page: 0,
            from: 0,
            to: 0,
            first_page_url: '',
            last_page_url: '',
            links: [],
            path: '',
            next_page_url: '',
            prev_page_url: '',
            existarchivo: false,
        };
    }, mounted() {
        axios.get('/api/noticia')
            .then(response => {
                this.noticias = response.data.data;
                this.current_page = response.data.current_page;
                this.last_page = response.data.last_page;
                this.total = response.data.total;
                this.per_page = response.data.per_page;
                this.from = response.data.from;
                this.to = response.data.to;
                this.first_page_url = response.data.first_page_url;
                this.last_page_url = response.data.last_page_url;
                this.links = response.data.links;
                this.path = response.data.path;
                this.next_page_url = response.data.next_page_url;
                this.prev_page_url = response.data.prev_page_url;
                this.loading = false;
            }).catch(error => {
                console.log(error);
            });
    }, methods: {
        selecion(seleccionados) {
            this.loading = true;
            if (seleccionados === 'all') {
                axios.get('/api/noticia')
                    .then(response => {
                        this.noticias = response.data.data;
                        this.current_page = response.data.current_page;
                        this.last_page = response.data.last_page;
                        this.total = response.data.total;
                        this.per_page = response.data.per_page;
                        this.from = response.data.from;
                        this.to = response.data.to;
                        this.first_page_url = response.data.first_page_url;
                        this.last_page_url = response.data.last_page_url;
                        this.links = response.data.links;
                        this.path = response.data.path;
                        this.next_page_url = response.data.next_page_url;
                        this.prev_page_url = response.data.prev_page_url;
                        this.loading = false;
                    }).catch(error => {
                        console.log(error);
                    });
            } else {
                axios.get('/api/noticia/' + seleccionados)
                    .then(response => {
                        this.noticias = response.data.data;
                        this.current_page = response.data.current_page;
                        this.last_page = response.data.last_page;
                        this.total = response.data.total;
                        this.per_page = response.data.per_page;
                        this.from = response.data.from;
                        this.to = response.data.to;
                        this.first_page_url = response.data.first_page_url;
                        this.last_page_url = response.data.last_page_url;
                        this.links = response.data.links;
                        this.path = response.data.path;
                        this.next_page_url = response.data.next_page_url;
                        this.prev_page_url = response.data.prev_page_url;
                        this.loading = false;
                    }).catch(error => {
                        console.log(error);
                    });
            }
        },
        loadPage(pageUrl) {
            axios.get(pageUrl)
                .then(response => {
                    this.noticias = response.data.data;
                    this.current_page = response.data.current_page;
                    this.last_page = response.data.last_page;
                    this.total = response.data.total;
                    this.per_page = response.data.per_page;
                    this.from = response.data.from;
                    this.to = response.data.to;
                    this.first_page_url = response.data.first_page_url;
                    this.last_page_url = response.data.last_page_url;
                    this.links = response.data.links;
                    this.path = response.data.path;
                    this.next_page_url = response.data.next_page_url;
                    this.prev_page_url = response.data.prev_page_url;
                    this.loading = false;
                }).catch(error => {
                    console.log(error);
                });
        }, iranoticia(id) {
            window.location.href = '/contenido_noticia/' + id;
        }
    }, computed: {
        filtered_links() {
            return this.links.filter(link => link.label !== "&laquo; Previous" && link.label !== "Next &raquo;");
        }
    }
}
</script>

<style scoped>
.card>a {
    pointer-events: none;
    text-decoration: none;

}

.card {
    cursor: pointer;
}

.card:hover {
    background-color: #f5f5f5;
}

.card:hover .card-img-top {
    opacity: 0.5;
}

.card:hover .card-img-top:hover {
    opacity: 1;
}

.card:active {
    background-color: #b6b6b6;
}
</style>
