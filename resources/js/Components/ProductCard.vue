<script setup>
import { useCurrency } from "@/Composables/useCurrency";
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";

const { formatCurrency } = useCurrency();
defineProps({
    product: { type: Object, required: true },
});
</script>
<template>
    <div
        class="relative bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition p-3 flex flex-col"
    >
        <!-- Badge Best Seller / Rekomendasi -->
        <div
            v-if="product.is_best_seller"
            class="absolute top-3 left-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow"
        >
            ⭐ Best Seller
        </div>

        <!-- Gambar Produk -->
        <img
            :src="product.image"
            :alt="product.name"
            class="w-full h-40 object-contain transform hover:scale-95 transition duration-300"
        />

        <!-- Detail Produk -->
        <div class="mt-3 text-center flex-1 flex flex-col">
            <!-- Nama Produk -->
            <h3 class="font-bold text-lg text-gray-900">{{ product.name }}</h3>

            <!-- Deskripsi dibatasi -->
            <p class="text-gray-600 text-sm line-clamp-2 mt-1">
                {{ product.description }}
            </p>

            <!-- Harga -->
            <p class="text-amber-600 mt-3 font-bold text-lg">
                {{ formatCurrency(product.price) }}
            </p>
        </div>

        <!-- Tombol Pilih Menu -->
        <PrimaryButton
            @click="$emit('add', product)"
            class="mt-4 w-full flex justify-center bg-gradient-to-r from-amber-600 to-yellow-500 hover:from-amber-700 hover:to-yellow-600 text-white font-semibold rounded-lg py-2"
        >
            <i class="fas fa-plus mr-2"></i> Pilih Menus
        </PrimaryButton>
    </div>
</template>
