<template>
    <div class="container mt-5 pt-3">
        <div v-if="loading" class="d-flex justify-content-center load">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-else>
            <h2>{{ title }}</h2>
            <div class="card mb-3 text-center">
                <div class="card-header">
                    <h5 class="card-title">{{ title }}</h5>
                </div>
                <div class="row">
                    <div class="col-md-4 p-3" v-if="image != null">
                        <img :src="'../images/noticias/' + image" class="card-img" :alt="title">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <p class="card-text" v-if="longtext != null">{{ longtext }}</p>
                        </div>
                    </div>
                    <div class="accordion mb-3" v-if="pdffile != null">
                        <div class="accordion-item">
                            <h2 class="accordion-header" :id="'heading'">
                                <button class="accordion-button collapsed" type="button">
                                    {{ title }}
                                </button>
                            </h2>
                            <div :id="'collapse'" class="accordion-collapse collapse">
                                <div class="accordion-body text-center">
                                    <div class="mb-2">
                                        <a :href="'../documents/news/' + pdffile" type="button" class="btn btn-primary"
                                            :download="title">
                                            Descargar {{ title }}
                                        </a>
                                    </div>
                                    <embed :src="'../documents/news/' + pdffile" type="application/pdf" width="100%"
                                        height="600px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        {{ date }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lightbox-container" style="position: relative;">
        <div class="lightbox">
            <div class="lightbox-content">
                <img src="" alt="" class="lightbox-image">
                <span class="close">&times;</span>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "NewsContent",
    data() {
        return {
            title: null,
            longtext: null,
            image: null,
            date: null,
            pdffile: null,
            category: null,
            loading: true,
        };
    },
    mounted() {
        const carrousel = document.querySelector('.row');
        const close = document.querySelector('.close');
        const lightbox = document.querySelector('.lightbox');
        const lightboxImage = document.querySelector('.lightbox-image');
        const id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
        axios.get('/detallnoticia/' + id)
            .then(response => {
                this.title = response.data.titulo;
                this.longtext = response.data.texto_largo;
                this.image = response.data.imagen;
                this.date = response.data.fecha;
                this.pdffile = response.data.archivo;
                this.category = response.data.categoria;
                this.loading = false;
            })
            .catch(error => {
                console.log(error);
            });

        carrousel.addEventListener('click', (e) => {
            const image = e.target.src;
            lightboxImage.src = image;
            lightbox.style.display = 'flex';
        });

        close.addEventListener('click', () => {
            lightbox.style.display = 'none';
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                lightbox.style.display = 'none';
            }
        });

    },
    methods: {
    }

}
</script>

<style scoped>
.accordion .accordion-item:hover .accordion-collapse {
    box-sizing: border-box !important;
    display: block !important;
}

.accordion-item:hover .accordion-button {
    background: #007bff;
    color: #fff;
}


/* Show up all elements  */
.lightbox-container {
    position: relative;
    z-index: 1130;
}

.lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    display: none;
    justify-content: center;
    align-items: center;
}

.lightbox-content {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.lightbox-image {
    width: 80%;
    height: auto;
    object-fit: contain;
}

.close {
    color: #fff;
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 3rem;
    font-weight: bold;
    cursor: pointer;
}
</style>
