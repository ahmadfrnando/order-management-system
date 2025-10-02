<script setup>
import {useCurrency}  from "@/Composables/useCurrency";
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";

const { formatCurrency } = useCurrency();
defineProps({
  product: { type: Object, required: true }
})
</script>
<template>
  <div class="bg-white rounded-lg shadow-md p-3 hover:shadow-lg">
    <img :src="product.image" :alt="product.name"
      class="w-full transform hover:scale-90 transition duration-300"
    />
    <div class="m-3 text-center">
      <span class="font-bold text-xl">{{ product.name }}</span>
      <span class="block text-gray-600 text-sm">{{ product.description }}</span>
      <span class="block text-custom-yellow mt-3 font-bold text-xl">
        {{ formatCurrency(product.price) }}
      </span>
    </div>
    <PrimaryButton
      @click="$emit('add', product)"
      class="w-full flex justify-center"
    >
      <i class="fas fa-plus mr-2"></i> Pilih Menu
    </PrimaryButton>
  </div>
</template>
