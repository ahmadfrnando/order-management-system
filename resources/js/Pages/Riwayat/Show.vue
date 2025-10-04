<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { computed } from "vue";
import AuthenticatedLayoutCustom from "@/Layouts/AuthenticatedLayoutCustom.vue";
import SecondaryButton from "@/Components/ui/SecondaryButton.vue";
import { useCurrency } from "@/Composables/useCurrency";

const { formatCurrency } = useCurrency();

const props = defineProps({
    riwayat: {
        type: Object,
        required: true,
    },
});

// pisahkan berdasarkan kategori
const menuCoffee = computed(() =>
    props.riwayat.pesanan_detail_riwayat.filter((m) => m.kategori_id === 1)
);
const menuDrink = computed(() =>
    props.riwayat.pesanan_detail_riwayat.filter((m) => m.kategori_id === 2)
);

// hitung total harga
const totalHarga = computed(() =>
    props.riwayat.pesanan_detail_riwayat.reduce(
        (acc, m) => acc + m.harga * m.jumlah,
        0
    )
);

console.log(
    props.riwayat.pesanan_detail_riwayat.map(m => ({ id: m.nama_menu, kategori: m.kategori_id }))
);
</script>

<template>
    <Head title="Detail Riwayat Pesanan" />
    <AuthenticatedLayoutCustom>
        <template #title>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold text-custom-dark">
                    Detail Riwayat Pesanan
                </h1>
            </div>
        </template>

        <div class="mt-10 space-y-10">
            <!-- Informasi Pesanan -->
            <div class="p-6 border rounded-xl shadow-sm bg-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-custom-dark">
                            Meja {{ riwayat.no_meja }} -
                            <span class="uppercase">{{ riwayat.nama_pemesan }}</span>
                        </h2>
                        <p class="text-gray-500">No Pesanan: {{ riwayat.no_pesanan }}</p>
                        <p class="text-gray-500">Tanggal: {{ riwayat.tanggal }}</p>
                        <p class="text-gray-500">Jam: {{ riwayat.jam }}</p>
                        <p class="text-gray-500 italic" v-if="riwayat.catatan">
                            Catatan: {{ riwayat.catatan }}
                        </p>
                    </div>
                    <span
                        class="px-4 py-2 text-sm font-bold rounded-full bg-green-100 text-green-700"
                    >
                        <i class="fas fa-check mr-2"></i> Pesanan selesai & sudah diantar
                    </span>
                </div>
            </div>

            <!-- Menu Coffee -->
            <div v-if="menuCoffee.length > 0">
                <h2 class="text-xl font-bold text-custom-dark mb-4">Coffees</h2>
                <div class="divide-y rounded-xl border bg-white shadow-sm">
                    <div
                        v-for="(item, i) in menuCoffee"
                        :key="'coffee-' + i"
                        class="flex justify-between items-center p-4"
                    >
                        <div>
                            <p class="font-medium">{{ item.nama_menu }}</p>
                            <p class="text-sm text-gray-500">
                                {{ item.jumlah }} x {{ formatCurrency(item.harga) }}
                            </p>
                        </div>
                        <span class="font-bold">{{
                            formatCurrency(item.harga * item.jumlah)
                        }}</span>
                    </div>
                </div>
            </div>

            <!-- Menu Drinks -->
            <div v-if="menuDrink.length > 0">
                <h2 class="text-xl font-bold text-custom-dark mb-4">Drinks</h2>
                <div class="divide-y rounded-xl border bg-white shadow-sm">
                    <div
                        v-for="(item, i) in menuDrink"
                        :key="'drink-' + i"
                        class="flex justify-between items-center p-4"
                    >
                        <div>
                            <p class="font-medium">{{ item.nama_menu }}</p>
                            <p class="text-sm text-gray-500">
                                {{ item.jumlah }} x {{ formatCurrency(item.harga) }}
                            </p>
                        </div>
                        <span class="font-bold">{{
                            formatCurrency(item.harga * item.jumlah)
                        }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Harga -->
            <div
                class="flex justify-between items-center p-6 border-t bg-gray-50 rounded-xl"
            >
                <span class="text-lg font-bold text-custom-dark">Total</span>
                <span class="text-2xl font-extrabold text-custom-yellow">{{
                    formatCurrency(totalHarga)
                }}</span>
            </div>

            <!-- Tombol kembali -->
            <div class="flex justify-start">
                <Link :href="route('riwayat.index')">
                    <SecondaryButton>
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </SecondaryButton>
                </Link>
            </div>
        </div>
    </AuthenticatedLayoutCustom>
</template>
