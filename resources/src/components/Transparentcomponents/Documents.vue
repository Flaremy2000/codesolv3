<template>
    <h2 class="text-center">Transparencia</h2>
    <FilterDocuments @categoriaSeleccionado="selecion" />
    <div class="accordion mb-3">
        <div class="accordion-item" v-for="(document) in documentos" :key="document.id_document">
            <h2 class="accordion-header" :id="'heading' + document.id_document">
                <button class="accordion-button collapsed" type="button">
                    {{ document.title }} - {{ document.date }}
                </button>
            </h2>
            <div :id="'collapse' + document.id_document" class="accordion-collapse collapse">
                <div class="accordion-body text-center">
                    <div class="mb-2">
                        <a :href="'documents/transparent/' + document.file" type="button" class="btn btn-primary"
                            :download="document.title">
                            Descargar {{ document.title }}
                        </a>
                    </div>
                    <embed :src="'documents/transparent/' + document.file" type="application/pdf" width="100%"
                        height="600px">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FilterDocuments from "./Fiterdocuments.vue";
import axios from 'axios';

export default {
    name: 'Documents',
    components: { FilterDocuments },
    data() {
        return {
            seleccionados: '',
            user: [],
            loading: true,
            documentos: [],
        }
    }, mounted() {
        // Validate if user exist in localstorage and if exist, get data
        if (localStorage.getItem('user') !== null && localStorage.getItem('user') !== undefined && localStorage.getItem('user') !== '') {
            this.user = JSON.parse(localStorage.getItem('user'));
        }
        axios.defaults.headers.common['X-User-Data'] = JSON.stringify(this.user);
        axios.get(`/api/documento`)
            .then(response => {
                this.documentos = response.data;
                this.loading = false;
                console.log(this.documentos);
            }).catch(error => {
                console.log(error);
            });
    }, methods: {
        selecion(seleccionados) {
            this.loading = true;
            if (seleccionados === 'all') {
                axios.defaults.headers.common['X-User-Data'] = JSON.stringify(this.user);
                axios.get('/api/documento')
                    .then(response => {
                        this.documentos = response.data;
                        this.loading = false;
                    }).catch(error => {
                        console.log(error);
                    });
            } else {
                axios.defaults.headers.common['X-User-Data'] = JSON.stringify(this.user);
                axios.get('/api/documento/' + seleccionados)
                    .then(response => {
                        this.documentos = response.data;
                        this.loading = false;
                    }).catch(error => {
                        console.log(error);
                    });
            }
        }
    }

}
</script>

<style scoped>
/* Acordion item hover expanded acordeon collapse and show information */
.accordion .accordion-item:hover .accordion-collapse {
    box-sizing: border-box !important;
    display: block !important;
}

.accordion-item:hover .accordion-button {
    background: #007bff;
    color: #fff;
}
</style>
