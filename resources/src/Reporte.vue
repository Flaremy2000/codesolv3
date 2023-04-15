<template>
    <div class="container mt-3">
        <div class="row my-3">
            <div class="col-12">
                <h1 class="mt-5 mb-3 text-center">Mis Incidentes</h1>
            </div>
            <div class="col-4" v-for="(reporte, index) in listReport" :key="index">
                <CardReport :title="reporte.fecha_reporte" :description="reporte.descripcion + '.'"
                    :comentario="reporte.comentarios !== null ? reporte.comentarios : 'PRONTO TENDRA RESPUESTA'"
                    :listimage="reporte.images"
                    :timeresolved="reporte.fecha_comentario !== null ? reporte.fecha_comentario : 'EN PROCESO'">
                </CardReport>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import CardReport from "./components/ReporteComponents/CardRepot.vue";

export default {
    name: "Reporte",
    components: {
        CardReport
    }, data() {
        return {
            listReport: [],
            user: []
        }
    },
    mounted() {
        // Validate if user exist in localstorage and if exist, get data
        if (localStorage.getItem('user') !== null && localStorage.getItem('user') !== undefined && localStorage.getItem('user') !== '') {
            this.user = JSON.parse(localStorage.getItem('user'));
        }
        axios.get(`/api/reporte/${this.user.id_user}`)
            .then(response => {
                this.listReport = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    }
}
</script>

<style></style>
