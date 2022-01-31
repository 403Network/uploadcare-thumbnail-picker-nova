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
    data() {
        return {
            newThumbId: null,
        }
    },
    methods: {
        thumbUrl () {
            return helpers.thumbUrl(this.uuid, this.selectedThumbId);
        },
        selectedThumbId () {
            return this.value || 0
        },
        close (value) {
            this.$emit('close')
            this.$emit('input', newId)
            this.newId = null;
        }
    },
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
}
.uc-thumb-img {
    display: block;
}
.uc-thumb {
    cursor: pointer;
    display: block;
}
.uc-thumb--selected {
    border: 3px solid rgb(26, 109, 210);
}
.uc-thumb--new {
    border: 3px solid rgb(26, 210, 109);
}
</style>