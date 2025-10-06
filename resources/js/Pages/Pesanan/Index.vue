<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayoutCustom from "@/Layouts/AuthenticatedLayoutCustom.vue";
import ProductCard from "./Partials/ProductCard.vue";
import { useCurrency } from "@/Composables/useCurrency";
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/ui/SecondaryButton.vue";
import DangerButton from "@/Components/ui/DangerButton.vue";
import Swal from "sweetalert2";

const { formatCurrency } = useCurrency();

const props = defineProps({
    pesanan: Object,
});
const pesananLocal = ref(JSON.parse(JSON.stringify(props.pesanan)));
const isLoading = ref(false);
console.log(pesananLocal);

function updatePesananSelesai() {
    isLoading.value = true;
    Swal.fire({
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin menyelesaikan pesanan ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#C97C5D",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Saya Yakin!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            router.patch(
                `/dashboard/pesanan/${pesananLocal.value.id}/update`,
                {
                    pesanan_detail: pesananLocal.value.pesanan_detail,
                },
                {
                    onSuccess: () => {
                        console.log("berhasil");
                    },
                    onError: (errors) => {
                        console.log(errors);
                    },
                }
            );
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
                    <div class="mt-2 flex gap-4">
                        <p class="text-gray-500">
                            No Pesanan: {{ pesananLocal.no_pesanan }}
                        </p>
                        <p class="text-gray-500">
                            {{ pesananLocal.tanggal }} {{ pesananLocal.jam }}
                        </p>
                    </div>
                    <p class="text-gray-500">
                        Catatan : {{ pesananLocal.catatan }}
                    </p>
                </div>
                <span class="font-bold text-2xl md:text-4xl text-custom-yellow">
                    {{ formatCurrency(pesananLocal.total_harga) }}
                </span>
            </div>

            <!-- Grid product -->
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8">
                <ProductCard
                    v-for="(detail, index) in pesananLocal.pesanan_detail"
                    :key="detail.id"
                    :pesanan="detail"
                    :index="index"
                    @tambah="tambahJumlah(detail)"
                    @kurang="kurangJumlah(detail)"
                    @hapus="hapusProduk(index)"
                />
            </div>

            <!-- tombol tambah produk -->
            <div class="mt-8 flex justify-between">
                <Link :href="route('pesanan.edit', pesananLocal.id)">
                    <SecondaryButton>
                        <i class="fas fa-pencil-alt mr-2"></i> Ubah Pesanan
                    </SecondaryButton>
                </Link>
                <div class="flex gap-3">
                    <Link :href="route('dashboard')">
                        <DangerButton>
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </DangerButton>
                    </Link>
                    <PrimaryButton
                        @click="updatePesananSelesai"
                        :disabled="isLoading"
                    >
                        <i class="fas fa-check-double mr-2"></i> Pesanan Selesai
                    </PrimaryButton>
                </div>
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
