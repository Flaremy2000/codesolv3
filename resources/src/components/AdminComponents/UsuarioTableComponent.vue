<template>
    <button class="btn btn-success" @click="nuevosusuarios">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle"
            viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
            <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
        </svg>
        Agregar Usuarios</button>
    <table id="userstable" class="table table-hover table-striped" width="100%" ref="usertable">
        <thead>
            <tr>
                <th class="text-center">MANZANA</th>
                <th class="text-center">VILLA</th>
                <th class="text-center">CEDULA</th>
                <th class="text-center">NOMBRES</th>
                <th class="text-center">APELLIDOS</th>
                <th class="text-center">ROL</th>
                <th class="text-center">ESTADO</th>
                <th class="text-center">SOCIO</th>
                <th class="text-center">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in usuarios" :key="item.id_user" :class="item.status == 0 ? 'table-danger' : 'table-success'">
                <td class="text-center">{{ item.mv.substring(0, 4) }}</td>
                <td class="text-center">
                    {{ item.mv.substring(4, item.mv.length).length > 0 ? item.mv.substring(4, item.mv.length) : "VILLA" }}
                </td>
                <td class="text-center">{{ item.cedula }}</td>
                <td class="text-center">{{ item.name }}</td>
                <td class="text-center">{{ item.lastname }}</td>
                <td class="text-center">{{ item.role === 0 ? 'ADMINISTRADOR' : 'PROPIETARIO' }}</td>
                <td class="text-center">{{ item.is_online === 1 ? 'EN LINEA' : 'FUERA DE LINEA' }}</td>
                <td class="text-center">{{ item.is_socio === 1 ? 'SI' : 'NO' }}</td>
                <td class="text-center">
                    <button :id="'eddir' + item.id_user" class="btn btn-primary" @click="edituser(item)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil" viewBox="0 0 16 16">
                            <path
                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg></button>
                    <button :id="'eldir' + item.id_user" class="btn btn-danger ms-2" @click="deleteuser(item)">
                        <svg v-if="item.status == 0" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-caret-up" viewBox="0 0 16 16">
                            <path
                                d="M3.204 11h9.592L8 5.519 3.204 11zm-.753-.659 4.796-5.48a1 1 0 0 1 1.506 0l4.796 5.48c.566.647.106 1.659-.753 1.659H3.204a1 1 0 0 1-.753-1.659z" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
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
    name: 'UsuarioTableComponent',
    components: { ModalB5, DataTable },
    data() {
        return {
            usuarios: [],
            showModal: false,
            title: '',
            inputlist: [],
            id_usermodification: null,
            functionality: null,
        }
    },
    methods: {
        table() {
            this.$nextTick(() => {
                $("#userstable").DataTable();
            })
        },
        alluser() {
            axios.get('/api/user')
                .then((response) => {
                    this.usuarios = response.data;
                    this.table();
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        nuevosusuarios() {
            this.showModal = true;
            this.title = 'Agregar Usuarios';
            this.inputlist = [
                {
                    label: '',
                    type: 'hidden',
                    name: '_token',
                    placeholder: '',
                    floating: false,
                    btn: false,
                    value: document.head.querySelector('meta[name="csrf-token"]').content
                }, {
                    label: 'Adjunte documento en .csv',
                    type: 'file',
                    name: 'document',
                    placeholder: 'Documentos',
                    floating: false,
                    btn: false,
                    value: null
                },
                {
                    label: '',
                    type: 'submit',
                    name: 'Agregar',
                    placeholder: '',
                    floating: false,
                    btn: true,
                    value: null
                }
            ];
            this.functionality = this.adduser;
        },
        edituser(userdata) {
            this.showModal = true;
            this.title = 'Editar Usuario';
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
                }, {
                    label: 'Cedula',
                    type: 'text',
                    name: 'cedula',
                    placeholder: 'cedula',
                    floating: true,
                    btn: false,
                    value: userdata.cedula
                }, {
                    label: 'Nombre',
                    type: 'text',
                    name: 'name',
                    placeholder: 'Nombre',
                    floating: true,
                    btn: false,
                    value: userdata.name
                }, {
                    label: 'Apellido',
                    type: 'text',
                    name: 'lastname',
                    placeholder: 'Apellido',
                    floating: true,
                    btn: false,
                    value: userdata.lastname
                },
                {
                    label: 'Telefono',
                    type: 'number',
                    name: 'phone',
                    placeholder: 'Phone',
                    floating: true,
                    btn: false,
                    value: userdata.phone
                },
                {
                    label: 'Telefono de Emergencia',
                    type: 'number',
                    name: 'emergency',
                    placeholder: 'Emergency Phone',
                    floating: true,
                    btn: false,
                    value: userdata.emergency_phone
                },
                {
                    label: 'Correo',
                    type: 'email',
                    name: 'email',
                    placeholder: 'Correo',
                    floating: true,
                    btn: false,
                    value: userdata.email
                },
                {
                    label: 'Contraseña',
                    type: 'password',
                    name: 'new_password',
                    placeholder: 'Contraseña',
                    floating: true,
                    btn: false,
                    value: null
                },
                {
                    label: 'Rol',
                    type: 'select',
                    name: 'role',
                    placeholder: 'Rol',
                    floating: true,
                    btn: false,
                    options: [
                        {
                            value: '0',
                            label: 'Administrador'
                        }, {
                            value: '1',
                            label: 'Propietario'
                        }
                    ],
                    value: userdata.role
                }, {
                    label: '',
                    type: 'submit',
                    name: 'Editar',
                    placeholder: '',
                    floating: false,
                    btn: true,
                    value: null
                }
            ];
            this.id_usermodification = userdata.mv;
            this.functionality = this.updateuser;
        },
        deleteuser(userdata) {
            this.showModal = true;
            this.title = 'Eliminar Usuario';
            if (userdata.status == 0) {
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
                        label: '¿Estas seguro de reactivar este usuario?',
                        type: null,
                        placeholder: null,
                        floating: false,
                        btn: false,
                        value: null
                    },
                    {
                        label: '',
                        type: 'hidden',
                        name: 'status',
                        placeholder: '',
                        floating: false,
                        btn: false,
                        value: 1
                    },
                    {
                        label: '',
                        type: 'submit',
                        name: 'Activar',
                        placeholder: '',
                        floating: false,
                        btn: true,
                        value: null
                    }
                ];
            } else {
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
                        label: '¿Estas seguro de eliminar este usuario?',
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
                        name: 'status',
                        placeholder: '',
                        floating: false,
                        btn: false,
                        value: 0
                    },
                    {
                        label: '',
                        type: 'submit',
                        name: 'Eliminar',
                        placeholder: '',
                        floating: false,
                        btn: true,
                        value: null
                    }
                ];
            }

            this.id_usermodification = userdata.mv;
            this.functionality = this.deleteusere;
        },
        adduser(form) {
            axios.post('/api/user', form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    this.$swal({
                        title: 'Exito!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'Cool'
                    });
                    this.alluser();
                })
                .catch((error) => {
                    this.$swal({
                        title: 'Error!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Cool'
                    });
                })
            this.showModal = false;
        },
        updateuser(form) {
            axios.post(`/api/user/${this.id_usermodification}`, form)
                .then((response) => {
                    this.$swal({
                        title: 'Exito!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    });
                    this.alluser();
                })
                .catch((error) => {
                    this.$swal({
                        title: 'Error!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    console.log(error);
                })
            this.showModal = false;
        },
        deleteusere(form) {
            axios.post(`/api/user/${this.id_usermodification}`, form)
                .then((response) => {
                    this.$swal({
                        title: 'Exito!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    });
                    this.alluser();
                })
                .catch((error) => {
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
        this.alluser();
    }
}
</script>
