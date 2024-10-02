import axios from 'axios';

const URIBASE = '/api/note';

export const createNote = async (note) => {
    try {
        // Configura Axios para usar el token
        const token = localStorage.getItem('token');
        if (token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        const response = await axios.post(URIBASE, note);
        return response.data;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during registration.');
    }
};

export const searchNotes = async () => {
    try {
        // Configura Axios para usar el token
        const token = localStorage.getItem('token');
        if (token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        const response = await axios.get(URIBASE);
        return response.data;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during search.');
    }
};

export const deleteNote = async (noteId) =>{
    try {
        // Configura Axios para usar el token
        const token = localStorage.getItem('token');
        if (token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        const response = await axios.delete(URIBASE+`/${noteId}`);
        return response.data;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during elimination.');
    }
}