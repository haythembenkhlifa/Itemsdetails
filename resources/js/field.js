Nova.booting((Vue, router, store) => {
  Vue.component('index-itemsdetails', require('./components/IndexField'))
  Vue.component('detail-itemsdetails', require('./components/DetailField'))
  Vue.component('form-itemsdetails', require('./components/FormField'))
})
