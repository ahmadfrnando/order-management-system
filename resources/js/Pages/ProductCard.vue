<script setup>
import { useCurrency } from "@/Composables/useCurrency";
import SecondaryButton from "@/Components/ui/SecondaryButton.vue";
import DangerButton from "@/Components/ui/DangerButton.vue";
const { formatCurrency } = useCurrency();
import { Link } from "@inertiajs/vue3";

defineProps({
    pesanan: { type: Object, required: true },
});
</script>
<template>
    <div
        class="max-w-sm p-6 mt-10 bg-white border border-gray-200 rounded-2xl shadow-md"
    >
        <!-- Nomor Pesanan -->
        <div class="flex justify-center">
            <div
                class="text-xl font-bold text-custom-dark bg-custom-yellow w-12 h-12 flex items-center justify-center rounded-full"
            >
                {{ pesanan.no_meja }}
            </div>
        </div>

        <!-- Nama Pemesan dan nomor pesanan -->
        <div class="flex justify-between mt-4">
            <h5 class="text-xl text-center font-semibold text-gray-800">
                {{ pesanan.nama_pemesan }}
            </h5>
            <h5 class="text-xl text-center font-semibold text-gray-800">
                #{{ pesanan.no_pesanan }}
            </h5>
        </div>

        <!-- Daftar Pesanan -->

        <div class="mt-5 divide-y divide-gray-200">
            <div
                class="flex justify-between py-2"
                v-for="(d, j) in pesanan.pesanan_detail"
                :key="j"
            >
                <span class="font-medium text-gray-600"
                    >x{{ d.jumlah }} {{ d.menu.name }}</span
                >
                <span class="font-medium text-gray-600">
                    {{ formatCurrency(d.menu.price * d.jumlah) }}</span
                >
            </div>
            <div
                class="flex justify-between py-3 font-bold text-lg text-gray-800"
            >
                <span>Total</span>
                <span class="text-custom-dark">
                    {{ formatCurrency(pesanan.total_harga) }}</span
                >
            </div>
        </div>

        <!-- Tombol Aksi -->
        <Link :href="route('pesanan.index', pesanan.id)">
            <SecondaryButton class="w-full mt-5 flex justify-center">
                <i class="fas fa-check-double mr-2"></i>
                Detail Pesanan
            </SecondaryButton>
        </Link>
        <DangerButton class="w-full mt-5 flex justify-center">
            <i class="fas fa-trash mr-2"></i>
            Batalkan Pesanan
        </DangerButton>
        <!-- <Link
            :href="route('pesanan.index', pesanan.id)"
            class="w-full mt-5 bg-custom-yellow text-custom-dark font-semibold py-2 px-4 rounded-xl flex items-center justify-center hover:bg-yellow-400 transition"
        >
            <i class="fas fa-check-double mr-2"></i>
            Detail Pesanan
        </Link> -->
        <!-- <button
            class="w-full mt-5 bg-red-500 text-white font-semibold py-2 px-4 rounded-xl flex items-center justify-center hover:bg-red-400 transition"
        >
            <i class="fas fa-trash mr-2"></i>
            Batalkan Pesanan
        </button> -->
    </div>
</template>
