<template>
    <div>
        <form @submit.prevent="submitNote">
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" v-model="noteData.title" id="title" required />
            </div>
            <div class="form-group">
                <label for="content">Descripción</label>
                <textarea v-model="noteData.description" id="content" required></textarea>
            </div>
            <div class="form-group">
                <label for="tags">Etiquetas</label>
                <input type="text" v-model="noteData.etiquetas" id="tags" />
            </div>
            <div class="form-group">
                <label for="dueDate">Fecha de Vencimiento</label>
                <input type="date" v-model="noteData.fecha_vencimiento" id="dueDate" />
            </div>
            <div class="form-group">
                <label for="imageUrl">URL de la Imagen</label>
                <input type="url" v-model="noteData.img_uri" id="imageUrl" />
            </div>
            <button type="submit" class="create-note-button">{{ isEditMode ? 'Editar Nota' : 'Crear Nota' }}</button>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        noteData: {
            type: Object,
            required: true
        },
        isEditMode: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        submitNote() {
            // Emitimos el evento para enviar los datos del formulario
            this.$emit('submitNote', { ...this.noteData });
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
    background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro con opacidad */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000; /* Asegura que el modal esté sobre otros elementos */
}

.modal-content {
    background-color: #FFF3CD; /* Color de fondo pastel */
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 90%;
    max-width: 500px; /* Ancho máximo del modal */
}

.close-button {
    background-color: transparent;
    border: none;
    font-size: 1.5rem;
    position: absolute;
    top: 1rem;
    right: 1rem;
    cursor: pointer;
    color: #D9534F; /* Color para el botón de cerrar */
}

.close-button:hover {
    color: #C9302C; /* Color al pasar el mouse */
}

.form-group {
    width: 90%;
}

label {
    display: block;
    margin-top: 0.5rem;

    color: #333; /* Color del texto de las etiquetas */
}

input[type="text"],
input[type="url"],
input[type="date"],
textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.2s;
}

input[type="text"]:focus,
input[type="url"]:focus,
input[type="date"]:focus,
textarea:focus {
    border-color: #FFB6B6; /* Color de borde al enfocar */
    outline: none; /* Elimina el borde por defecto */
}

textarea {
    resize: vertical; /* Permite redimensionar el textarea verticalmente */
    min-height: 100px; /* Altura mínima del textarea */
    max-height: 500px;
}

.create-note-button {
    background-color: #BAFF29; /* Botón pastel */
    border: none;
    margin-top: 1rem;
    width: 94%;
    padding: 0.5rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.create-note-button:hover {
    background-color: #daff89; /* Color al pasar el mouse */
}

</style>