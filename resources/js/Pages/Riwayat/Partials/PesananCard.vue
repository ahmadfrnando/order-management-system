<script setup>
import { useCurrency } from "@/Composables/useCurrency";
import { useDate } from "@/Composables/useDate";
import SecondaryButton from "@/Components/ui/SecondaryButton.vue";
const { formatCurrency } = useCurrency();
const { formatDate } = useDate();
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    riwayat: { type: Object, required: true },
});

console.log(props.riwayat);
</script>
<template>
    <div
        class="bg-white rounded-lg shadow-md lg:border-l-8 border-gray-800 text-center hover:shadow-lg order"
    >
        <div class="grid grid-cols-1 lg:grid-cols-4">
            <div class="bg-custom-yellow p-3 flex justify-center items-center">
                <span class="font-bold text-lg">{{
                    formatDate(props.riwayat.tanggal)
                }}</span>
            </div>
            <div class="p-3 flex justify-center items-center">
                <span class="font-bold text-md"
                    >{{ props.riwayat.total_item }}
                    {{ props.riwayat.total_item > 0 ? "items" : "item" }}</span
                >
            </div>
            <div class="p-3 flex justify-center items-center">
                <span class="font-bold text-md">{{
                    formatCurrency(props.riwayat.total_harga)
                }}</span>
            </div>
            <div class="p-3">
                <Link :href="route('riwayat.show', props.riwayat.id)">
                    <SecondaryButton> Order details </SecondaryButton>
                </Link>
            </div>
        </div>
    </div>
</template>
