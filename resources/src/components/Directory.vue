<template>
    <h2 class="text-center my-4">Directorio</h2>
    <PeriodosSelect @periodoSeleccionado="selecion"></PeriodosSelect>

    <div class="row row-cols-lg-3 align-items-stretch g-4 py-5">
        <div class="col" v-for="(directorio) in directorios" :key="directorio.id_directorio">
            <div class="cardi">
                <img :src="'images/directorio/'+ directorio.periodo_directorio+ '/' + directorio.imagen_directorio">
                <div class="content">
                    <h2 class="text-center h2"> {{ directorio.cargo.nombre_cargo }} </h2>
                    <h3 class="text-center"> {{ directorio.nombre_directorio + " " + directorio.apellido_directorio }}</h3>
                </div>
            </div>
        </div>
    </div>
        <div class="container border-top" v-if="mostrarcomision">
            <h2 class="text-center my-4">Comisiones</h2>
            <div class="row row-cols-lg-3 align-items-stretch g-4 py-5">
            <div class="col" v-for="(directorio) in directorios" :key="directorio.id_directorio">
                <div class="cardi" v-if="directorio.comision.id_comision !== 1">
                    <img :src="'images/comision/'+ directorio.comision.imagen">
                    <div class="content">
                        <h2 class="text-center h2"> {{ directorio.comision.nombre_comision }} </h2>
                        <h3 class="text-center"> {{ directorio.nombre_directorio + " " + directorio.apellido_directorio }}</h3>
                    </div>
                </div>
            </div>
        </div>
        </div>
</template>

<script>
import axios from 'axios';
import PeriodosSelect from './PeriodoSelect.vue';

export default {
    name: 'Directorio',
    components: { PeriodosSelect },
    data() {
        return {
            seleccionados: '',
            mostrarcomisiones: false,
            directorios: [],
        };
    }, methods: {
        selecion(seleccionados) {
            axios.get('/api/directorio/' + seleccionados)
                .then(response => {
                    this.directorios = response.data;
                }).catch(error => {
                    console.log(error);
                });
        },
    }, computed: {
        mostrarcomision() {
            const mostrar = this.directorios.filter(directorio => directorio.comision.id_comision !== 1);
            return this.mostrarcomisiones = mostrar.length > 0? true : false;
        },
    },

}
</script>

<style scoped>

.cardi {
    width: 210px;
    height: 250px;
    position: relative;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 0 20px rgba(0,0,0,0.123);
}
.cardi img{
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

/* Reduce size h2 when mouse hover */
.cardi:hover h2{
    font-size: 2.2em;
}
.content {
    position: absolute;
    width: 100%;
    height: 70px;
    bottom: 0;
    padding: 0.4em 1.5em;
    font-size: 12px;
    background: rgba(255,255,255, 0);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    transform: scale(0.7);
    color: black;
    border: 1px solid rgba(255,255,255, 0.164);
    box-shadow: 0 0 20px rgba(0,0,0,0.144);
    overflow: hidden;
    transition: all .8s;
}

.cardi:hover .content{
    transform: scale(1);
    height: 220px;
}

/* when mouse hover the image transparent and reduce color */
.cardi:hover img{
    opacity: 0.5;
    filter: grayscale(100%);
}

</style>
