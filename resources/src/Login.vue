<template>
    <div class="logincontainer">
        <button v-if="user.length <= 0" class="btn btn-outline-primary" data-bs-toggle="modal" @click="loguinuser">
            Iniciar sesión
        </button>
        <li v-else class="dropstart nav-item dropdown">
            <a type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                {{ user.lastname }}
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" @click="edituser">
                        Perfil
                    </a>
                </li>
                <li><a class="dropdown-item" @click="changepassword">
                        Contraseña
                    </a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" @click="logout">Cerrar Sesion</a></li>
            </ul>
        </li>
    </div>
    <ModalB5 :title="title" :fields="inputslist" :ejectfunction="funtionality" v-if="showModal" @close="showModal = false">
    </ModalB5>
</template>
<script>
import axios from 'axios';
import ModalB5 from './ModalB5.vue';

export default {
    name: 'Login',
    components: {
        ModalB5,
    },
    data() {
        return {
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            user: [],
            errorMessage: '',
            title: '',
            inputslist: [],
            funtionality: null,
            showModal: false,
        }
    },
    methods: {
        loguinuser() {
            this.title = 'Iniciar sesión';
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
                    label: 'Manzana-Villa',
                    type: 'text',
                    name: 'username',
                    placeholder: '200001',
                    floating: true
                },
                {
                    label: 'Contraseña',
                    type: 'password',
                    name: 'password',
                    placeholder: 'Password',
                    floating: true,
                },
                {
                    type: 'submit',
                    name: 'Enviar',
                    placeholder: '',
                    floating: false,
                    btn: true,
                }
            ];
            this.funtionality = this.login;
            this.showModal = true;
        },
        login(form) {
            axios.post('/login', form)
                .then(response => {
                    if (response.status === 200) {
                        if (response.data.redirect) {
                            window.location.href = response.data.redirect + '/' + response.data.id_user;
                        } else {
                            document.cookie = `laravel_session=${JSON.stringify(response.data.user)}; path=/`;
                            this.user = response.data.user;
                            localStorage.setItem('user', JSON.stringify(this.user));
                            location.reload();
                            this.showModal = false;
                            this.errorMessage = '';
                        }
                    }
                })
                .catch(error => {
                    console.error(error);
                    this.errorMessage = error.response.data.message;
                });
        }, edituser() {
            this.title = 'Editar Perfil';
            this.funtionality = this.updateuser;
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
                    label: 'Cedula',
                    type: 'text',
                    name: 'cedula',
                    placeholder: '0994321234',
                    floating: true,
                    value: this.user.cedula
                },
                {
                    label: 'Nombre',
                    type: 'text',
                    name: 'name',
                    placeholder: 'Nombre',
                    floating: true,
                    value: this.user.name
                },
                {
                    label: 'Apellido',
                    type: 'text',
                    name: 'lastname',
                    placeholder: 'Apellido',
                    floating: true,
                    value: this.user.lastname
                },
                {
                    label: 'Telefono',
                    type: 'text',
                    name: 'phone',
                    placeholder: '0994321234',
                    floating: true,
                    value: this.user.phone
                },
                {
                    label: 'Emergencia',
                    type: 'text',
                    name: 'emergency',
                    placeholder: '0994321234',
                    floating: true,
                    value: this.user.emergency_phone
                },
                {
                    label: 'Correo',
                    type: 'text',
                    name: 'email',
                    placeholder: 'Correo',
                    floating: true,
                    value: this.user.email
                },
                {
                    type: 'submit',
                    name: 'Actualizar',
                    btn: true,
                }
            ]
            this.showModal = true;
        }, updateuser(form) {
            axios.defaults.headers.common['X-User-Data'] = JSON.stringify(this.user);
            axios.post('/api/user/' + this.user.mv, form)
                .then(response => {
                    if (response.status === 200) {
                        this.user = response.data.user;
                        localStorage.setItem('user', JSON.stringify(this.user));
                        this.errorMessage = '';
                        this.showModal = false;
                        this.$swal({
                            title: 'Actualizado!',
                            text: response.data.success,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        })
                    }
                })
                .catch(error => {
                    console.error(error);
                    this.errorMessage = error.response.data.message;
                });
        },
        logout() {
            axios.defaults.headers.common['X-User-Data'] = JSON.stringify(this.user);
            axios.post('/logout')
                .then(response => {
                    if (response.status === 200) {
                        this.user = [];
                        localStorage.removeItem('user');
                        localStorage.clear();
                        location.reload();
                        console.log(response.message);
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        },
        changepassword() {
            // Redirect to change password
            window.location.href = '/cambiar_contraseña/' + this.user.id_user;
        }
    },
    mounted() {
        if (localStorage.getItem('user') !== null && localStorage.getItem('user') !== undefined) {
            this.user = JSON.parse(localStorage.getItem('user'));
        }
    }
}
</script>
