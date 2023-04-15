<template>
    <div class="mb-1">.</div>
    <div class="card mt-5 mb-2">
        <div class="card-header">
            Contáctenos
        </div>
        <div class="card-body">
            <h5 class="card-title">Ahorra tiempo despejando tus dudas</h5>
            <p class="card-text">
                Usa nuestro portal web o por medio de los medios de contacto siguientes:<br>
                Whatsapp: (+593) 967523408<br>
                Convencional: (04) 2017466<br>
                Correo: asociacion.codesol@gmail.com<br>
                Dirección : Kilómetro 12 ½ vía a Daule frente al terminal de Metrovía Bastión Popular, junto al Parque
                Industrial California II<br>
                Descargue nuestra App Codesol a través de la play store <button class="btn btn-link">click aquí</button>
            </p>
        </div>
    </div>
    <div v-if="Object.keys(user).length > 0" class="card my-3">
        <div class="card-header">
            Sugerencia
        </div>
        <div class="card-body">
            <form @submit.prevent="sendsugestion">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nombre</label>
                    <input type="text" class="form-control" placeholder="User name" :value="user.name + ' ' + user.lastname"
                        disabled>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Sugerencia</label>
                    <textarea ref="sugtext" class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="255"
                        v-model="sugerencia"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Contact",
    data() {
        return {
            user: [],
            sugerencia: ''
        };
    }, mounted() {
        // Validate if user exist in localstorage and if exist, get data
        if (localStorage.getItem('user') !== null && localStorage.getItem('user') !== undefined && localStorage.getItem('user') !== '') {
            this.user = JSON.parse(localStorage.getItem('user'));
        }
    },
    methods: {
        sendsugestion() {
            if (this.sugerencia.length > 0) {
                axios.post('/api/sugestion', {
                    id_usuario: this.user.id_user,
                    sugerencia: this.sugerencia
                }).then(response => {
                    if (response.status === 201) {
                        this.$swal({
                            title: 'Sugerencia enviada',
                            text: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                setTimeout(() => {
                                    this.sugerencia = '';
                                    this.$refs.sugtext.focus();
                                }, 500);
                            }
                        });
                    } else {
                        this.$swal({
                            title: 'Error',
                            text: 'No se pudo enviar la sugerencia',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                }).catch(error => {
                    this.$swal({
                        title: 'Error',
                        text: `No se pudo enviar la sugerencia ${error}`,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                });
            } else {
                this.$swal({
                    title: 'Error',
                    text: 'Debes llenar el campo sugerencia',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        setTimeout(() => {
                            this.$refs.sugtext.focus();
                        }, 500);
                    }
                });
            }
        }
    },
}
</script>
