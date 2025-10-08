<script setup>
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { ref, watch, onMounted, computed } from "vue";
import AuthenticatedLayoutCustom from "@/Layouts/AuthenticatedLayoutCustom.vue";
import ProductCard from "./Partials/ProductCard.vue";
import MenuCard from "./Partials/MenuCard.vue";
import { useCurrency } from "@/Composables/useCurrency";
import { useCart } from "@/Composables/useCart";
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/ui/SecondaryButton.vue";
import NoData from "@/Components/NoData.vue";
import DangerButton from "@/Components/ui/DangerButton.vue";
import Swal from "sweetalert2";

const { formatCurrency } = useCurrency();

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

const storageKey = `pesanan_${props.pesanan.id}`;
// const cart = ref([]);
const cart = ref({
    id_pesanan: props.pesanan.id,
    meja_id: props.pesanan.meja_id,
    status: props.pesanan.is_done ? "submitted" : "draft", // "draft" | "submitted"
    pesanan_detail: [],
    updated_at: null,
});

function minutesDiff(date1, date2) {
    return Math.abs((date2 - date1) / (1000 * 60)); // selisih menit
}

onMounted(() => {
    const saved = localStorage.getItem(storageKey);
    const now = new Date();
    if (saved) {
        const parsed = JSON.parse(saved);
        const updatedAt = parsed.updated_at
            ? new Date(parsed.updated_at)
            : null;
        const diffMinutes = updatedAt ? minutesDiff(updatedAt, now) : Infinity;

        if (diffMinutes <= 30 && parsed.status === "draft") {
            // ✅ masih valid
            cart.value = parsed;
        } else {
            // ❌ kadaluarsa atau sudah submitted
            localStorage.removeItem(storageKey);
            reloadFromServer();
        }
    } else {
        // localStorage.setItem(storageKey, JSON.stringify(cart.value));
        cart.value.pesanan_detail = props.pesanan.pesanan_detail || [];
        cart.value.updated_at = new Date().toISOString();
        localStorage.setItem(storageKey, JSON.stringify(cart.value));
    }
});

watch(
    cart,
    (val) => {
        val.updated_at = new Date().toISOString();
        localStorage.setItem(storageKey, JSON.stringify(val));
    },
    {
        deep: true,
    }
);

const isLoading = ref(false);
const menuCoffee = props.menu.filter((menu) => menu.category_id === 1);
const menuDrink = props.menu.filter((menu) => menu.category_id === 2);

function storePesananSelesai() {
    isLoading.value = true;
    const data = JSON.parse(localStorage.getItem(storageKey));
    router.post(
        route("pesanan.store"),
        {
            id: data.id_pesanan,
            pesanan_detail: data.pesanan_detail,
        },
        {
            onFinish: () => {
                clearCart();
                isLoading.value = false;
            },
        }
    );
}

function batalkanPerubahan(){
    Swal.fire({
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin membatalkan perubahan pada pesanan ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#C97C5D",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Saya Yakin!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            clearCart();
        }
    });
}

function clearCart() {
    localStorage.removeItem(storageKey);
    router.visit(`/dashboard/pesanan/${props.pesanan.id}`);
}

// fungsi ubah jumlah
const tambahJumlah = (detail) => {
    detail.jumlah++;
};

const kurangJumlah = (detail) => {
    if (detail.jumlah > 1) {
        detail.jumlah--;
    } else {
        hapusProduk(cart.value.pesanan_detail.indexOf(detail));
    }
};

// fungsi hapus produk
const hapusProduk = (index) => {
    cart.value.pesanan_detail.splice(index, 1);
};

const addToCart = (menu) => {
    const existing = cart.value.pesanan_detail.find((d) => d.menu_id === menu.id);
    if (existing) {
        existing.jumlah++;
    } else {
        cart.value.pesanan_detail.push({
            id: null,
            menu_id: menu.id,
            nama_menu: menu.name,
            harga: menu.price,
            pesanan_id: props.pesanan.id,
            menu: {
                id: menu.id,
                name: menu.name,
                price: menu.price,
                image: menu.image,
            },
            jumlah: 1,
        });
    }
};

const totalHarga = computed(() =>
    cart.value.pesanan_detail.reduce(
        (sum, item) => sum + item.harga * item.jumlah,
        0
    )
);

const isEditable = ref(true);
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
                        Pesanan Meja {{ props.pesanan.no_meja }}
                        <span class="uppercase"
                            >({{ props.pesanan.nama_pemesan }})</span
                        >
                    </h2>
                    <p class="text-gray-500">
                        No Pesanan: {{ props.pesanan.no_pesanan }}
                    </p>
                </div>
                <span class="font-bold text-2xl md:text-4xl text-custom-yellow">
                    {{ formatCurrency(totalHarga) }}
                </span>
            </div>

            <!-- Grid product -->
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8 mb-5 mt-16">
                <ProductCard
                    v-if="cart.pesanan_detail && cart.pesanan_detail.length"
                    v-for="(detail, index) in cart.pesanan_detail"
                    :key="detail.menu_id || index"
                    :pesanan="detail"
                    :index="index"
                    :editable="isEditable"
                    @tambah="tambahJumlah(detail)"
                    @kurang="kurangJumlah(detail)"
                    @hapus="hapusProduk(index)"
                />
                <NoData v-else>Belum ada tambahan menu</NoData>
            </div>

            <div class="flex justify-between items-center border-b pb-3 mb-5">
                <div>
                    <h2 class="font-bold text-2xl md:text-4xl">Coffees</h2>
                </div>
            </div>
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8">
                <MenuCard
                    v-for="menu in menuCoffee"
                    :key="menu.id"
                    :menu="menu"
                    @add="addToCart(menu)"
                />
            </div>
            <div
                class="flex justify-between items-center border-b pb-3 mb-5 mt-16"
            >
                <div>
                    <h2 class="font-bold text-2xl md:text-4xl">Drinks</h2>
                </div>
            </div>
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8">
                <MenuCard
                    v-for="menu in menuDrink"
                    :key="menu.id"
                    :menu="menu"
                    @add="addToCart(menu)"
                />
            </div>

            <!-- tombol tambah produk -->
            <div class="mt-8 flex justify-between">
                <Link :href="route('pesanan.index', props.pesanan.id)">
                    <SecondaryButton>
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </SecondaryButton>
                </Link>
                <div class="flex gap-3">
                    <DangerButton @click="batalkanPerubahan" :disabled="isLoading">
                        <i class="fas fa-ban mr-2"></i> Batalkan Perubahan
                    </DangerButton>
                    <PrimaryButton
                        @click="storePesananSelesai"
                        :disabled="isLoading"
                    >
                        <i class="fas fa-check-double mr-2"></i> Simpan
                        Perubahan
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutCustom>
</template>
