<script setup>
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/ui/SecondaryButton.vue";
import { useCurrency } from "@/Composables/useCurrency";

const { formatCurrency } = useCurrency();
const props = defineProps({
    menu: Object,
});

const dataMenu = props.menu;

const emit = defineEmits(["edit", "setBestSeller"]);

// console.log(dataMenu.image);

</script>

<template>
    <div
        class="relative bg-white rounded-lg shadow-md p-3 hover:shadow-lg"
    >
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
            <!-- aksi -->
            <div class="mt-4 flex gap-2 justify-center">
                <PrimaryButton
                    @click="emit('edit', dataMenu)"
                    :class="'w-full flex justify-center'"
                >
                    <i class="fas fa-plus mr-2"></i>Ubah Menu
                </PrimaryButton>
                <SecondaryButton
                    @click="emit('setBestSeller', dataMenu)"
                    :class="'w-full flex justify-center'"
                >
                    <i class="fas fa-star mr-2"></i>Jadikan Best Seller
                </SecondaryButton>
            </div>
        </div>
    </div>
</template>