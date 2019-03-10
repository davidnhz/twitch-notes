<template>
    <div>
        <form-component v-if="streamer != 0" @new="addNote" :streamer="streamer"></form-component>
        <div class="section">
            <note-component
                v-for="(note, index) in notes"
                :key="note.id"
                :note="note"
                @update="updateNote(index, ...arguments)"
                @delete="deleteNote(index)">
            </note-component>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            notes: []
        }
    },
    props: ['streamer'],
    mounted() {
        if (this.streamer != 0) {
            axios.get(`/streamers/${this.streamer}/notes`)
                .then((response) => {
                    this.notes = response.data;
                });
        } else {
            axios.get(`/notes`)
                .then((response) => {
                    this.notes = response.data;
                });
        }

    },
    methods: {
        addNote(note){
            this.notes.unshift(note);
        },
        deleteNote(index) {
            this.notes.splice(index, 1);
        },
        updateNote(index, note) {
            this.notes[index] = note;
        },
    }
}
</script>
