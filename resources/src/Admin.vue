<template>
    <div id="content_section" class="mt-3">
        <section>
            <h3>Carruseles</h3>
            <CarrouselTableComponent></CarrouselTableComponent>
        </section>
        <section>
            <h3>Directorio</h3>
            <DirectoryTableComponent></DirectoryTableComponent>
        </section>
        <section>
            <h3>Noticia</h3>
            <NoticiasTableComponent></NoticiasTableComponent>
        </section>
        <section>
            <h3>Documentos</h3>
            <DocumentsTableComponent></DocumentsTableComponent>
        </section>
        <section>
            <h3>Horarios</h3>
        </section>
        <section>
            <h3>Usuario</h3>
            <UsuarioTableComponent></UsuarioTableComponent>
        </section>
        <section>
            <h3>Incidentes </h3>
        </section>
        <section>
            <h3>Sugerencias</h3>
        </section>
        <section>
            <h3>Chat</h3>
        </section>
    </div>
</template>

<script>
import CarrouselTableComponent from './components/AdminComponents/CarrouselTableComponent.vue';
import DirectoryTableComponent from './components/AdminComponents/DirectoryTableComponent.vue';
import UsuarioTableComponent from './components/AdminComponents/UsuarioTableComponent.vue';
import NoticiasTableComponent from './components/AdminComponents/NoticiasTableComponent.vue';
import DocumentsTableComponent from './components/AdminComponents/DocumentsTableComponent.vue';


export default {
    components: {
        CarrouselTableComponent, DirectoryTableComponent, UsuarioTableComponent,
        NoticiasTableComponent,
        DocumentsTableComponent
    },
    data() {
        return {}
    }, methods: {
    }
}
</script>

<style scoped>
@import 'datatables.net-bs5';

body {
    overflow: hidden;
}

#content_section {
    height: 50vh;
    overflow-y: auto;
    overflow-x: hidden;
}

#content_section::-webkit-scrollbar {
    width: 0.5rem !important;
    border-radius: 25px !important;
}

#content_section::-webkit-scrollbar-track {
    background-color: #f1f1f1 !important;
    border-radius: 25px !important
}

#content_section::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 25px !important
}

#content_section::-webkit-scrollbar-thumb:hover {
    background-color: #555;
    border-radius: 25px !important;
}
</style>
