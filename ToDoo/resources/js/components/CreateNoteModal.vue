<template>
    <div class="modal-overlay">
        <div class="modal-content">
            <h2>Crear Nueva Nota</h2>
            <form @submit.prevent="submitNote">
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" v-model="note.title" id="title" required />
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea v-model="note.description" id="description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="tags">Etiquetas (separadas por comas)</label>
                    <input type="text" v-model="note.etiquetas" id="tags" />
                </div>

                <div class="form-group">
                    <label for="dueDate">Fecha de Vencimiento</label>
                    <input type="date" v-model="note.fecha_vencimiento" id="dueDate" />
                </div>

                <div class="form-group">
                    <label for="imageUrl">URL de la Imagen</label>
                    <input type="url" v-model="note.img_uri" id="imageUrl" />
                </div>

                <div class="form-actions">
                    <button type="submit">Crear Nota</button>
                    <button @click="$emit('closeModal')" type="button">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { createNote } from '../api/note';

export default {
    props: ['note'],
    data() {
        return {
            title: '',
            description: '',
            etiquetas: '',
            fecha_vencimiento: '',
            img_uri: '',
        };
    },
    methods: {
        async submitNote() {
            try {
                const response = await createNote(this.note);
                this.$emit('createNote', response);
            } catch (error) {
                this.errorMessage = error.message; // Mostrar el mensaje de error
            }
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
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
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
</style>