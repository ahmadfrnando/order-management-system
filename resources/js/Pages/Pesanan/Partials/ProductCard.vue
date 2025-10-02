<script setup>
import DangerButton from "@/Components/ui/DangerButton.vue";
import { useCurrency } from "@/Composables/useCurrency";

const { formatCurrency } = useCurrency();
const props = defineProps({
    pesanan: Object,
}, {
    index: Number
}
);

const d = props.pesanan;

const emit = defineEmits(["tambah", "kurang", "hapus"]);

</script>

<template>
    <div
        class="relative bg-white rounded-lg shadow-md p-3 hover:shadow-lg"
    >
        <!-- badge jumlah -->
        <div
            class="absolute inline-flex items-center justify-center w-12 h-12 text-xl font-extrabold text-custom-dark bg-custom-yellow border-2 border-white rounded-full -top-3 -end-3"
        >
            {{ d.jumlah }}
        </div>

        <!-- gambar -->
        <img
            :src="d.menu.image"
            alt="menu"
            width="200"
            height="200"
            class="rounded-md mx-auto"
        />

        <!-- detail menu -->
        <div class="mt-3 text-center">
            <span class="font-bold text-xl">{{ d.menu.name }}</span>
            <span class="block text-yellow-600 mt-2 font-bold text-2xl">
                {{ formatCurrency(d.menu.price) }}
            </span>

            <!-- kontrol jumlah -->
            <div class="flex justify-center items-center mt-3 space-x-3">
                <button
                    @click="emit('kurang', d)"
                    class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded"
                >
                    -
                </button>
                <span class="font-bold text-lg">{{ d.jumlah }}</span>
                <button
                    @click="emit('tambah', d)"
                    class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded"
                >
                    +
                </button>
            </div>

            <!-- aksi -->
            <div class="mt-4">
                <DangerButton
                    @click="emit('hapus', index)"
                    :class="'w-full flex justify-center'"
                >
                    <i class="fas fa-trash mr-2"></i>Hapus Produk
                </DangerButton>
            </div>
        </div>
    </div>
</template>