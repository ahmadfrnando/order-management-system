<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayoutCustom from "@/Layouts/AuthenticatedLayoutCustom.vue";
import MenuCard from "./Partials/MenuCard.vue";
import { useCurrency } from "@/Composables/useCurrency";
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";

const props = defineProps({
    menu: Array,
    required: true,
    default: () => [],
}, {
    categories: Array,
    required: true,
    default: () => [],
});

function edit(Menu) {
    //
}

function setBestSeller(Menu) {
    //
}
</script>

<template>
    <Head title="Pesanan" />
    <AuthenticatedLayoutCustom>
        <template #title>
            <h1 class="text-2xl font-bold text-custom-dark">Daftar Menu</h1>
        </template>
        <div class="mt-8 flex justify-between">
            <Link :href="route('menu.create')">
                <PrimaryButton>
                    <i class="fas fa-plus mr-2"></i> Tambah Menu
                </PrimaryButton>
            </Link>
        </div>
        <div class="mt-16">
            <!-- Grid product -->
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8">
                <MenuCard
                    v-for="item in menu"
                    :key="item.id"
                    :menu="item"
                    @edit="edit(menu)"
                    @setBestSeller="setBestSeller(menu)"
                />
            </div>
        </div>
    </AuthenticatedLayoutCustom>
</template>
