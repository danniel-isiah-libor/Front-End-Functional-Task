<template>
  <q-page class="flex flex-center">
    <q-btn
      label="Add products"
      color="primary"
      @click="modal = true"
    />

    <ProductDialog
      ref="productDialog"
      v-model="modal"
    />
  </q-page>
</template>

<script>
  import { ref } from 'vue'
  import ProductDialog from '../components/ProductDialog.vue'

  export default {
    components: {
      ProductDialog,
    },
    setup() {
      const modal = ref(false)
      const productDialog = ref(null)

      const getSelectedProducts = () => {
        return productDialog.value?.cart ?? []
      }

      return {
        modal,
        productDialog,
        getSelectedProducts,
      }
    },
  }
</script>
