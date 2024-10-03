import axios from 'axios';

export const register = async (userData) => {
    try {
        const response = await axios.post('/api/register', userData); //Hace la solicitud al backend para registrar a un usuario
        return response.data;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during registration.');
    }
};

export const login = async (credentials) => {
    try {
        const response = await axios.post('/api/login', credentials); //Hace la solicitud al backend para logear a un usuario
        return response.data;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during login.');
    }
};

export const logout = async () => {
    try {
        // Configura Axios para usar el token
        const token = localStorage.getItem('token');
        if (token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`; //agrega a la cabecera de la solicitud el token del usuario logeado
        }
        const response = await axios.post('/api/logout'); //Hace la solicitud al backend para deslogear al usuario autentificado
        return response;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during logout.');
    }
}

