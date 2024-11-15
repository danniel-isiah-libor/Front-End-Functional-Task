<template>
  <q-item
    v-for="item in items"
    :key="item.id"
    clickable
    class="supplier"
    active-class="bg-primary text-white item"
    :active="selectedSupplier?.id === item.id"
    @click="selectSupplier(item)"
  >
    <q-item-section>{{ item.name }}</q-item-section>
    <q-item-section avatar>
      <q-icon
        name="chevron_right"
        color="grey"
      />
    </q-item-section>
  </q-item>
</template>

<script>
  export default {
    name: 'SupplierList',
    props: {
      items: {
        type: Array,
        required: true,
      },
      selectedSupplier: {
        type: Object,
        required: false,
      },
      selectSupplier: {
        type: Function,
        required: true,
      },
    },
  }
</script>
