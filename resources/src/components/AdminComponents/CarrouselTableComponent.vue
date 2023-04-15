<template>
    <button class="btn btn-success mb-2" @click="addRow">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle"
            viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
            <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
        </svg>
        Agregar imagen</button><br />
    <table id="tablecarusel" class="table table-hover table-striped" width="100%" ref="carouseltable">
        <thead>
            <tr>
                <th class="text-center">TITULO</th>
                <th class="text-center">UBICACION</th>
                <th class="text-center">ESTADO</th>
                <th class="text-center">ACCIONES</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr v-for="item in tableData" :key="item.carousel_id">
                <td>{{ item.carousel_title }}</td>
                <td v-if="item.estado === 1">ACTIVO</td>
                <td v-else>INACTIVO</td>
                <td>{{ item.carousel_page }}</td>
                <td class="text-center">
                    <button :id="'edcar' + item.carousel_id" class="btn btn-primary" @click="editcarousel(item)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil" viewBox="0 0 16 16">
                            <path
                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg></button>
                    <button :id="'elcar' + item.carousel_id" class="btn btn-danger ms-2" @click="deletecarousel(item)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd"
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                        </svg></button>
                </td>
            </tr>
        </tbody>
    </table>

    <ModalB5 :title="title" :fields="inputslist" :ejectfunction="funtionality" v-if="showModal" @close="showModal = false">
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
    name: 'CarrouselTableComponent',
    components: {
        DataTable, ModalB5
    }, data() {
        return {
            tableData: [],
            title: '',
            showModal: false,
            inputslist: [],
            formudata: {},
            funtionality: null,
            optionsselect: [
                { value: 'home', label: 'Inicio' },
                { value: 'services', label: 'Servicio' }
            ]
        }
    }, methods: {
        table() {
            this.$nextTick(() => {
                $('#tablecarusel').DataTable();
            });
        },
        obtenercarousel() {
            axios.get('/api/carousel')
                .then(response => {
                    // console.log(response.data.map(item => Object.values(item)));
                    this.tableData = response.data
                    this.table();
                })
                .catch(error => {
                    console.log(error);
                })
        },
        editcarousel(datos) {
            this.showModal = true;
            this.title = 'Editar imagen';
            this.inputslist = [
                {
                    label: '',
                    type: 'hidden',
                    name: '_method',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: 'PUT'
                },
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
                    btn: false,
                    value: datos.carousel_title
                },
                {
                    label: 'Pagina',
                    type: 'select',
                    name: 'page',
                    placeholder: 'Pagina',
                    floating: true,
                    btn: false,
                    options: this.optionsselect,
                    value: datos.carousel_page,
                },
                {
                    label: 'Imagen',
                    type: 'file',
                    name: 'Image',
                    placeholder: 'Imagen',
                    floating: false,
                    btn: false,
                    value: null
                },
                {
                    label: '',
                    type: 'hidden',
                    name: 'id_carousel',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: datos.carousel_id
                },
                {
                    label: '',
                    type: 'hidden',
                    name: 'image_carousel_old',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: datos.carousel_image
                },
                {
                    label: '',
                    type: 'hidden',
                    name: 'page_carousel',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: datos.carousel_page
                }, {
                    label: '',
                    type: 'submit',
                    name: 'Guardar',
                    placeholder: '',
                    floating: false,
                    btn: true,
                    value: null
                }
            ];
            this.funtionality = this.editdatoscarrusel;
        },
        deletecarousel(datos) {
            this.showModal = true;
            this.title = 'Editar imagen';
            this.inputslist = [
                {
                    label: '',
                    type: 'hidden',
                    name: '_method',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: 'DELETE'
                },
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
                    label: '¿Estas seguro de eliminar esta imagen?',
                    type: null,
                    name: 'nana',
                    placeholder: null,
                    floating: false,
                    btn: false,
                    value: null
                },
                {
                    label: '',
                    type: 'hidden',
                    name: 'id_carousel',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: datos.carousel_id
                },
                {
                    label: '',
                    type: 'hidden',
                    name: 'image_carousel_old',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: datos.carousel_image
                }, {
                    label: '',
                    type: 'submit',
                    name: 'Eliminar',
                    placeholder: '',
                    floating: false,
                    btn: true,
                    value: null
                }
            ];
            this.funtionality = this.borrardatoscarrusel;
        },
        addRow() {
            this.showModal = true;
            this.title = 'Agregar Imagen';
            this.inputslist = [
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
                    btn: false,
                    value: null
                },
                {
                    label: 'Pagina',
                    type: 'select',
                    name: 'page',
                    placeholder: 'Pagina',
                    floating: true,
                    btn: false,
                    options: this.optionsselect,
                    value: 'home',
                },
                {
                    label: 'Imagen',
                    type: 'file',
                    name: 'Image',
                    placeholder: 'Imagen',
                    floating: false,
                    btn: false,
                    value: null
                }, {
                    label: '',
                    type: 'submit',
                    name: 'Agregar',
                    placeholder: '',
                    floating: false,
                    btn: true,
                    value: null
                }
            ];
            this.funtionality = this.agregardatoscarrusel;
        },
        editdatoscarrusel(form) {
            axios.post(`/api/carousel/${form.get('id_carousel')}`, form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    // console.log(response.data);
                    this.$swal({
                        title: 'Exito!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'Cool'
                    });
                    // this.showalertcustom('Exito', response.data.message, 'success');
                    this.obtenercarousel();
                })
                .catch(error => {
                    this.$swal({
                        title: 'Error!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Cool'
                    });
                })
            this.showModal = false;
        },
        agregardatoscarrusel(form) {
            axios.post(`/api/carousel`, form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    // console.log(response.data);
                    this.$swal({
                        title: 'Exito!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'Cool'
                    });
                    // this.showalertcustom('Exito', response.data.message, 'success');
                    this.obtenercarousel();
                })
                .catch(error => {
                    this.$swal({
                        title: 'Error!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Cool'
                    });
                })
            this.showModal = false;
        },
        borrardatoscarrusel(form) {
            axios.post(`/api/carousel/${form.get('id_carousel')}`, form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    this.$swal({
                        title: 'Exito!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    });
                    this.obtenercarousel();
                })
                .catch(error => {
                    this.$swal({
                        title: 'Error!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                })
            this.showModal = false;
        }
    }, mounted() {
        this.obtenercarousel();
    }
}
</script>
