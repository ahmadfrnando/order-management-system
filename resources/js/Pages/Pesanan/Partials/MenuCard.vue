<script setup>
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";
import { useCurrency } from "@/Composables/useCurrency";

const { formatCurrency } = useCurrency();
const props = defineProps({
    menu: Object,
});

const dataMenu = props.menu;

const emit = defineEmits(["tambah"]);

console.log(dataMenu);

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
            <div class="mt-4">
                <PrimaryButton
                    @click="emit('tambah', dataMenu.id)"
                    :class="'w-full flex justify-center'"
                >
                    <i class="fas fa-plus mr-2"></i>Pilih Menu
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>