<template>
    <div v-if="show">
        <div class="modal-overlay">
            <div class="modal">
                <h3>Crear Nueva Nota</h3>
                <NoteForm :noteData="noteData" @submitNote="createNote" />
                <button @click="closeModal" class="close-button">Cerrar</button>

            </div>
        </div>
    </div>
</template>

<script>
import { createNote } from '../../api/note';
import NoteForm from './NoteForm.vue';

export default {
    components: { NoteForm },
    data() {
        return {
            noteData: {
                title: '',
                description: '',
                etiquetas: '',
                fecha_vencimiento: '',
                img_uri: ''
            },
            show: true
        };
    },
    methods: {
        async createNote() {
            try {
                const response = await createNote(this.noteData); //crea la nota
                this.$emit('createNote', response); //pasa la nota creada a la ventana padre
                this.closeModal();
            } catch (error) {
                alert("Ha ocurrido un error, verifique los campos.");
                this.errorMessage = error.message; // Mostrar el mensaje de error
            }
        },
        closeModal() {
            this.show = false;
            this.$emit('close');
        },
    },
};
</script>


<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro con opacidad */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000; /* Asegura que el modal esté sobre otros elementos */
}

.modal{
    background-color: #FFF3CD;
    width: 25%;
    border-radius: 8px;
    padding-left: 1rem;
    padding-bottom: 1rem;
}

.modal-content {
    background-color: #FFF3CD; /* Color de fondo pastel */
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 90%;
    max-width: 500px; /* Ancho máximo del modal */
}

h3 {
    margin-bottom: 1rem;
    color: #333; /* Color del texto del encabezado */
}


.close-button {
    background-color: #D9534F; /* Color pastel para el botón */
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    cursor: pointer;
    width: 94%;
    transition: background-color 0.2s;
    margin-top: 1rem; /* Espacio arriba del botón */
}

.close-button:hover {
    background-color: #FFCCCB; /* Color al pasar el mouse */
}

</style>