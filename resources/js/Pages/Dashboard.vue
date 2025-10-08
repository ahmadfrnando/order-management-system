<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { ref, onMounted, onUnmounted, watch } from "vue";
import AuthenticatedLayoutCustom from "@/Layouts/AuthenticatedLayoutCustom.vue";
import ProductCard from "./ProductCard.vue";
import NoData from "@/Components/NoData.vue";
import Swal from "sweetalert2";


let intervalId = null;

// onMounted(() => {
//     intervalId = setInterval(() => {
//     if (document.visibilityState === 'visible') {
//         router.reload({ only: ['pesanan'] });
//     }
// }, 1000);
// });

onUnmounted(() => {
    // Hentikan interval ketika komponen di-unmount agar tidak bocor
    if (intervalId) clearInterval(intervalId);
});

const props = defineProps({
    pesanan: {
        type: Array,
        required: true,
    },
});

const pesanan = ref(props.pesanan);
watch(
  () => props.pesanan,
  (newVal) => {
    pesanan.value = newVal
  }
)

function batalkanPesanan(id) {
    Swal.fire({ 
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin membatalkan pesanan ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#C97C5D",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Saya Yakin!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(
                `/dashboard/pesanan/${id}`,
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
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayoutCustom>
        <template #title>
            <h1 class="text-2xl font-bold text-custom-dark">Dashboard</h1>
        </template>
        <div class="grid md:grid-cols-3 sm:grid-cols-1 gap-4">
            <ProductCard
                v-if="pesanan.length > 0"
                v-for="(p, index) in pesanan"
                :pesanan="p"
                :key="index"
                @batal="batalkanPesanan"
                
            />
            <NoData v-else >Belum ada pesanan</NoData>
        </div>
    </AuthenticatedLayoutCustom>
</template>
