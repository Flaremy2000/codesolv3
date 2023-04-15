<template>
    <div class="form-floating my-3">
        <select class="form-select" id="listcategoria" @change="emitcategoriaSeleccionado"
            aria-label="Floating label select example">
            <option value="all" selected>Todos</option>
            <option v-for="(categoria) in categorias" :key="categoria.id_categoria" :value="categoria.id_categoria">
                {{ categoria.nombre_categoria }}</option>
        </select>
        <label for="listcategoria">Categorias</label>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name: 'FilterDocuments',
    data() {
        return {
            categorias: [],
            user: [],
        }
    }, mounted() {
        if (localStorage.getItem('user') !== null && localStorage.getItem('user') !== undefined && localStorage.getItem('user') !== '') {
            this.user = JSON.parse(localStorage.getItem('user'));
        }
        axios.defaults.headers.common['X-User-Data'] = JSON.stringify(this.user);
        axios.get('/api/categoria/transparent')
            .then(response => {
                this.categorias = response.data;
            }).catch(error => {
                console.log(error);
            });
    },
    methods: {
        emitcategoriaSeleccionado(e) {
            this.$emit('categoriaSeleccionado', e.target.value);
        }
    }
};
</script>
