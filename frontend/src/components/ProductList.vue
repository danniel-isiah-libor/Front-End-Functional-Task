<template>
  <q-expansion-item
    v-for="item in items"
    :key="item.id"
    v-model="item.expanded"
    expand-icon="chevron_right"
    expanded-icon="expand_more"
    :class="item.expanded ? 'bg-grey-3' : ''"
  >
    <template v-slot:header>
      <q-item-section avatar>
        <q-avatar square>
          <q-img src="https://cdn.quasar.dev/img/boy-avatar.png" />
        </q-avatar>
      </q-item-section>
      <q-item-section>
        <span class="truncate">{{ item.name }}</span>
      </q-item-section>
    </template>

    <q-card class="bg-grey-3">
      <q-card-section style="padding-left: 0px; padding-right: 0px">
        <q-list separator>
          <q-item
            v-for="product in item.childProducts"
            :key="product.id"
            clickable
          >
            <q-item-section
              avatar
              style="padding-left: 10px"
              @click="toggleCheckbox(item, product)"
            >
              <q-checkbox
                :val="product"
                v-model="item.selected"
              />
            </q-item-section>
            <q-item-section @click="toggleCheckbox(item, product)">
              <span class="truncate">
                {{ product.name }}
                <br />
                <span class="text-grey">{{ product.sku }}</span>
              </span>
            </q-item-section>
            <q-item-section
              side
              style="padding-right: 26px"
            >
              <q-input
                v-model="product.quantity"
                outlined
                bg-color="white"
                dense
                type="number"
                min="1"
                style="width: 100px"
                :disable="!item.selected.includes(product)"
              />
            </q-item-section>
          </q-item>
        </q-list>
      </q-card-section>
    </q-card>
  </q-expansion-item>
</template>

<script>
  export default {
    props: {
      items: {
        type: Array,
        required: true,
      },
      toggleCheckbox: {
        type: Function,
        required: true,
      },
    },
  }
</script>
