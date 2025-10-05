<script setup>
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/ui/SecondaryButton.vue";
import DangerButton from "@/Components/ui/DangerButton.vue";
import { useCurrency } from "@/Composables/useCurrency";

const { formatCurrency } = useCurrency();
const props = defineProps({
    menu: Object,
}, {
    is_available: Boolean
});

const dataMenu = props.menu;

const emit = defineEmits(["edit", "setBestSeller"]);

// console.log(dataMenu.image);
</script>

<template>
    <div class="relative bg-white rounded-lg shadow-md p-3 hover:shadow-lg">
        <div
            v-if="dataMenu.is_best_seller"
            class="absolute top-3 left-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow"
        >
            ⭐ Best Seller
        </div>
        <img
            :src="dataMenu.image"
            alt="menu"
            width="200"
            height="200"
            class="rounded-md mx-auto"
        />

        <!-- detail menu -->
        <div class="mt-3 text-center">
            <span class="font-bold text-xl">{{ dataMenu.name }}</span>
            <span class="block text-yellow-600 mt-2 font-bold text-2xl">
                {{ formatCurrency(dataMenu.price) }}
            </span>
            <p class="text-sm text-gray-500 mt-2">
                {{ dataMenu.description }}
            </p>
            <!-- aksi -->
            <div class="mt-4 flex flex-col gap-2 justify-center">
                <PrimaryButton
                    @click="emit('edit', dataMenu)"
                    :class="'w-full flex justify-center'"
                >
                    <i class="fas fa-plus mr-2"></i>Ubah Menu
                </PrimaryButton>
                <SecondaryButton
                    v-if="!dataMenu.is_best_seller"
                    @click="emit('setBestSeller', dataMenu)"
                    :class="'w-full flex justify-center'"
                >
                    <i class="fas fa-star mr-2"></i>Jadikan Best Seller
                </SecondaryButton>
                <DangerButton
                    v-if="!dataMenu.is_available"
                    @click="emit('setBestSeller', dataMenu)"
                    :class="'w-full flex justify-center'"
                >
                    <i class="fas fa-star mr-2"></i>Jadikan Tidak Tersedia
                </DangerButton>
            </div>
        </div>
    </div>
</template>
