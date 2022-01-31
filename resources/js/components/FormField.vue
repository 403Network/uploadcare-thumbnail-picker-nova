<template>
  <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
    <template slot="field">
      <div>
        <img :src="selectedThumbUrl" alt="" />
        <button @click="openThumbnail" />
      </div>
    </template>
    <thumbnail-picker 
        v-model="value" 
        :open="openThumbnail" 
        @close="isOpen = false"
    />
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import ThumbnailPicker from './ThumbnailPicker.vue'
import helpers from '../helpers'

export default {
  components: { ThumbnailPicker },
  mixins: [FormField, HandlesValidationErrors],

    data () {
        return {
            isOpen: false,
        }
    },
  props: ['resourceName', 'resourceId', 'field'],
    computed: {
        selectedThumbUrl () {
            return helpers.thumbUrl(this.uuid, this.value);
        },
    },
  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || ''
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || '')
    },
  },
}
</script>
