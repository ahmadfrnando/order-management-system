<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { ref } from "vue";
import AuthenticatedLayoutCustom from "@/Layouts/AuthenticatedLayoutCustom.vue";

const props = defineProps({
    pesanan: {
        type: Array,
        required: true,
    },
});

const pesanan = ref(props.pesanan);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayoutCustom>
        <template #title>
            <h1 class="text-2xl font-bold text-custom-dark">Dashboard</h1>
        </template>
        <div class="grid md:grid-cols-3 lg:grid-cols-4 sm:grid-cols-1 gap-4">
            <div
                v-if="pesanan.length > 0"
                v-for="(p, i) in pesanan"
                :key="i"
                
            >
                <div
                    class="max-w-sm p-6 mt-10 bg-white border border-gray-200 rounded-2xl shadow-md"
                >
                    <!-- Nomor Pesanan -->
                    <div class="flex justify-center">
                        <div
                            class="text-xl font-bold text-custom-dark bg-custom-yellow w-12 h-12 flex items-center justify-center rounded-full"
                        >
                            {{ p.no_meja }}
                        </div>
                    </div>

                    <!-- Nama Pemesan dan nomor pesanan -->
                    <div class="flex justify-between mt-4">
                        <h5
                            class="text-xl text-center font-semibold text-gray-800"
                        >
                            {{ p.nama_pemesan }}
                        </h5>
                        <h5
                            class="text-xl text-center font-semibold text-gray-800"
                        >
                            #{{ p.no_pesanan }}
                        </h5>
                    </div>

                    <!-- Daftar Pesanan -->

                    <div class="mt-5 divide-y divide-gray-200">
                        <div
                            class="flex justify-between py-2"
                            v-for="(d, j) in p.pesanan_detail"
                            :key="j"
                        >
                            <span class="font-medium text-gray-600"
                                >x{{ d.jumlah }} {{ d.menu.name }}</span
                            >
                            <span class="font-medium text-gray-600"
                                >
                                {{
                                    new Intl.NumberFormat("id-ID", {
                                        style: "currency",
                                        currency: "IDR",
                                    }).format(d.harga)
                                }}</span
                            >
                        </div>
                        <div
                            class="flex justify-between py-3 font-bold text-lg text-gray-800"
                        >
                            <span>Total</span>
                            <span class="text-custom-dark">
                                {{
                                    new Intl.NumberFormat("id-ID", {
                                        style: "currency",
                                        currency: "IDR",
                                    }).format(p.total_harga)
                                }}</span
                            >
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <Link
                        :href="route('pesanan.index', p.id)"
                        class="w-full mt-5 bg-custom-yellow text-custom-dark font-semibold py-2 px-4 rounded-xl flex items-center justify-center hover:bg-yellow-400 transition"
                    >
                        <i class="fas fa-check-double mr-2"></i>
                        Detail Pesanan
                    </Link>
                    <button
                        class="w-full mt-5 bg-red-500 text-white font-semibold py-2 px-4 rounded-xl flex items-center justify-center hover:bg-red-400 transition"
                    >
                        <i class="fas fa-trash mr-2"></i>
                        Batalkan Pesanan
                    </button>
                </div>
            </div>
            <div v-else class="mt-16">
                <div class="flex justify-center items-center w-100">
                    <figure>
                        <img
                            src="images/no_data.svg"
                            alt="no-data"
                            class="mx-auto w-40 h-40"
                        />
                        <figcaption class="text-center text-gray-600 mt-5">
                            Belum ada pesanan
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutCustom>
</template>
