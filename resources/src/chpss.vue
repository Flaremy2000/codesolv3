<template>
    <div class="my-5">
        <h1 class="mt-5 pt-3 text-center">Nueva contraseña</h1>
        <!-- Add the logo image in the center the page-->
        <div class="row justify-content-center">
            <div class="col-3 text-center">
                <img src="/images/logo.svg" width="150" height="150" class="img-fluid text-center" alt="Responsive image">
            </div>
            <form @submit.prevent="sendnewpass" class="col-10">
                <!-- Center inputs -->
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="position-relative form-floating mt-3">
                            <input :type="passwordFieldType" class="form-control" id="floatingPassword"
                                placeholder="Password" v-model="password">
                            <label for="floatingPassword">Contraseña</label>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" @click="togglePasswordVisibility">
                                    <div class="nopssshow" v-if="passwordFieldType === 'password'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-eye-slash" viewBox="0 0 16 16">
                                            <path
                                                d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z" />
                                            <path
                                                d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z" />
                                            <path
                                                d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z" />
                                        </svg>
                                    </div>
                                    <div class="sipssshow" v-else>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                        </svg>
                                    </div>
                                </button>
                            </span>
                        </div>
                        <div class="form-floating mt-3">
                            <input :type="passwordFieldType" class="form-control" id="rptfloatingpassword"
                                placeholder="Password" v-model="rptpassword">
                            <label for="rptfloatingpassword">Repetir Contraseña</label>
                        </div>
                        <div class="text-center my-3">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name: "chpss",
    data() {
        return {
            password: '',
            rptpassword: '',
            showPassword: false,
            showRptPassword: false
        }
    },
    methods: {
        sendnewpass() {
            // Validate if the passwords are the same and if the password is not empty and length is greater than 8 and have uppercase, lowercase and numbers
            if (this.password != '' && this.password.length >= 8 && this.password.match(/[a-z]/) && this.password.match(
                /[A-Z]/) && this.password.match(/[0-9]/)) {
                if (this.rptpassword != '' && this.rptpassword.length >= 8 && this.rptpassword.match(/[a-z]/) && this.rptpassword.match(
                    /[A-Z]/) && this.rptpassword.match(/[0-9]/)) {
                    if (this.password === this.rptpassword) {
                        const url = window.location.href;
                        const id = url.substring(url.lastIndexOf('/') + 1);
                        axios.post('/newpass', {
                            id_user: id,
                            password: this.password
                        }).then(response => {
                            if (response.status === 200) {
                                this.$swal({
                                    title: 'Contraseña cambiada',
                                    html: response.data.message + ' <br> Acepte para iniciar sesión',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '/';
                                    }
                                })
                            }
                        }).catch(error => {
                            console.log(error)
                        })
                    } else {
                        // Add sweetalert2 to show the message
                        this.$swal({
                            title: 'Las contraseñas no coinciden',
                            html: 'Las contraseñas no coinciden, por favor verifique y vuelva a intentar',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Set focus on the password input
                                setTimeout(() => {
                                    document.getElementById('floatingPassword').focus()
                                }, 300);
                            }
                        })
                    }
                } else {
                    // Add sweetalert2 to show the message Debe repetir la contraseña
                    this.$swal({
                        title: 'Repetir contraseña',
                        html: 'Debe repetir la contraseña',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Set focus on the password input
                            setTimeout(() => {
                                document.getElementById('rptfloatingpassword').focus()
                            }, 300);
                        }
                    })
                }
            } else {
                // Add sweetalert2 to show the message Debe ingresar una contraseña
                this.$swal({
                    title: 'Nueva contraseña',
                    html: 'Debe ingresar una contraseña de al menos 8 caracteres con mayúsculas, minúsculas y números',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Set focus on the password input
                        setTimeout(() => {
                            document.getElementById('floatingPassword').focus()
                        }, 300);
                    }
                })
            }
        }, togglePasswordVisibility() {
            this.showPassword = !this.showPassword
        }, toggleRptPasswordVisibility() {
            this.showRptPassword = !this.showRptPassword
        }
    }, computed: {
        passwordFieldType() {
            return this.showPassword ? 'text' : 'password'
        }
    }, mounted() {
        // Set focus on the password input
        setTimeout(() => {
            document.getElementById('floatingPassword').focus()
        }, 300);
    }

}
</script>

<style scoped>
.input-group-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background-color: transparent;
    border: none;
    outline: none;
    cursor: pointer;
}
</style>
