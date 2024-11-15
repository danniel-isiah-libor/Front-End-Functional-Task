<template>
  <q-list separator>
    <q-item
      v-for="(product, key) in selectedProducts"
      :key="product.id"
      clickable
      style="
        padding-left: 0px;
        padding-right: 0px;
        padding-top: 20px;
        padding-bottom: 20px;
      "
    >
      <div
        class="flex flex-center"
        style="padding-right: 20px"
      >
        <span>{{ key + 1 }}</span>
      </div>
      <q-item-section>
        <div class="row">
          <div
            class="self-center"
            style="padding-right: 20px"
          >
            <q-avatar
              square
              class="text-center align-center justify-center"
            >
              <q-img src="https://cdn.quasar.dev/img/boy-avatar.png" />
            </q-avatar>
          </div>
          <span class="truncate">
            {{ product.name }}
            <br />
            <span>{{ product.product.name }}</span>
            <br />
            <span class="text-grey">{{ product.product.sku }}</span>
          </span>
        </div>
      </q-item-section>
      <q-item-section
        side
        style="
          margin-left: 0px;
          padding-left: 0px;
          margin-right: 0px;
          padding-right: 0px;
        "
      >
        <q-input
          v-model="product.product.quantity"
          outlined
          bg-color="white"
          dense
          type="number"
          min="1"
          style="width: 100px"
          :disable="!selectedProducts.includes(product)"
        />
      </q-item-section>
      <q-item-section
        side
        style="padding-left: 20px; margin-left: 0px"
      >
        <q-btn
          flat
          style="width: 10px"
          @click="onDelete(product)"
        >
          <q-icon name="delete" />
        </q-btn>
      </q-item-section>
    </q-item>
  </q-list>
</template>

<script>
  export default {
    props: {
      selectedProducts: {
        type: Array,
        required: true,
      },
      onDelete: {
        type: Function,
        required: true,
      },
    },
  }
</script>
