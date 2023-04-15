<template>
    <div class="form-floating my-3">
        <select class="form-select" id="listcategoria" @change="emitcategoriaSeleccionado"
            aria-label="Floating label select example">
            <option value="all" selected>Seleccione un horario</option>
            <option v-for="(categoria) in categorias" :key="categoria.id_categoria" :value="categoria.id_categoria">
                {{ categoria.nombre_categoria }}</option>
        </select>
        <label for="listcategoria">Categorias</label>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name: 'FilterSelectServices',
    data() {
        return {
            categorias: [],
        }
    }, mounted() {
        axios.get('/api/categoria/services')
            .then(response => {
                this.categorias = response.data;
            }).catch(error => {
                console.log(error);
            });
    },
    methods: {
        emitcategoriaSeleccionado(e) {
            this.$emit('categoriaserviceSeleccionado', e.target.value);
        }
    }
};
</script>
