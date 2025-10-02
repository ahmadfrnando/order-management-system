<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayoutCustom from "@/Layouts/AuthenticatedLayoutCustom.vue";
import ProductCard from "./Partials/ProductCard.vue";
import MenuCard from "./Partials/MenuCard.vue";
import { useCurrency } from "@/Composables/useCurrency";
import { useCart } from "@/Composables/useCart";
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/ui/SecondaryButton.vue";

const { formatCurrency } = useCurrency();

const {
    cart,
    addToCart,
    decreaseQty,
    removeFromCart,
    clearCart,
    totalQty,
    totalPrice,
} = useCart();

const props = defineProps({
    pesanan: {
        type: Object,
        required: true,
    },
    menu: {
        type: Array,
        default: () => [],
    },
});
const pesananLocal = ref(JSON.parse(JSON.stringify(props.pesanan)));
const isLoading = ref(false);
const menuCoffee = props.menu.filter(menu => menu.category_id === 1);
const menuDrink = props.menu.filter(menu => menu.category_id === 2);

function updatePesananSelesai() {
    isLoading.value = true;
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
                    <p class="text-gray-500">
                        No Pesanan: {{ pesananLocal.no_pesanan }}
                    </p>
                </div>
                <span class="font-bold text-2xl md:text-4xl text-custom-yellow">
                    {{ formatCurrency(pesananLocal.total_harga) }}
                </span>
            </div>

            <!-- Grid product -->
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8 mt-16">
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

            <div class="flex justify-between items-center border-b pb-3 mb-5 mt-16">
                <div>
                    <h2 class="font-bold text-2xl md:text-4xl">
                        Coffees
                    </h2>
                </div>
            </div>
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8">
                <MenuCard
                    v-for="menu in menuCoffee"
                    :key="menu.id"
                    :menu="menu"
                />
            </div>
            <div class="flex justify-between items-center border-b pb-3 mb-5 mt-16">
                <div>
                    <h2 class="font-bold text-2xl md:text-4xl">
                        Drinks
                    </h2>
                </div>
            </div>
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8">
                <MenuCard
                    v-for="menu in menuDrink"
                    :key="menu.id"
                    :menu="menu"
                />
            </div>

            <!-- tombol tambah produk -->
            <div class="mt-8 flex justify-between">
                <Link :href="route('pesanan.index', pesananLocal.id)">
                    <SecondaryButton>
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </SecondaryButton>
                </Link>
                <PrimaryButton
                    @click="updatePesananSelesai"
                    :disabled="isLoading"
                >
                    <i class="fas fa-check-double mr-2"></i> Simpan Perubahan
                </PrimaryButton>
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
