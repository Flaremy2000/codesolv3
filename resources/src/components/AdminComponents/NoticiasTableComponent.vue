<template>
    <button class="btn btn-success" @click="addnot">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle"
            viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
            <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
        </svg>
        Agregar Noticia</button>
    <table id="noticiastable" class="table table-hover table-striped" width="100%" ref="newstable">
        <thead>
            <tr>
                <th class="text-center">TITULO</th>
                <th class="text-center">CONTENIDO</th>
                <th class="text-center">FECHA</th>
                <th class="text-center">ACCIONES</th>
            </tr>
        </thead>
        <tbody v-if="noticias" class="text-center">
            <tr v-for="item in noticias" :key="item.id_noticia">
                <td class="text-center">{{ item.titulo }}
                </td>
                <td class="text-center">
                    {{ item.texto_largo && item.texto_largo.length > 10 ? item.texto_largo.substring(0, 40) + '...' : '' }}
                </td>
                <td class="text-center">{{ item.fecha }}
                </td>
                <td class="text-center">
                    <button :id="'eddir' + item.id_noticia" class="btn btn-primary" @click="editnot(item)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil" viewBox="0 0 16 16">
                            <path
                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg></button>
                    <button :id="'eldir' + item.id_noticia" class="btn btn-danger ms-2" @click="deletenot(item)">
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
        <tbody v-else>
            <tr>
                <td colspan="4" class="text-center">No hay datos</td>
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
    name: 'NoticiasTableComponent',
    components: {
        DataTable,
        ModalB5
    },
    data() {
        return {
            noticias: [],
            showModal: false,
            inputlist: [],
            title: null,
            functionality: null,
            id_not: null,
            notcat: []
        }
    },
    methods: {
        table() {
            this.$nextTick(() => {
                $('#noticiastable').DataTable();
            });
        },
        getallnot() {
            axios.get('/allnews')
                .then(response => {
                    this.noticias = response.data;
                    this.table();
                })
                .catch(error => {
                    console.log(error)
                })
        },
        addnot() {
            this.showModal = true;
            this.title = 'Agregar Noticia';
            this.inputlist = [
                {
                    label: '',
                    type: 'hidden',
                    name: '_token',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: document.head.querySelector('meta[name="csrf-token"]').content
                },
                {
                    label: 'Titulo',
                    type: 'text',
                    name: 'title',
                    placeholder: 'Titulo',
                    floating: true,

                },
                {
                    label: 'Contenido',
                    type: 'textarea',
                    name: 'texto_largo',
                    placeholder: 'Contenido',
                    floating: true,
                },
                {
                    label: 'Fecha',
                    type: 'date',
                    name: 'fecha',
                    placeholder: 'Fecha',
                    floating: true,
                },
                {
                    label: 'Imagen',
                    type: 'file',
                    name: 'imagen',
                    placeholder: 'Imagen',
                },
                {
                    label: 'Archivo',
                    type: 'file',
                    name: 'archivo',
                    placeholder: 'Archivo',
                },
                {
                    label: 'Categoria',
                    type: 'select',
                    name: 'notcategory',
                    placeholder: 'Categoria',
                    floating: true,
                    options: this.notcat,
                    value: this.notcat[0].value
                },
                {
                    type: 'submit',
                    name: 'Agregar',
                    btn: true,
                }
            ];
            this.functionality = this.addnotfunction;
        },
        editnot(data) {
            this.showModal = true;
            this.title = 'Editar Noticia';
            this.inputlist = [
                {
                    label: '',
                    type: 'hidden',
                    name: '_token',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: document.head.querySelector('meta[name="csrf-token"]').content
                },
                {
                    label: '',
                    type: 'hidden',
                    name: '_method',
                    value: 'PUT'
                },
                {
                    label: 'Titulo',
                    type: 'text',
                    name: 'title',
                    placeholder: 'Titulo',
                    floating: true,
                    value: data.titulo
                },
                {
                    label: 'Contenido',
                    type: 'text',
                    name: 'texto_largo',
                    placeholder: 'Contenido',
                    floating: true,
                    value: data.texto_largo
                },
                {
                    label: 'Fecha',
                    type: 'date',
                    name: 'fecha',
                    placeholder: 'Fecha',
                    floating: true,
                    value: data.fecha
                },
                {
                    label: 'Imagen',
                    type: 'file',
                    name: 'imagen',
                    placeholder: 'Imagen',
                },
                {
                    label: 'Archivo',
                    type: 'file',
                    name: 'archivo',
                    placeholder: 'Archivo',
                },
                {
                    label: 'Categoria',
                    type: 'select',
                    name: 'notcategory',
                    placeholder: 'Categoria',
                    floating: true,
                    options: this.notcat,
                    value: data.categoria_id
                },
                {
                    type: 'submit',
                    name: 'Editar',
                    btn: true,
                }
            ];
            this.functionality = this.editnotfunction;
            this.id_not = data.id_noticia;
        },
        deletenot(data) {
            this.showModal = true;
            this.title = 'Eliminar Noticia';
            this.inputlist = [
                {
                    label: '',
                    type: 'hidden',
                    name: '_token',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: document.head.querySelector('meta[name="csrf-token"]').content
                },
                {
                    label: '',
                    type: 'hidden',
                    name: '_method',
                    value: 'DELETE'
                },
                {
                    label: '¿Estas seguro de eliminar esta noticia?',
                    type: null,
                    name: 'question',
                },
                {
                    type: 'submit',
                    name: 'Eliminar',
                    btn: true,
                }
            ];
            this.functionality = this.deletenotfunction;
            this.id_not = data.id_noticia;
        },
        addnotfunction(form) {
            axios.post('/api/noticia', form,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    this.$swal({
                        title: 'Noticia agregada',
                        text: response.data.succeso,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                    this.getallnot();
                    this.showModal = false;
                })
                .catch(error => {
                    this.$swal({
                        title: 'Error',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                    console.log(error)
                })
        },
        editnotfunction(form) {
            axios.post(`/api/noticia/${this.id_not}`, form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    this.$swal({
                        title: 'Noticia editada',
                        text: response.data.succeso,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                    this.getallnot();
                })
                .catch(error => {
                    this.$swal({
                        title: 'Error',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                    console.log(error)
                })
            this.showModal = false;
        }, deletenotfunction(form) {
            axios.post(`/api/noticia/${this.id_not}`, form)
                .then(response => {
                    this.$swal({
                        title: 'Noticia eliminada',
                        text: response.data.succeso,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                    this.getallnot();
                })
                .catch(error => {
                    this.$swal({
                        title: 'Error',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                    console.log(error)
                })
            this.showModal = false;
        }
    },
    mounted() {
        this.getallnot();
        axios.get('/api/categoria/news')
            .then(response => {
                this.notcat = response.data.map(item => {
                    return {
                        value: item.id_categoria,
                        label: item.nombre_categoria
                    }
                })
            })
            .catch(error => {
                console.log(error)
            })
    }
}
</script>
