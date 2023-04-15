<template>
    <PeriodoSelect @periodoSeleccionado="selecion" class="mb-2 pb-3 border-bottom" />
    <button type="button" class="btn btn-success mb-2" @click="addmember">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle"
            viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
            <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
        </svg>
        Agregar
    </button>
    <table id="tabledirectorio" class="table table-hover table-striped" width="100%" ref="myTable">
        <thead>
            <tr>
                <th class="text-center">NOMBRE</th>
                <th class="text-center">CARGO</th>
                <th class="text-center">COMISION</th>
                <th class="text-center">ESTADO</th>
                <th class="text-center">ACCIONES</th>
            </tr>
        </thead>
        <tbody v-if="directorios.length > 0" class="text-center">
            <tr v-for="item in directorios" :key="item.id_directorio">
                <td>{{ item.nombre_directorio + ' ' + item.apellido_directorio }}</td>
                <td>{{ item.cargo.nombre_cargo }}</td>
                <td>{{ item.comision.nombre_comision }}</td>
                <td v-if="item.estado_directorio === 1">ACTIVO</td>
                <td v-else>INACTIVO</td>
                <td class="text-center">
                    <button :id="'eddir' + item.id_directorio" class="btn btn-primary" @click="editdirectory(item)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil" viewBox="0 0 16 16">
                            <path
                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg></button>
                    <button :id="'eldir' + item.id_directorio" class="btn btn-danger ms-2" @click="deletedirectory(item)">
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
        <tbody v-else>
            <tr>
                <td colspan="5" rowspan="2" class="text-center">No hay miembros en este periodo</td>
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
import PeriodoSelect from '../../components/PeriodoSelect.vue';

DataTable.use(DataTablesCore);
export default {
    name: "DirectoryTableComponent",
    components: { PeriodoSelect, DataTable, ModalB5 },
    data() {
        return {
            seleccionados: '',
            directorios: [],
            showModal: false,
            title: '',
            inputlist: [],
            comisionlist: [],
            cargolist: [],
            periodoslist: [],
            functionality: null,
        };
    }, mounted() {
        axios.get('/api/comision')
            .then(response => {
                for (let i = 0; i < response.data.length; i++) {
                    this.comisionlist.push({
                        value: response.data[i].id_comision,
                        label: response.data[i].nombre_comision
                    });
                }
            }).catch(error => {
                console.log(error);
            });
        axios.get('/api/cargo')
            .then(response => {
                for (let i = 0; i < response.data.length; i++) {
                    this.cargolist.push({
                        value: response.data[i].id_cargo,
                        label: response.data[i].nombre_cargo
                    });
                }
            }).catch(error => {
                console.log(error);
            });
        axios.get('/api/periodos')
            .then(response => {
                for (let i = 0; i < response.data.length; i++) {
                    this.periodoslist.push({
                        value: response.data[i].id_periodo,
                        label: response.data[i].fecha_inicio + ' - ' + response.data[i].fecha_fin
                    });
                }
            }).catch(error => {
                console.log(error);
            });

    }, methods: {
        table() {
            this.$nextTick(() => {
                $("#tabledirectorio").DataTable();
            })
        },
        selecion(seleccionados) {
            axios.get('/api/directorio/' + seleccionados)
                .then(response => {
                    this.directorios = response.data;
                    this.table();
                    this.seleccionados = seleccionados;
                }).catch(error => {
                    console.log(error);
                });
        },
        editdirectory(item) {
            this.showModal = true;
            this.title = 'Editar Directorio';
            this.inputlist = [
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
                    label: 'Nombre del Directorio',
                    type: 'text',
                    name: 'directory_name',
                    placeholder: 'Nombre del Directorio',
                    floating: true,
                    btn: false,
                    value: item.nombre_directorio
                },
                {
                    label: 'Apellido del Directorio',
                    type: 'text',
                    name: 'directory_lastname',
                    placeholder: 'Apellido del Directorio',
                    floating: true,
                    btn: false,
                    value: item.apellido_directorio
                },
                {
                    label: 'Imagen',
                    type: 'file',
                    name: 'Imagen',
                    placeholder: 'Imagen',
                    floating: false,
                    btn: false,
                    value: null
                },
                {
                    label: 'Cargo',
                    type: 'select',
                    name: 'cargo',
                    placeholder: 'Cargo',
                    floating: true,
                    btn: false,
                    value: item.cargo_directorio,
                    options: this.cargolist
                },
                {
                    label: 'Comisiones',
                    type: 'select',
                    name: 'comisiones',
                    placeholder: 'comision',
                    floating: true,
                    btn: false,
                    value: item.comision_directorio,
                    options: this.comisionlist
                },
                {
                    label: 'Periodo',
                    type: 'select',
                    name: 'periodo',
                    placeholder: 'periodo',
                    floating: true,
                    btn: false,
                    value: item.periodo_directorio,
                    options: this.periodoslist
                },
                {
                    label: '',
                    type: 'hidden',
                    name: 'id_directorio',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: item.id_directorio
                },
                {
                    label: '',
                    type: 'hidden',
                    name: 'oldImage',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: item.imagen_directorio
                },
                {
                    label: '',
                    type: 'submit',
                    name: 'Editar',
                    placeholder: '',
                    floating: false,
                    btn: true,
                    value: null
                }];
            this.functionality = this.editdatosdirectory;
        },
        deletedirectory(item) {
            this.showModal = true;
            this.title = 'Eliminar Directorio';
            this.inputlist = [
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
                    label: '¿Estas seguro de eliminar este miembro del directorio?',
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
                    name: 'id_directorio',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: item.id_directorio
                },
                {
                    label: '',
                    type: 'hidden',
                    name: 'image_old',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: item.imagen_directorio
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
            this.functionality = this.deletedatosdirectory;
        },
        editdatosdirectory(form) {
            axios.post(`/api/directorio/${form.get('id_directorio')}`, form, {
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
                    this.selecion(this.seleccionados);
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
        }, deletedatosdirectory(form) {
            axios.post(`/api/directorio/${form.get('id_directorio')}`, form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    this.$swal({
                        title: 'Exito!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'Cool'
                    });
                    this.selecion(this.seleccionados);
                })
                .catch(error => {
                    this.$swal({
                        title: 'Error!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Cool'
                    });
                })
        },
        addmember() {
            this.showModal = true;
            this.title = 'Agregar Directorio';
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
                    label: 'Nombre del Directorio',
                    type: 'text',
                    name: 'directory_name',
                    placeholder: 'Nombre del Directorio',
                    floating: true,
                    btn: false,
                    value: null
                },
                {
                    label: 'Apellido del Directorio',
                    type: 'text',
                    name: 'directory_lastname',
                    placeholder: 'Apellido del Directorio',
                    floating: true,
                    btn: false,
                    value: null
                },
                {
                    label: 'Imagen',
                    type: 'file',
                    name: 'Imagen',
                    placeholder: 'Imagen',
                    floating: false,
                    btn: false,
                    value: null
                },
                {
                    label: 'Cargo',
                    type: 'select',
                    name: 'cargo',
                    placeholder: 'Cargo',
                    floating: true,
                    btn: false,
                    value: 1,
                    options: this.cargolist
                },
                {
                    label: 'Comisiones',
                    type: 'select',
                    name: 'comisiones',
                    placeholder: 'comision',
                    floating: true,
                    btn: false,
                    value: 1,
                    options: this.comisionlist
                },
                {
                    label: 'Periodo',
                    type: 'select',
                    name: 'periodo',
                    placeholder: 'periodo',
                    floating: true,
                    btn: false,
                    value: 1,
                    options: this.periodoslist
                },
                {
                    label: '',
                    type: 'submit',
                    name: 'Agregar',
                    placeholder: '',
                    floating: false,
                    btn: true,
                    value: null
                }];
            this.functionality = this.adddatosdirectory;
        },
        adddatosdirectory(form) {
            axios.post(`/api/directorio`, form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    this.$swal({
                        title: 'Exito!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'Cool'
                    });
                    this.selecion(this.seleccionados);
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
        }
    },

}
</script>
