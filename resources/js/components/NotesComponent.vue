<template>
    <div>
        <form-component @new="addNote" :streamer="streamer"></form-component>
        <div class="section">
            <note-component
                v-for="(note, index) in notes"
                :key="note.id"
                :note="note"
                :streamer="streamer"
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
        axios.get(`/streamers/${this.streamer}/notes`)
            .then((response) => {
                this.notes = response.data;
            });

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
