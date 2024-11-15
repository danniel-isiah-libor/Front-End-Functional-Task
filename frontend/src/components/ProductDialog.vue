<!-- ProductDialog.vue -->
<template>
  <q-dialog
    v-model="modal"
    persistent
  >
    <q-card style="width: 700px; max-width: 80vw">
      <!-- Dialog content -->
      <q-card-section
        class="text-center"
        style="
          padding-top: 20px;
          padding-bottom: 24px;
          padding-left: 40px;
          padding-right: 40px;
        "
      >
        <div
          class="row items-center"
          style="padding-bottom: 40px"
        >
          <div class="col text-left">
            <q-btn
              v-if="
                (selectedSupplier?.id && !selectedProducts.length) ||
                showSelection
              "
              outline
              size="sm"
              @click="back"
            >
              <q-icon name="chevron_left" />
            </q-btn>
          </div>
          <div class="col text-center">
            <div class="text-h6 text-grey-9">{{ title }}</div>
          </div>
          <div class="col text-right">
            <q-btn
              flat
              size="sm"
              @click="cancel"
            >
              <q-icon name="close" />
            </q-btn>
          </div>
        </div>

        <q-input
          v-if="!showSelection"
          v-model="search"
          outlined
          :placeholder="
            selectedSupplier?.id ? 'Search products' : 'Search suppliers'
          "
        >
          <template v-slot:prepend>
            <q-icon
              name="search"
              class="text-grey-9"
            />
          </template>
        </q-input>
      </q-card-section>

      <q-separator />

      <q-card-section
        class="scroll"
        style="
          height: 30vh;
          padding-left: 40px;
          padding-right: 40px;
          padding-top: 0px;
          padding-bottom: 0px;
        "
      >
        <q-list separator>
          <template v-if="!selectedSupplier?.id">
            <SupplierList
              :items="items"
              :selectedSupplier="selectedSupplier"
              :selectSupplier="selectSupplier"
            />
          </template>

          <template v-else-if="!showSelection">
            <ProductList
              :items="items"
              :toggleCheckbox="toggleCheckbox"
            />
          </template>

          <template v-else>
            <SelectionList
              :selectedProducts="selectedProducts"
              :onDelete="onDelete"
            />
          </template>
        </q-list>
      </q-card-section>

      <q-separator />

      <q-card-actions
        align="center"
        class="row justify-between"
        style="
          padding-left: 40px;
          padding-right: 40px;
          padding-top: 20px;
          padding-bottom: 32px;
        "
      >
        <div class="col-4">
          <q-btn
            v-if="!showSelection"
            outline
            :label="`${selectedProducts.length} product selected`"
            color="grey"
            no-caps
            @click="showSelectedProducts"
          />
        </div>
        <div
          class="col-5"
          align="right"
        >
          <q-btn
            outline
            label="Cancel"
            @click="cancel"
            color="grey"
            style="margin-right: 16px"
            no-caps
          />
          <q-btn
            :disable="!selectedProducts.length"
            label="Add"
            color="blue-grey-9"
            @click="addProducts"
            no-caps
          />
        </div>
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
  import { ref, computed, watch } from 'vue'
  import Supplier from '../api/suppliers'
  import Product from '../api/products'
  import _ from 'lodash'
  import { useQuasar } from 'quasar'
  import SupplierList from './SupplierList.vue'
  import ProductList from './ProductList.vue'
  import SelectionList from './SelectionList.vue'

  export default {
    name: 'ProductDialog',
    components: {
      SupplierList,
      ProductList,
      SelectionList,
    },
    props: {
      modelValue: {
        type: Boolean,
        required: true,
      },
    },
    emits: ['update:modelValue'],
    setup(props, { emit }) {
      const $q = useQuasar()
      const modal = ref(props.modelValue)
      const items = ref([])
      const search = ref('')
      const title = ref('Browse')
      const loading = ref(false)
      const selectedSupplier = ref({})
      const selectedProducts = ref([])
      const showSelection = ref(false)
      const cart = ref([])

      const transformedItems = computed(() => {
        return items.value.map((item) => ({
          ...item,
          displayName: `${item.name} (${item.id})`,
        }))
      })

      const selectSupplier = async (supplier) => {
        selectedSupplier.value = supplier
        search.value = ''
        await searchProducts()
      }

      const searchSuppliers = async () => {
        loading.value = true
        await Supplier.search({ search: search.value })
          .then(({ data }) => {
            items.value = data
          })
          .finally(() => {
            loading.value = false
          })
      }

      const searchProducts = async () => {
        loading.value = true
        await Product.show(selectedSupplier.value.id, { search: search.value })
          .then(({ data }) => {
            items.value = Object.values(data).map((item) => ({
              ...item,
              expanded: false,
              selected: [],
              childProducts: item.childProducts.map((product) => ({
                ...product,
                quantity: 1,
              })),
            }))
          })
          .finally(() => {
            loading.value = false
          })
      }

      const back = () => {
        if (!showSelection.value) {
          searchSuppliers()
        } else {
          title.value = selectedSupplier.value.name
        }
        showSelection.value = false
      }

      const toggleCheckbox = (item, product) => {
        items.value = items.value.map((v) => {
          if (v.id === item.id) {
            const selected = [...v.selected]
            const index = selected.findIndex((p) => p.id === product.id)
            if (index === -1) {
              selected.push(product)
            } else {
              selected.splice(index, 1)
            }
            return { ...v, selected }
          } else {
            return v
          }
        })
      }

      const showSelectedProducts = () => {
        title.value = 'Selection'
        showSelection.value = true
      }

      const addProducts = async () => {
        cart.value = [...cart.value, ...selectedProducts.value]
        selectedSupplier.value = {}
        await showNotif()
        close()
      }

      const showNotif = () => {
        let names = selectedProducts.value.map((v) => v.product.name)
        if (names.length > 2) {
          names = names.slice(0, 2).join(', ') + '...'
        } else {
          names = names.join(', ')
        }
        $q.notify({
          message: names,
          color: 'positive',
          icon: 'check_circle',
          position: 'bottom-right',
          timeout: 3000,
          actions: [{ icon: 'close', color: 'white', round: true }],
        })
      }

      const close = () => {
        clear()
        modal.value = false
        emit('update:modelValue', false)
      }

      const cancel = () => {
        modal.value = false
        emit('update:modelValue', false)
      }

      const clear = () => {
        selectedProducts.value = []
        items.value = []
        search.value = ''
        title.value = 'Browse'
        loading.value = false
        showSelection.value = false
      }

      const onDelete = (product) => {
        const index = selectedProducts.value.findIndex(
          (p) => p.product.id === product.product.id
        )
        selectedProducts.value.splice(index, 1)
        items.value = items.value.map((v) => ({
          ...v,
          selected: v.selected.filter((p) => p.id !== product.product.id),
        }))
        if (selectedProducts.value.length === 0) {
          back()
        }
      }

      watch(selectedSupplier, (val) => {
        title.value = val?.id ? val.name : 'Browse'
      })

      watch(
        search,
        _.debounce(() => {
          if (selectedSupplier.value?.id) {
            searchProducts()
          } else {
            searchSuppliers()
          }
        }, 500)
      )

      watch(modal, (val) => {
        if (val && !items.value.length) {
          searchSuppliers()
        }
      })

      watch(
        items,
        (newVal) => {
          if (newVal.length) {
            const a = []
            newVal.forEach((v) => {
              if (v.selected?.length) {
                v.selected.forEach((p) => {
                  a.push({ ...v, product: p })
                })
              }
            })
            selectedProducts.value = a
          }
        },
        { deep: true }
      )

      watch(
        () => props.modelValue,
        (newVal) => {
          modal.value = newVal
        }
      )

      return {
        q: $q,
        modal,
        items,
        search,
        title,
        loading,
        selectedSupplier,
        selectedProducts,
        showSelection,
        cart,
        transformedItems,
        selectSupplier,
        searchSuppliers,
        searchProducts,
        back,
        toggleCheckbox,
        showSelectedProducts,
        addProducts,
        showNotif,
        close,
        cancel,
        clear,
        onDelete,
      }
    },
  }
</script>

<style scoped>
  .supplier:focus,
  .supplier:hover {
    background-color: rgba(118, 188, 249, 0.5);
  }
  .supplier:hover .q-icon,
  .supplier:focus .q-icon {
    color: black !important;
  }
  .item >>> .q-icon,
  .item:hover >>> .q-icon {
    color: white !important;
  }
  .q-expansion-item >>> .q-item {
    padding-left: 0px;
  }
  .select-product {
    background-color: rgba(118, 188, 249, 0.5);
  }
  .truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 65%;
    padding-right: 24px;
  }
</style>
