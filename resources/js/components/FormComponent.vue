<template>
    <div>
        <form action="" method="POST" v-on:submit.prevent="newNote()">
            <input type="hidden" name="_token" :value="csrf">
            <div class="field">
                <label class="label">Content</label>
                <div class="control">
                    <textarea class="textarea" name="content" placeholder="Content" v-model="content"></textarea>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-link" type="submit">Add Note</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                content: '',
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        props: ['streamer'],
        methods: {
            newNote() {
                const params = {
                    content: this.content
                };
                this.content = '';
                axios.post(`/streamers/${this.streamer}/notes`, params)
                    .then((response) => {
                        const note = response.data;
                        this.$emit('new', note);
                    });
            }
        }
    }
</script>

