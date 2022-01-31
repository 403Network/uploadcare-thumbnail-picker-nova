<template>
    <div class="uc-thumb-wrapper" v-show="open" @click="close">
        <div class="uc-thumb-picker" @click.stop>
            <div class="uc-header">
                <h3>Pick Thumbnail</h3>
                <div>
                    <button @click.prevent="close" class="btn btn-default inline-flex btn-danger mr-3">Cancel</button>
                    <button @click.prevent="save" class="btn btn-default inline-flex btn-primary">Save</button>
                </div>
            </div>
            <div class="uc-thumb-list">
                <div 
                    v-for="(thumb, index) in 50" 
                    :key="index" 
                    class="uc-thumb" 
                    :class="[
                        index === selectedThumbId ? 'uc-thumb--selected' : '',
                        index === newThumbId ? 'uc-thumb--new' : '',
                    ]"
                    @click.stop="() => newThumbId = index"
                >
                    <span class="uc-thumb-tag" v-if="hasTag(index)" v-text="currentOrNew(index)"/>
                    <img :src="thumbUrl(index)" alt="" class="uc-thumb-img">
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
            return parseInt(this.value) || 0
        },
    },
    methods: {
        hasTag (index) {
            return Boolean(this.currentOrNew(index))
        },
        currentOrNew (index) {
            if (index == this.newThumbId && this.newThumbId == this.selectedThumbId) {
                return 'Unchanged';
            } else if (index == this.newThumbId) {
                return 'New';
            } else if (index == this.selectedThumbId) {
                return 'Old';
            }
            return null;
        },
        thumbUrl (thumbId) {
            return helpers.thumbUrl(this.uuid, thumbId);
        },
        close (value) {
            this.$emit('close')
            this.newThumbId = this.selectedThumbId;
        },
        save () {
            this.$emit('close')
            this.$emit('input', this.newThumbId);
        },
        keyDown () {

        },
    },
    watch: {
        open (to, from) {
            if (to) {
                this.newThumbId = this.selectedThumbId;
            }
            // if (to) {
            //     window.addEventListener('keydown', this.keyDown)
            // } else {
            //     window.removeEventListener('keydown', this.keyDown)
            // }
        }
    }
}
</script>

<style scoped>
.uc-header {
    padding: 1rem;
    display: flex;
    justify-content: space-between;
}
.uc-thumb-wrapper {
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    z-index: 100;
    background-color: rgba(0, 0, 0, 0.7);
    display: block;
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
    border: 1px solid white;
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
    width: 25%;
    opacity: 0.5;
    position: relative;
}
.uc-thumb--selected {
    opacity: 1;
    filter: grayscale(1);
}
.uc-thumb--new {
    opacity: 1;
    filter: grayscale(0) drop-shadow(2px 4px 6px black);
}
.uc-thumb-tag {
    position: absolute;
}
</style>