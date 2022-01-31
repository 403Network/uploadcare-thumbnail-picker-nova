Nova.booting((Vue, router, store) => {
  Vue.component('index-uploadcare-thumbnail-picker', require('./components/IndexField'))
  Vue.component('detail-uploadcare-thumbnail-picker', require('./components/DetailField'))
  Vue.component('form-uploadcare-thumbnail-picker', require('./components/FormField'))
})
