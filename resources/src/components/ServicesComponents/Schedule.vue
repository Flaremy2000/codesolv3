<template>
    <FilterSelectServices @categoriaserviceSeleccionado="selecion"></FilterSelectServices>
    <div v-if="seleccionados === 'all'">
        <h3 class="text-center alert alert-primary my-3">Seleccione un Horario</h3>
    </div>
    <div v-else>
        <div class="table-responsive-md">
            <table v-if="schedule.length > 0" class="table">
                <thead>
                    <tr class="table-info">
                        <th scope="col">Horario</th>
                        <th scope="col">Lunes</th>
                        <th scope="col">Martes</th>
                        <th scope="col">Miercoles</th>
                        <th scope="col">Jueves</th>
                        <th scope="col">Viernes</th>
                        <th scope="col">Sabado</th>
                        <th scope="col">Domingo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Matutino</th>
                        <td v-for="(element, index) in matutina" :key="index">{{ element }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Vespertina</th>
                        <td v-for="(element, index) in vespertina" :key="index">{{ element }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-else>
                <h3 class="text-center alert alert-primary my-3">No hay horario disponible</h3>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import FilterSelectServices from './FilterSelectServices.vue';

export default {
    name: 'Schedule',
    components: { FilterSelectServices },
    data() {
        return {
            seleccionados: '',
            schedule: [],
            matutina: [],
            vespertina: [],
        };
    }, methods: {
        selecion(seleccionados) {
            this.seleccionados = seleccionados;
            if (seleccionados === 'all') {
                this.schedule = [];
            } else {
                axios.get('/api/horario/' + seleccionados)
                    .then(response => {
                        this.schedule = response.data;
                        // Add to matutina and vespertina array
                        this.matutina = [];
                        this.vespertina = [];
                        this.schedule.forEach(element => {
                            this.matutina.push(element.Matutina);
                            this.vespertina.push(element.Vespertina);
                        });
                    }).catch(error => {
                        console.log(error);
                    });
            }
        },
    }

}
</script>

<style></style>
