<template>
    <div v-if="show">
        <div class="modal-overlay">
            <div class="modal">
                <h3>Editar Nota</h3>
                <NoteForm :noteData="noteData" :isEditMode="true" @submitNote="editNote" />
                <button @click="closeModal" class="close-button">Cerrar</button>
            </div>
        </div>
    </div>
</template>

<script>
import { updateNote } from '../../api/note';
import NoteForm from './NoteForm.vue';

export default {
    props: {
        existingNote: {
            type: Object,
            required: true
        }
    },
    onClose: {
        type: Function,
        required: true
    },
    components: { NoteForm },
    data() {
        return {
            noteData: { ...this.existingNote },
            show: true
        };
    },
    methods: {
        async editNote(note) {
            try {
                const response = await updateNote(note.id, this.noteData); //edita la nota
                this.$emit('editNote', response); //pasa la nota editada a la ventana padre
                this.closeModal();
            } catch (error) {
                alert("Ha ocurrido un error, verifique los campos.");
                this.errorMessage = error.message; // Mostrar el mensaje de error
            }
        },
        closeModal() {
            this.show = false;
            this.$emit('close');
        }
    }
};
</script>



<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal {
    background-color: #FFF3CD;
    width: 25%;
    border-radius: 8px;
    padding-left: 1rem;
    padding-bottom: 1rem;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 12px;
    width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.form-group {
    margin-bottom: 15px;
}

.form-actions {
    display: flex;
    justify-content: space-between;
}

h3 {
    margin-bottom: 1rem;
    color: #333;
    /* Color del texto del encabezado */
}

.div-close-button{
    display: flex;
}

.close-button {
    background-color: #D9534F;
    /* Color pastel para el botón */
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    cursor: pointer;
    width: 94%;
    transition: background-color 0.2s;
    margin-top: 1rem;
    /* Espacio arriba del botón */
}

.close-button:hover {
    background-color: #FFCCCB;
    /* Color al pasar el mouse */
}
</style>