<template>
    <div>
        <carousel :items="items" :loading="loading" />
        <div class="container col-xxl-8 px-4 py-5 border-bottom w-100">
            <div class="row flex-lg-row-reverse align-items-center justify-content-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6 align-items-center justify-content-center text-center">
                    <img src="images/inicio/home.jpeg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes"
                        width="600" height="500" loading="lazy" style="border-radius: 20%">
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold lh-1 mb-3">URBANIZACIÓN COLINA DEL SOL</h1>
                    <p class="lead" style="text-align: justify">Se encuentra ubicada en la parroquia Pascuales, en el
                        kilómetro 12.5 de la vía a Daule, perteneciente a la Jurisdicción Cantonal de Guayaquil, Provincia
                        del Guayas, República del Ecuador.</p>
                </div>
            </div>
        </div>
        <directorio />
    </div>
</template>

<script>
import Carousel from './components/Carrousel.vue';
import Directorio from './components/Directory.vue';
import axios from 'axios';

export default {
    name: 'AppCarousel',
    components: { Carousel, Directorio },
    data() {
        return {
            items: [],
            loading: true,
        };
    },
    mounted() {
        this.loading = true;
        axios.get('/api/carousel/home')
            .then(response => {
                this.items = response.data;
                this.loading = false;
            }).catch(error => {
                console.log(error);
            });
    }
};
</script>
