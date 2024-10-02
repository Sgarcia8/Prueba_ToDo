<template>
    <div class="register-container">
        <h1>Register</h1>
        <form @submit.prevent="submitForm">
            <div>
                <label for="name">Name</label>
                <input v-model="name" type="text" id="name" required />
            </div>
            <div>
                <label for="email">Email</label>
                <input v-model="email" type="email" id="email" required />
            </div>
            <div>
                <label for="password">Password</label>
                <input v-model="password" type="password" id="password" required />
            </div>
            <div>
                <label for="password_confirmation">Confirm Password</label>
                <input v-model="password_confirmation" type="password" id="password_confirmation" required />
            </div>
            <button type="submit">Register</button>
            <router-link class="link" to="/">home</router-link>
        </form>
        <div v-if="errorMessage">
            <p style="color: red">{{ errorMessage }}</p>
        </div>
    </div>
</template>

<script>
import { register } from '../api/auth'; // Importar la función de registro

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errorMessage: ''
        };
    },
    methods: {
        async submitForm() {
            try {
                const userData = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                };
                await register(userData); // Llamar a la función de registro
                this.$router.push('/'); // Redirigir al login después de registrar
            } catch (error) {
                this.errorMessage = error.message; // Mostrar el mensaje de error
            }
        }
    }
};
</script>

<style scoped>
/* Aquí puedes agregar tus estilos personalizados */
.register-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #5c6bc0;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #3f51b5;
}
</style>