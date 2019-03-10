<template>
    <div class="columns">
        <div class="column is-three-fifths is-offset-one-fifth">
            <div class="card">
                    <div v-if="note.thumbnail" class="card-image">
                        <figure class="image is-4by3">
                        <img :src="note.thumbnail" alt="">
                        </figure>
                    </div>
                <div class="card-content">
                    <div class="media">
                        <div class="media-content">
                            <p class="title is-6">{{ note.stream_title }}</p>
                            <p class="subtitle is-6">Game: {{ note.game_name }}</p>
                        </div>
                    </div>

                    <div class="content">
                        <template v-if="editMode" class="field">
                            <label class="label">Content</label>
                            <div class="control">
                                <textarea class="textarea" name="content" placeholder="Content" v-model="note.content"></textarea>
                            </div>
                        </template>
                        <div v-else>{{ note.content }}</div>
                        <br>
                        <time :datetime="note.created" class="is-size-7">{{ note.created }}</time>
                    </div>
                </div>
                <footer class="card-footer">
                    <a v-if="editMode" href="#" class="card-footer-item" v-on:click.prevent="onClickUpdate()">Save</a>
                    <a v-else href="#" class="card-footer-item" v-on:click.prevent="onClickEdit()" >Edit</a>
                    <a href="#" class="card-footer-item has-text-danger" v-on:click.prevent="onClickDelete()">Delete</a>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['note','streamer'],
    data() {
        return {
            editMode: false
        }
    },
    methods: {
        onClickDelete() {
            axios.delete(`/streamers/${this.streamer}/notes/${this.note.id}`).then(() => {
                this.$emit('delete');
            });
        },
        onClickEdit() {
            this.editMode = true;
        },
        onClickUpdate() {
            const params = {
                content: this.note.content
            };
            axios.patch(`/streamers/${this.streamer}/notes/${this.note.id}`, params).then((response) => {
                this.editMode = false;
                const note = response.data;
                this.$emit('update', note);
            });
        }
    }
}
</script>

