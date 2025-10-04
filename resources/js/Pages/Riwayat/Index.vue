<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayoutCustom from "@/Layouts/AuthenticatedLayoutCustom.vue";
import PesananCard from "./Partials/PesananCard.vue";
import NoData from "@/Components/NoData.vue";

const props = defineProps({
    riwayat: Array,
});
</script>

<template>
    <Head title="Riwayat" />
    <AuthenticatedLayoutCustom>
        <template #title>
            <h1 class="text-2xl font-bold text-custom-dark">Riwayat Pesanan</h1>
        </template>
        <div class="mt-16">
            <div>
                <span class="font-bold text-2xl md:text-4xl">Past orders:</span>
            </div>

            <div class="mt-5 grid grid-cols-2 lg:grid-cols-1 gap-10">
                <PesananCard
                    v-if="props.riwayat.length > 0"
                    v-for="(riwayat, index) in props.riwayat"
                    :riwayat="riwayat"
                    :key="index"
                />
                 <NoData v-else >Belum ada riwayat</NoData>
            </div>
        </div>
    </AuthenticatedLayoutCustom>
</template>
