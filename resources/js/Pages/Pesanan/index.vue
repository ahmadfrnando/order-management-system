<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayoutCustom from "@/Layouts/AuthenticatedLayoutCustom.vue";

const props = defineProps({
    pesanan: Object,
});

// bikin salinan biar bisa dimodifikasi di frontend
// const pesananLocal = ref({ ...props.pesanan });
const pesananLocal = ref(JSON.parse(JSON.stringify(props.pesanan)))
const isLoading = ref(false)
console.log(pesananLocal);

function updatePesananSelesai() {
    isLoading.value = true
    router.patch(`/dashboard/pesanan/${pesananLocal.value.id}/update`, {
        pesanan_detail: pesananLocal.value.pesanan_detail
    }, {
        onSuccess: () => {
            console.log('berhasil');
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
}

// fungsi ubah jumlah
const tambahJumlah = (detail) => {
    detail.jumlah++;
};

const kurangJumlah = (detail) => {
    if (detail.jumlah > 1) {
        detail.jumlah--;
    }
};

// fungsi hapus produk
const hapusProduk = (index) => {
    pesananLocal.value.pesanan_detail.splice(index, 1);
};
// fungsi tambah produk dummy
// const tambahProduk = (pesananIndex) => {
//     pesanan.value[pesananIndex].pesanan_detail.push({
//         id: Date.now(),
//         jumlah: 1,
//         menu: {
//             name: "Produk Baru",
//             price: 20000,
//             image: "https://via.placeholder.com/150",
//         },
//     });
// };
</script>

<template>
    <Head title="Pesanan" />
    <AuthenticatedLayoutCustom>
        <template #title>
            <h1 class="text-2xl font-bold text-custom-dark">Pesanan</h1>
        </template>
        <div class="mt-16">
            <!-- Header pesanan -->
            <div class="flex justify-between items-center border-b pb-3 mb-5">
                <div>
                    <h2 class="font-bold text-2xl md:text-4xl">
                        Pesanan Meja {{ pesananLocal.no_meja }}
                        <span class="uppercase"
                            >({{ pesananLocal.nama_pemesan }})</span
                        >
                    </h2>
                    <p class="text-gray-500">
                        No Pesanan: {{ pesananLocal.no_pesanan }}
                    </p>
                </div>
                <span class="font-bold text-2xl md:text-4xl text-custom-yellow">
                    {{
                        new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                        }).format(pesananLocal.total_harga)
                    }}
                </span>
            </div>

            <!-- Grid product -->
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8">
                <div
                    v-for="(d, j) in pesananLocal.pesanan_detail"
                    :key="d.id"
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
                        <span
                            class="block text-yellow-600 mt-2 font-bold text-2xl"
                        >
                            {{
                                new Intl.NumberFormat("id-ID", {
                                    style: "currency",
                                    currency: "IDR",
                                }).format(d.menu.price)
                            }}
                        </span>

                        <!-- kontrol jumlah -->
                        <div
                            class="flex justify-center items-center mt-3 space-x-3"
                        >
                            <button
                                @click="kurangJumlah(d)"
                                class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded"
                            >
                                -
                            </button>
                            <span class="font-bold text-lg">{{
                                d.jumlah
                            }}</span>
                            <button
                                @click="tambahJumlah(d)"
                                class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded"
                            >
                                +
                            </button>
                        </div>

                        <!-- aksi -->
                        <div class="mt-4">
                            <button
                                @click="hapusProduk(j, i)"
                                class="w-full bg-custom-secondary hover:bg-orange-700 text-white py-2 rounded"
                            >
                                <i class="fas fa-trash mr-2"></i>Hapus Produk
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- tombol tambah produk -->
            <div class="mt-8 flex justify-between">
                <Link
                    :href="route('pesanan.edit', pesananLocal.id)"
                    class="px-4 py-2 bg-custom-yellow hover:bg-amber-500 text-dark rounded"
                >
                    <i class="fas fa-plus mr-2"></i> Tambah Pesanan
                </Link>
                <button
                    @click="updatePesananSelesai"
                    :disabled="isLoading"
                    class="px-4 py-2 bg-custom-yellow hover:bg-amber-500 text-dark rounded"
                >
                    <i class="fas fa-check-double mr-2"></i> Pesanan Selesai
                </button>
            </div>
        </div>
    </AuthenticatedLayoutCustom>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
