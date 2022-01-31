<template>
    <div class="uc-thumb-wrapper">
        <div class="uc-thumb-picker">
            <div>
            <h3>Pick Thumbnail</h3>
                <button @click="save">Save</button>
            </div>
            <div class="uc-thumb-list">
                <div 
                    v-for="thumb in 50" 
                    :key="thumb" 
                    class="uc-thumb" 
                    :class="[
                        thumb === selectedThumbId ? 'uc-thumb--selected' : '',
                        thumb === newThumbId ? 'uc-thumb--new-selected' : '',
                    ]"
                    @click="newThumbId = thumb"
                >
                    <img :src="thumbUrl(thumb)" alt="" class="uc-thumb-img">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import helpers from '../helpers';

export default {
    props: ['open', 'value', 'uuid'],
    data() {
        return {
            newThumbId: null,
        }
    },
    computed: {
        selectedThumbId () {
            return this.value || 0
        },
    },
    methods: {
        thumbUrl () {
            return helpers.thumbUrl(this.uuid, this.selectedThumbId);
        },
        close (value) {
            this.$emit('close')
            this.$emit('input', newId)
            this.newId = null;
        },
        keyDown () {
            
        },
    },
    watch: {
        open (to, from) {
            if (to) {
                window.addEventListener('keydown', this.keyDown)
            } else {
                window.removeEventListener('keydown', this.keyDown)
            }
        }
    }
}
</script>

<style scoped>
.uc-thumb-wrapper {
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    z-index: 100;
    background-color: rgba(0, 0, 0, 0.7);
}
.uc-thumb-picker {
    background-color: white;
    border-radius: 4px;
    position: absolute;
    top: 10%;
    bottom: 10%;
    left: 10%;
    right: 10%;
    display: flex;
    flex-direction: column;
}
.uc-thumb-img {
    display: block;
}
.uc-thumb-list {
    overflow-y: scroll;
    bottom: 0;
    position: relative;
    max-height: 100%;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}
.uc-thumb {
    cursor: pointer;
    display: block;
    padding: 1rem;
    width: 20%;
}
.uc-thumb--selected {
    border: 3px solid rgb(26, 109, 210);
}
.uc-thumb--new {
    border: 3px solid rgb(26, 210, 109);
}
</style>