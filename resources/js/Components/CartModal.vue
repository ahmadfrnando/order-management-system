<script setup>
import { useCurrency } from "@/Composables/useCurrency";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  cart: {
    type: Array,
    required: true
  }
});

console.log(props.show);

const emit = defineEmits(["close", "openCustomer", "addItem", "decreaseItem", "removeItem"]);

const { formatCurrency } = useCurrency();
</script>

<template>
  <Modal :show="show" @close="emit('close')">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">Your Orders</h2>
      <p class="mt-1 text-sm text-gray-600">
        Review your selected items before proceeding to checkout.
      </p>

      <!-- tabel cart -->
      <div class="mt-6">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
              <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
              <th class="px-6 py-3 bg-gray-50"></th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="(item, index) in cart" :key="index">
              <td class="px-6 py-4">{{ item.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                {{ formatCurrency(item.price * item.qty) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">{{ item.qty }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button
                  @click="emit('addItem', item)"
                  type="button"
                  class="p-2 ms-2 text-xs inline-flex items-center text-white bg-stone-700 rounded-full hover:bg-stone-800 focus:ring-4 focus:outline-none focus:ring-stone-300"
                >
                  <i class="fas fa-plus"></i>
                </button>
                <button
                  @click="emit('decreaseItem', item)"
                  type="button"
                  class="p-2 ms-2 text-xs inline-flex items-center text-white bg-yellow-500 rounded-full hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300"
                >
                  <i class="fas fa-minus"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- total -->
      <div class="mt-4 text-right font-bold text-lg">
        Total: {{ formatCurrency(cart.reduce((sum, i) => sum + i.price * i.qty, 0)) }}
      </div>

      <!-- actions -->
      <div class="mt-6 flex justify-end">
        <SecondaryButton @click="emit('close')">
          Take me back
        </SecondaryButton>
        <PrimaryButton class="ms-3" @click="emit('openCustomer')">
          Lanjut Pemesanan
        </PrimaryButton>
      </div>
    </div>
  </Modal>
</template>
