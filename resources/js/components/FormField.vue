<template>
  <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
    <template slot="field">
        <div>
            <template v-if="uuid">
                <img :src="selectedThumbUrl" alt="" />
                <button @click.prevent="isOpen = true" type="button" class="btn btn-default btn-primary inline-flex">
                    Change Thumbnail
                </button>
            </template>
            <div v-else>No Video available</div>
            <thumbnail-picker 
                v-model="value" 
                :open="isOpen" 
                @close="isOpen = false"
            />
        </div>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import ThumbnailPicker from './ThumbnailPicker.vue'
import helpers from '../helpers'
import Vue from 'vue'

export default {
  components: { ThumbnailPicker },
  mixins: [FormField, HandlesValidationErrors],

    data () {
        return {
            isOpen: false,
            dependenciesSatisfied: true,
            dependencyValues: {},
            videoUrl: '',
        }
    },
  props: ['resourceName', 'resourceId', 'field'],
    computed: {
        dv () {
            return this.dependencyValues
        },
        splitVideoUrl () {
            return (this.videoUrl || '').split('/') || []
        },

        uuid () {
            return (this.videoUrl || '').split('/')[3] || ''
        },
        dependency () {
            return this.field.dependency || '';
        },
        selectedThumbUrl () {
            return helpers.thumbUrl(this.uuid, this.value);
        },
    },
    watch: {
        dependencyValues: {
            deep: true,
            handler (to, from) {
                    console.log('dependencyValues updated');
                    console.log(to);
                    console.log(this.field.dependency);
                if (to[this.field.dependency]) {    
                    console.log(to[this.field.dependency]);
                    this.uuid = (to[this.field.dependency] || '').split('/')[3];
                }
            }
        }
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


			// @todo: refactor entire watcher procedure, this approach isn't maintainable ..
			registerDependencyWatchers(root, callback) {
        console.info('mounted');
				callback = callback || null;
				root.$children.forEach(component => {
               console.info(component);
					if (this.componentIsDependency(component)) {

						// @todo: change `findWatchableComponentAttribute` to return initial state(s) of current dependency.
						let attribute = this.findWatchableComponentAttribute(component),
							initial_value = component.field.value; // @note: quick-fix for issue #88

						component.$watch(attribute, (value) => {
							// @todo: move to reactive factory
							if (attribute === 'selectedResource') {
								value = (value && value.value) || null;
							}
                        console.log('updating', value);
                            this.videoUrl = value;

                            Vue.set(this.dependencyValues, component.field.attribute, value);
							// @todo: change value as argument for `updateDependencyStatus`
							this.updateDependencyStatus()
						}, {immediate: true});

						// @todo: move to initial state
						// @note quick-fix for issue #88
						if (attribute === 'fieldTypeName') {
							initial_value = component.field.resourceLabel;
						}

						// @todo: replace with `updateDependencyStatus(initial_value)` and let it resolve dependency state
                        console.log('initial_value', initial_value);
                            this.videoUrl = initial_value;
                        Vue.set(this.dependencyValues, component.field.attribute, initial_value);
					}

					this.registerDependencyWatchers(component)
				});

				if (callback !== null) {
					callback.call(this);
				}
			},
			componentIsDependency(component) {
				if (component.field === undefined) {
					return false;
				}
                console.info(component.field.attribute);
                if (component.field.attribute === this.field.dependency) {
                    console.info(true);
                    return true;
                }
				return false;
			},
			// @todo: not maintainable, move to factory
			findWatchableComponentAttribute(component) {
				let attribute;
				switch(component.field.component) {
					case 'belongs-to-many-field':
					case 'belongs-to-field':
						attribute = 'selectedResource';
						break;
					case 'morph-to-field':
						attribute = 'fieldTypeName';
						break;
					default:
						attribute = 'value';
				}
				return attribute;
			},
            updateDependencyStatus () {

            }

  },
    mounted () {
        console.info('mounted');
    this.registerDependencyWatchers(this.$root, function() {
        this.updateDependencyStatus();
    });
  }
}
</script>
