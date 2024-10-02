import axios from 'axios';

export const register = async (userData) => {
    try {
        const response = await axios.post('/api/register', userData);
        return response.data;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during registration.');
    }
};

export const login = async (credentials) => {
    try {
        const response = await axios.post('/api/login', credentials);
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
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        const response = await axios.post('/api/logout');
        return response;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during logout.');
    }
}

