<template>
    <div class="form-floating my-3">
        <select class="form-select" id="listcategoria" @change="emitcategoriaSeleccionado" aria-label="Floating label select example">
            <option value="all" selected>TODOS</option>
            <option v-for="(categoria) in categorias" :key="categoria.id_categoria" :value="categoria.id_categoria">{{ categoria.nombre_categoria }}</option>
        </select>
        <label for="listcategoria">Categorias</label>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name: 'CategoriasSelect',
    data() {
        return{
            categorias: [],
        }
    },mounted(){
        axios.get('/api/categoria/news')
            .then(response => {
            this.categorias = response.data;
            }).catch(error => {
                console.log(error);
            });
    },
    methods: {
        emitcategoriaSeleccionado(e){
            this.$emit('categoriaSeleccionado', e.target.value);
        }
    }
};
</script>
