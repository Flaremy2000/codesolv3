<template>
    <carousel :items="items" :loading="loading" />
    <div class="container">
        <h1 class="text-center my-3 py-3 border-top">
            Horarios de atención
        </h1>
        <schedule />
    </div>
</template>

<script>
import Carousel from './components/Carrousel.vue';
import Schedule from './components/ServicesComponents/Schedule.vue';
import axios from 'axios';

export default {
    name: "attention",
    components: { Carousel, Schedule },
    data() {
        return {
            items: [],
            loading: true,
        };
    }, mounted() {
        axios.get('/api/carousel/services')
            .then(response => {
                this.items = response.data;
                this.loading = false;
            }).catch(error => {
                console.log(error);
            });
    },
    methods: {
    },
}
</script>
