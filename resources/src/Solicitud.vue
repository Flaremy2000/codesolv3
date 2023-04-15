<template>
    <div class="container mt-3">
        <div class="row my-3">
            <div class="col-12">
                <h1 class="mt-5 mb-3">Solicitudes</h1>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                        v-model="selecciona" @change="seleccionado">
                        <option value="all" selected>Seleccione una solicitud</option>
                        <option v-for="soli in solicitudes" :key="soli.id" :value="soli.id">{{ soli.name }}</option>
                    </select>
                    <label for="floatingSelect">Lista de Solicitudes</label>
                </div>
            </div>
            <div class="col-12 text-center">
                <a type="button" v-if="selecciona != 'all'" class="btn btn-success mt-3 text-center" :href="download"
                    target="_blank">Descargar
                    {{ titulo }}</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Solicitud",
    data() {
        return {
            selecciona: 'all',
            solicitudes: [
                { id: 1, name: "Registro a MIDUVI", document: "Solicitud_Registro.docx" },
                { id: 2, name: "Alquiler del Club", document: "contrato_uso_club.docx" },
                { id: 3, name: "Solicitudes Varias", document: "solicitud_varios.docx" },
            ],
            titulo: null,
            download: null
        };
    },
    methods: {
        seleccionado(e) {
            // Get the selected option in the solicitudes array
            const selectar = this.solicitudes.find(soli => soli.id == e.target.value);
            console.log(selectar);
            // Titulo set to the name of the selected option
            this.titulo = selectar.name;
            console.log(this.titulo);
            // Download link set to the document of the selected option
            this.download = "/documents/solicitud/" + selectar.document;
            console.log(this.download);
        }
    }

}
</script>

<style></style>
