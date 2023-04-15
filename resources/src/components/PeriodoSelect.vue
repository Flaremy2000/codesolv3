<template>
    <div class="form-floating">
        <select class="form-select" id="listperiodo" @change="emitPeriodoSeleccionado" aria-label="Floating label select example">
            <option selected>Seleccione un periodo</option>
            <option v-for="(periodo) in periodos" :key="periodo.id_periodo" :value="periodo.id_periodo">{{ periodo.fecha_inicio + " - " + periodo.fecha_fin }}</option>
        </select>
        <label for="listperiodo">Periodos</label>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name: 'PeriodosSelect',
    data() {
        return{
            periodos: [],
        }
    },mounted(){
        axios.get('/api/periodos')
            .then(response => {
            this.periodos = response.data;
            }).catch(error => {
                console.log(error);
            });
    },
    methods: {
        emitPeriodoSeleccionado(e){
            this.$emit('periodoSeleccionado', e.target.value);
        }
    }
};
</script>
