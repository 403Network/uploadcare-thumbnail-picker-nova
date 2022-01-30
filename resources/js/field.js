Nova.booting((Vue, router, store) => {
  Vue.component('index-uploadcare-thumbnail-picker-nova', require('./components/IndexField'))
  Vue.component('detail-uploadcare-thumbnail-picker-nova', require('./components/DetailField'))
  Vue.component('form-uploadcare-thumbnail-picker-nova', require('./components/FormField'))
})
