<template>

    <body>
        <div class="container">
            <input type="checkbox" id="register_toggle">
            <div class="slider">
                <form @submit.prevent="submitForm" class="form">
                    <span class="title">Register</span>
                    <div class="form_control">
                        <input v-model="name" type="text" id="name" class="input" required />
                        <label for="name" class="label">Name</label>
                    </div>
                    <div class="form_control">
                        <input v-model="email" type="email" id="email" class="input" required />
                        <label for="email" class="label">Email</label>
                    </div>
                    <div class="form_control">
                        <input v-model="password" type="password" id="password" class="input" required />
                        <label for="password" class="label">Password</label>
                    </div>
                    <div class="form_control">
                        <input v-model="password_confirmation" type="password" id="password_confirmation" class="input"
                            required />
                        <label for="password_confirmation" class="label">Confirm Password</label>
                    </div>
                    <button type="submit" class="buttonSub">Register</button>
                    <span class="bottom_text">
                        Already have an account?
                        <router-link class="swtich" to="/">Home</router-link>
                    </span>
                </form>

                <div v-if="errorMessage" style="color: red; margin-top: 1em;">
                    <p>{{ errorMessage }}</p>
                </div>
            </div>
        </div>
    </body>

</template>

<script>
import { register } from '../../api/auth'; // Importar la función de registro

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

<style src="@/components/login/style.css" scoped></style>