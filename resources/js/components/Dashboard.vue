<template>

    <body>
        <div class="center">
            <div class="navbar">
                <button @click="logout" class="logout-button">Cerrar Sesión</button>
            </div>
            <div class="dashboard">
                <div class="sidebar">
                    <div class="sidebar-header">
                        <h2>Mis Notas</h2>
                        <div class="sort-options">
                            <label for="sortCriteria">Ordenar por:</label>
                            <select v-model="sortCriteria" @change="sortNotes">
                                <option value="dueDate">Fecha de Vencimiento</option>
                                <option value="createdDate">Fecha de Creación</option>
                            </select>
                        </div>
                        <button @click="showCreateNoteModal = true" class="create-note-button">Nueva Nota</button>
                    </div>
                    <ul>
                        <li v-for="note in notes" :key="note.id" class="note-item" @click="selectNote(note)">
                            <span class="note-title">
                                {{ note.title }}
                            </span>
                            <div class="note-actions">
                                <button @click.stop="editNote(note)" class="edit-note-button">Editar</button>
                                <button @click.stop="deleteNote(note.id)" class="delete-note-button">Eliminar</button>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="main-content">
                    <div v-if="selectedNote">
                        <h2 class="note-title">{{ selectedNote.title }}</h2>
                        <div class="note-description">
                            <p v-if="selectedNote.fecha_vencimiento">Fecha de vencimiento: {{
                                selectedNote.fecha_vencimiento }}</p>
                            <p>Etiquetas: {{ selectedNote.etiquetas }}</p>
                            <p>{{ selectedNote.description }}</p>
                        </div>
                        <img v-if="selectedNote.img_uri" :src="selectedNote.img_uri" alt="Imagen de la nota"
                            class="note-image">
                    </div>
                </div>
            </div>
            <!-- Modal para crear una nueva nota -->
            <CreateNoteModal v-if="showCreateNoteModal" @close="showCreateNoteModal = false"
                @createNote="handleCreateNote" />
            <!-- Modal para editar una nueva nota -->
            <EditNoteModal v-if="showEditNoteModal" :existingNote="selectedNote" @close="showEditNoteModal = false"
                @editNote="handleEditNote" />
        </div>
    </body>
</template>

<script>
import { logout } from '../api/auth';
import { searchNotes, deleteNote } from '../api/note';
import CreateNoteModal from './modal/CreateNoteModal.vue'; // Importar el componente modal
import EditNoteModal from './modal/EditNoteModal.vue';

export default {
    components: {
        CreateNoteModal,
        EditNoteModal,
    },
    data() {
        return {
            showCreateNoteModal: false,
            showEditNoteModal: false, // Controla si el modal está visible
            notes: [], // Lista de notas
            selectedNote: null, // Nota seleccionada
            sortCriteria: 'createdDate', //método de ordenamiento
            newNote: {
                title: '',
                description: '',
                etiquetas: '',
                fecha_vencimiento: '',
                img_uri: '',
            }, // Datos para la nueva nota
        };
    },
    methods: {
        async fetchNotes() {
            try {
                const response = await searchNotes(); //llama la función para hacer la busqueda de las notas cada que un usuario se logea
                this.notes = response;
            } catch (error) {
                this.error = 'Search error. Please try again.';
            }
        },
        selectNote(note) {
            this.selectedNote = note;
        },
        async logout() {
            try {
                const response = await logout(); //LLama la función de logout y elimina los tokens de acceso de la base de datos
                this.$router.push('/'); // Redirige a al login
            } catch (error) {
                this.error = 'Logout error. Please try again.';
            }
        },
        editNote(note) {
            // Lógica para iniciar el proceso de edición
            this.selectedNote = note; // Selecciona la nota a editar
            this.showEditNoteModal = true; // Muestra el modal
        },
        handleEditNote(updatedNote) {
            // Encuentra el índice de la nota modificada
            const noteIndex = this.notes.findIndex(note => note.id === updatedNote.id);
            if (noteIndex !== -1) {
                // Reemplaza la nota en la lista con la nota actualizada
                this.notes[noteIndex] = updatedNote;
                // Si la nota actual es la que está seleccionada, actualiza también esa
                if (this.selectedNote && this.selectedNote.id === updatedNote.id) {
                    this.selectedNote = updatedNote;
                }
                this.sortNotes();
            } else {
                console.error("Nota no encontrada para actualización:", updatedNote.id);
            }
        },
        async deleteNote(noteId) {
            try {
                // Llamar a la API para eliminar la nota
                const response = await deleteNote(noteId);

                // Eliminar la nota del arreglo de notas actual sin volver a consultar
                this.notes = this.notes.filter(note => note.id !== noteId);

                // Limpiar la nota seleccionada si la que se eliminó es la seleccionada actualmente
                if (this.selectedNote && this.selectedNote.id === noteId) {
                    this.selectedNote = null;
                }
                this.sortNotes();
            } catch (error) {
                this.error = 'Delete error. Please try again.';
            }
        },
        handleCreateNote(newNote) {
            // Lógica para agregar la nueva nota a la lista 
            this.notes.push(newNote);
            this.showCreateNoteModal = false;
            this.sortNotes();

        },
        sortNotes() {
            if (this.sortCriteria === 'dueDate') {
                this.notes.sort((a, b) => new Date(a.fecha_vencimiento) - new Date(b.fecha_vencimiento));
            } else if (this.sortCriteria === 'createdDate') {
                this.notes.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
            }
        },
        // Método que se llamará al cambiar el criterio de ordenación
        updateSortCriteria(criteria) {
            this.sortCriteria = criteria;
            this.sortNotes();
        }
    },
    mounted() {
        this.fetchNotes();
        this.sortNotes();
    },
};
</script>

<style scoped>
body {
    height: 100vh;
    align-content: center;
    background-color: #F1FFE7;
    margin: -10px;
}

.center {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #F1FFE7;
    /* Pastel lilac */
}

.navbar {
    width: 90%;
    display: flex;
    justify-content: flex-end;
    padding: 1rem;
    margin: 1rem;
    border-radius: 8px;
    background-color: #79BD9A;
    box-shadow: 1.5px 1.5px 3px rgba(0, 0, 0, 0.1);
}

.logout-button {
    background-color: #D9534F;
    /* Light coral */
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.logout-button:hover {
    background-color: #FFB6B6;
    /* Slightly darker coral */
}

.dashboard {
    display: flex;
    width: 90%;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.sidebar {
    width: 30%;
    background-color: #A8DBA8;
    /* Light turquoise */
    padding: 1rem;
    margin-right: 20px;
    border-radius: 10px;
}

.sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.create-note-button {
    background-color: #BAFF29;
    /* Soft pink */
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.create-note-button:hover {
    background-color: #e5ffac;
}

ul {
    margin-left: -40px;
}

.note-item {
    background-color: #CFF09E;
    /* Pastel yellow */
    padding: 0.5rem;
    margin-bottom: 0.5rem;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background-color 0.2s ease;
}

.note-item:hover {
    background-color: #FFE4B2;
    /* Slightly darker yellow */
}

.note-actions button {
    margin-left: 0.5rem;
    /* Light pastel red */
    border: none;
    padding: 0.25rem 0.5rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.main-content {
    width: 70%;
    padding: 2rem;
    border-radius: 10px;
    background-color: #A8DBA8;
    /* Soft pastel green */
    display: flex;
    flex-direction: column;
}

.note-title {
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    align-self: center;
    /* Centers the content horizontally */
}

.note-description {
    background-color: white;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    /* Adds a subtle shadow */
    text-align: justify;
}

.note-image {
    width: 100%;
    border-radius: 5px;
    margin-top: 1rem;
    display: block;
    margin-left: auto;
    margin-right: auto;
    /* Ensures the image is centered */
}


.delete-note-button {
    background-color: #D64550;
}

.note-actions .delete-note-button:hover {
    background-color: #df9096;
    /* Darker pastel red */
}

.edit-note-button {
    background-color: #0C7489;
}

.note-actions .edit-note-button:hover {
    background-color: #5faab9;
    /* Darker pastel red */
}

/* Estilo para la sección de opciones de ordenamiento */
.sort-options {
    display: flex;
    align-items: center; /* Alinea verticalmente los elementos */
    margin-bottom: 15px; /* Espacio debajo de la sección */
    padding: 10px; /* Espacio interior */
    background-color: #BAFF29; /* Color de fondo pastel */
    border-radius: 8px; /* Bordes redondeados */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra suave */
}

/* Estilo para la etiqueta del select */
.sort-options label {
    margin-right: 10px; /* Espacio a la derecha de la etiqueta */
    font-weight: bold; /* Negrita */
    color: #555; /* Color del texto */
}

/* Estilo para el select de ordenamiento */
.sort-options select {
    border: 1px solid #ccc; /* Borde gris claro */
    border-radius: 5px; /* Bordes redondeados */
    background-color: #dbfd92; /* Fondo blanco */
    color: #333; /* Color del texto */
    transition: border-color 0.2s; /* Transición suave para el borde */
}

</style>