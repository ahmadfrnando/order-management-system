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

// function buatPesanan(id) {
//     router.patch("");
// }
</script>

<template>
    <Head title="Pesanan" />
    <AuthenticatedLayoutCustom>
        <div v-if="pesanan.length > 0">
            <div class="mt-16" v-for="(p, i) in pesanan" :key="i">
                <div class="flex justify-between">
                    <span class="font-bold text-2xl md:text-4xl"
                        >Pesanan Meja {{ p.no_meja }}
                        <span class="uppercase"
                            >({{ p.nama_pemesan }})</span
                        ></span
                    >
                    <span class="font-bold text-2xl md:text-4xl">{{
                        new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                        }).format(p.total_harga)
                    }}</span>
                </div>
                <div
                    class="mt-5 grid md:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 gap-16"
                >
                    <!--card-->
                    <div
                        v-for="(d, j) in p.pesanan_detail"
                        :key="j"
                        class="relative bg-white rounded-lg shadow-md p-3 hover:shadow-lg item"
                    >
                        <div
                            class="absolute inline-flex items-center justify-center w-16 h-16 text-2xl font-extrabold text-custom-light bg-custom-secondary border-2 border-white rounded-full -top-2 -end-2"
                        >
                            {{ d.jumlah }}
                        </div>
                        <img
                            :src="d.menu.image"
                            alt="burger"
                            class="w-full transform hover:scale-90 transition duration-300"
                        />
                        <div class="m-3 text-center">
                            <span class="font-bold text-xl">{{
                                d.menu.name
                            }}</span>
                            <!-- <span class="block text-gray-600 text-sm"
                                >bacon, iceberg, mayo</span
                            > -->
                            <span
                                class="block text-custom-yellow mt-5 font-bold text-3xl"
                                >{{
                                    new Intl.NumberFormat("id-ID", {
                                        style: "currency",
                                        currency: "IDR",
                                    }).format(d.menu.price)
                                }}</span
                            >
                            <PrimaryButton
                                id="coffee"
                                class="w-full mt-5 flex justify-center"
                            >
                                <i class="fas fa-check-double mr-2"></i> Buat
                                Pesanan</PrimaryButton
                            >
                            <SecondaryButton
                                id="coffee"
                                class="w-full mt-2 flex justify-center"
                            >
                                <i class="fas fa-trash mr-2"></i>
                                Batal</SecondaryButton
                            >
                        </div>
                    </div>

                    <!--card end-->
                </div>
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
