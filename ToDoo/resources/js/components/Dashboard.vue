<template>
    <div class="center">
        <div class="navbar">
            <button @click="logout" class="logout-button">Cerrar Sesión</button>
        </div>
        <div class="dashboard">
            <div class="sidebar">
                <div class="sidebar-header">
                    <h2>Mis Notas</h2>
                    <button @click="showModal = true" class="create-note-button">Nueva Nota</button>
                </div>
                <ul>
                    <li v-for="note in notes" :key="note.id" class="note-item" @click="selectNote(note)">
                        <span class="note-title">
                            {{ note.title }}
                        </span>
                        <button @click.stop="deleteNote(note.id)" class="delete-note-button">Eliminar</button>
                        <!-- Modificador .stop para evitar que el clic en el botón dispare el evento en el <li> -->
                    </li>
                </ul>
            </div>
            <div class="main-content">
                <div v-if="selectedNote">
                    <h2>{{ selectedNote.title }}</h2>
                    <p>{{ selectedNote.description }}</p>
                </div>
                <p v-else>No has seleccionado ninguna nota.</p>
            </div>
        </div>
        <!-- Modal para crear una nueva nota -->
        <CreateNoteModal v-if="showModal" :note="newNote" @createNote="handleCreateNote"
            @closeModal="showModal = false" />
    </div>
</template>

<script>
import { logout } from '../api/auth';
import { searchNotes, deleteNote } from '../api/note';
import CreateNoteModal from './CreateNoteModal.vue'; // Importar el componente modal

export default {
    components: {
        CreateNoteModal,
    },
    data() {
        return {
            showModal: false, // Controla si el modal está visible
            notes: [], // Lista de notas
            selectedNote: null, // Nota seleccionada
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
                const response = await searchNotes();
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
                const response = await logout();
                this.$router.push('/'); // Redirige a al login
            } catch (error) {
                this.error = 'Logout error. Please try again.';
            }
        },
        async deleteNote(noteId) {
            try {
                console.log(noteId);
                console.log(this.notes);
                const response = await deleteNote(noteId);
                this.fetchNotes();
            } catch (error) {
                this.error = 'Delete error. Please try again.';
            }
        },
        handleCreateNote(newNote) {
            // Lógica para agregar la nueva nota a la lista 
            console.log(newNote);
            this.notes.push( newNote );
            this.showModal = false;

        },
    },
    mounted() {
        this.fetchNotes();
    },
};
</script>

<style scoped>
.center {
    display: flex;
    /* Usa flexbox para centrar */
    flex-direction: column;
    /* Cambia la dirección a columna */
    justify-content: flex-start;
    /* Alinea los elementos al inicio */
    align-items: center;
    /* Centra horizontalmente */
    height: 100vh;
    /* Altura total de la ventana */
}

.navbar {
    width: 90%;
    /* Ocupa el ancho completo */
    padding: 20px;
    /* Espaciado interno */
    background-color: #90caf9;
    /* Color de fondo de la navbar */
    display: flex;
    justify-content: flex-end;
    /* Alinea el botón a la derecha */
    border-radius: 8px;
}

.logout-button {
    padding: 10px 15px;
    border: none;
    border-radius: 8px;
    background-color: #ef5350;
    /* Color del botón de logout */
    color: white;
    cursor: pointer;
}

.logout-button:hover {
    background-color: #e53935;
    /* Color al pasar el mouse sobre el botón */
}

.dashboard {
    display: flex;
    /* Mantiene el diseño de dos columnas */
    justify-content: space-between;
    /* Alinea las columnas */
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    background-color: #f7f7f7;
    width: 90%;
    /* Color de fondo */
    margin-top: 20px;
    /* Espacio entre la navbar y el dashboard */
}

.sidebar {
    flex: 1;
    /* Proporción 1 */
    margin-right: 20px;
    /* Espacio entre las columnas */
    border-radius: 12px;
    background-color: #e3f2fd;
    /* Color de fondo lateral */
    padding: 10px;
    overflow-y: auto;
    /* Agregar scroll si es necesario */
}

.sidebar-header {
    display: flex;
    /* Usa flexbox para alinear el título y el botón */
    justify-content: space-between;
    /* Alinea los elementos a los extremos */
    align-items: center;
    /* Centra verticalmente los elementos */

    padding-left: 25px;
}

.main-content {
    flex: 2;
    /* Proporción 2 */
    border-radius: 12px;
    background-color: #ffe0b2;
    /* Color de fondo principal */
    padding: 10px;
    overflow-y: auto;
    /* Agregar scroll si es necesario */
}

.note-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    margin: 5px 0;
    background-color: #bbdefb;
    /* Color de fondo para notas */
}

.note-item:hover {
    background-color: #90caf9;
    /* Color al pasar el mouse */
}

.delete-note-button {

    background-color: #ef5350;
    border: none;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

.delete-note-button:hover {
    background-color: #e53935;
}

.create-note-button {
    margin-left: 10px;
    /* Espacio entre el título y el botón */
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    background-color: #4caf50;
    /* Color del botón de nueva nota */
    color: white;
    cursor: pointer;
}

.create-note-button:hover {
    background-color: #388e3c;
    /* Color al pasar el mouse sobre el botón de nueva nota */
}
</style>