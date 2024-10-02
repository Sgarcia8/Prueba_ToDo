<template>
    <div class="login">
        <h2>Login</h2>
        <form @submit.prevent="loginUser">
            <div>
                <label for="email">Email</label>
                <input v-model="email" type="email" id="email" required />
            </div>
            <div>
                <label for="password">Password</label>
                <input v-model="password" type="password" id="password" required />
            </div>
            <button type="submit">Login</button>
            <router-link class="link" to="/register">register</router-link>
        </form>
        

        <div v-if="error" class="error">
            <p>{{ error }}</p>
        </div>
    </div>
</template>

<script>
import {login} from '../api/auth'; // Importar la función de logeo

export default {
    data() {
        return {
            email: '',
            password: '',
            error: null,
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
                // Manejar la autenticación aquí (almacenar token, redireccionar, etc.)
                localStorage.setItem('token', response.token);
                this.$router.push('/dashboard'); // Redirige a la página principal después del login
            } catch (err) {
                this.error = 'Login failed. Please check your credentials.';
            }
        },
    },
};
</script>

<style scoped>
/* Aquí puedes agregar estilos personalizados para tu componente */
.login {
    max-width: 400px;
    margin: 0 auto;
}

.error {
    color: red;
    margin-top: 10px;
}
</style>