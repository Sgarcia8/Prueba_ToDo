<template>
    <body>
        <div class="container">
            <input type="checkbox" id="register_toggle">
            <div class="slider">
                <!-- Login Form -->
                <form class="form" @submit.prevent="loginUser">
                    <span class="title">Login</span>
                    <div class="form_control">
                        <input v-model="email" type="email" class="input" id="email" required>
                        <label class="label">Email</label>
                    </div>
                    <div class="form_control">
                        <input v-model="password" type="password" class="input" id="password" required>
                        <label class="label">Password</label>
                    </div>
                    <button type="submit" class="buttonSub">Login</button>
                    <span class="bottom_text">Don't have an account?
                        <router-link class="switch" to="/register">Sign Up</router-link>
                    </span>
                </form>
            </div>
        </div>
    </body>
</template>
<script>
import { login } from '../../api/auth'; // Importar la función de logeo

export default {
    data() {
        return {
            email: '',
            password: '',
            error: ''
        };
    },
    methods: {
        async loginUser() {
            try {
                const userData = {
                    email: this.email,
                    password: this.password,
                }
                const response = await login(userData);// Llamar a la función de login
                localStorage.setItem('token', response.token); //Guara en el local storage el token de acceso
                this.$router.push('/dashboard'); // Redirige a la página principal después del login
            } catch (err) {
                this.error = 'Login failed. Please check your credentials.';
            }
        },
    },
};
</script>


<style src="@/components/login/style.css" scoped></style>