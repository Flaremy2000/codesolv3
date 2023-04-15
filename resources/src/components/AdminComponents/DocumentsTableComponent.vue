<template>
    <button class="btn btn-success" @click="adddocument">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle"
            viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
            <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
        </svg>
        Agregar Documento</button>

    <table id="documentstable" class="table table-hover table-striped" width="100%">
        <thead>
            <tr>
                <th class="text-center">Titulo</th>
                <th class="text-center">Categoría</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in documents" :key="item.id_document">
                <td class="text-center">{{ item.title }}</td>
                <td class="text-center">{{ item.nombre_categoria }}</td>
                <td class="text-center">
                    <button :id="'eddir' + item.id_noticia" class="btn btn-primary" @click="editdoc(item)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil" viewBox="0 0 16 16">
                            <path
                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg></button>
                    <button :id="'eldir' + item.id_noticia" class="btn btn-danger ms-2" @click="deletedoc(item)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd"
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                        </svg>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>

    <ModalB5 :title="title" :fields="inputlist" :ejectfunction="functionality" v-if="showModal" @close="showModal = false">
    </ModalB5>
</template>
<script scoped>
import DataTable from 'datatables.net-vue3'
import DataTablesCore from 'datatables.net-bs5';
import 'datatables.net-responsive';
import 'datatables.net-select';
import $ from 'jquery';
import ModalB5 from '../../ModalB5.vue';
import axios from 'axios';

DataTable.use(DataTablesCore);

export default {
    name: 'DocumentsTableComponent',
    components: {
        DataTable,
        ModalB5
    },
    data() {
        return {
            documents: [],
            showModal: false,
            title: null,
            inputlist: [],
            functionality: null,
            id_document: null,
            doccat: []
        }
    },
    methods: {
        table() {
            this.$nextTick(() => {
                $('#documentstable').DataTable();
            })
        },
        getAllDocuments() {
            if (localStorage.getItem('user') !== null && localStorage.getItem('user') !== undefined && localStorage.getItem('user') !== '') {
                this.user = JSON.parse(localStorage.getItem('user'));
            }
            axios.defaults.headers.common['X-User-Data'] = JSON.stringify(this.user);
            axios.get(`/api/documento`)
                .then(response => {
                    this.documents = response.data;
                    this.table();
                }).catch(error => {
                    console.log(error);
                });
        },
        adddocument() {
            this.title = 'Agregar Documento';
            this.inputlist = [
                {
                    label: '',
                    type: 'hidden',
                    name: '_token',
                    value: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                {
                    label: 'Titulo',
                    type: 'text',
                    name: 'title',
                    placeholder: 'Titulo',
                    floating: true,
                },
                {
                    label: 'Archivo',
                    type: 'file',
                    name: 'archivo',
                    placeholder: 'Seleccionar Archivo',
                },
                {
                    label: 'Categoría',
                    type: 'select',
                    name: 'id_categoria',
                    placeholder: 'Seleccionar Categoría',
                    floating: true,
                    options: this.doccat,
                    value: this.doccat[0].value,
                },
                {
                    type: 'submit',
                    name: 'Agregar',
                    btn: 'true'
                }
            ];
            this.functionality = this.adddocu;
            this.showModal = true;
        },
        editdoc(item) {
            this.title = 'Editar Documento';
            this.inputlist = []
            this.functionality = this.edit;
            this.showModal = true;
        },
        deletedoc(item) {
            this.title = 'Eliminar Documento';
            this.inputlist = []
            this.functionality = this.delete;
            this.showModal = true;
        },
        adddocu(form) {
            axios.post(`/api/documento`, form,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    this.$swal({
                        title: '¡Éxito!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                    this.getAllDocuments();
                }).catch(error => {
                    this.$swal({
                        title: '¡Error!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                });
            this.showModal = false;
        }
    },
    mounted() {
        this.getAllDocuments();
        axios.get(`/api/categoria/transparent`)
            .then(response => {
                this.doccat = response.data.map
                    (item => {
                        return {
                            value: item.id_categoria,
                            label: item.nombre_categoria
                        }
                    }
                    );
            }).catch(error => {
                console.log(error);
            });
    }
}
</script>

<style></style>
