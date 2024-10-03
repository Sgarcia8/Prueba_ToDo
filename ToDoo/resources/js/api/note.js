import axios from 'axios';

const URIBASE = '/api/note'; // Ruta para las solicitudes

function headerAxios() {
    const token = localStorage.getItem('token');
    if (token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`; //Método para agregar a la cabecera axios el token del usuario autenticado
    }
}


export const createNote = async (note) => {
    try {
        headerAxios(); //agrega el token a la cabecera axios
        const response = await axios.post(URIBASE, note); //hace la solicitud para crear una nueva nota
        return response.data;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during registration.');
    }
};

export const searchNotes = async () => {
    try {
        headerAxios(); //agrega el token a la cabecera axios
        const response = await axios.get(URIBASE); //hace la solicitud para buscar todas la notas del usuario
        return response.data;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during search.');
    }
};

export const deleteNote = async (noteId) => {
    try {
        headerAxios(); //agrega el token a la cabecera axios
        const response = await axios.delete(URIBASE + `/${noteId}`); //hace la solicitud para eliminar una nota en especifico
        return response.data;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during elimination.');
    }
}

export const updateNote = async (noteId,updatedNote) => {
    try {
        headerAxios(); //agrega el token a la cabecera axios
        const response = await axios.put(URIBASE + `/${noteId}`, updatedNote); //hace la solicitud para actualizar una nota
        return response.data;
    } catch (error) {
        throw error.response ? error.response.data : new Error('An error occurred during update.');
    }
}