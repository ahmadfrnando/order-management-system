<script setup>
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/ui/SecondaryButton.vue";
import DangerButton from "@/Components/ui/DangerButton.vue";
import { useCurrency } from "@/Composables/useCurrency";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { ref, watch } from "vue";

const { formatCurrency } = useCurrency();
const props = defineProps({
    menu: Object,
});

// const dataMenu = props.menu;

const dataMenu = ref({ ...props.menu });

// agar local menu ikut update saat parent update props
watch(
  () => props.menu,
  (newVal) => {
    dataMenu.value = { ...newVal };
  },
  { deep: true }
);

const emit = defineEmits(["edit", "setBestSeller", "setAvailable"]);

// console.log(dataMenu.image);

const activeModal = ref(null);
const openModal = (modal) => (activeModal.value = modal);
const closeModal = () => (activeModal.value = null);
</script>

<template>
    <div class="relative bg-white rounded-lg shadow-md p-3 hover:shadow-lg">
        <div
            v-if="dataMenu.is_best_seller"
            class="absolute top-3 left-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow"
        >
            <i class="fas fa-star mr-2"></i> Best Seller
        </div>
        <div
            v-if="dataMenu.is_available === 0"
            class="absolute top-12 left-3 bg-gradient-to-r from-gray-600 to-gray-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow"
        >
            <i class="fas fa-times mr-2"></i> Tidak Tersedia
        </div>
        <img
            :src="`/${dataMenu.image}`"
            alt="menu"
            width="300"
            height="300"
            class="rounded-md mx-auto"
        />

        <!-- detail menu -->
        <div class="mt-3 text-center">
            <span class="font-bold text-xl">{{ dataMenu.name }}</span>
            <span class="block text-yellow-600 mt-2 font-bold text-2xl">
                {{ formatCurrency(dataMenu.price) }}
            </span>
            <p class="text-sm text-gray-500 mt-2" v-if="dataMenu.description.length <= 100">
                {{ dataMenu.description }}
            </p>
            <p class="text-sm text-gray-500 mt-2" v-else>
                {{ dataMenu.description.slice(0, 100) + '...' }}
            </p>
            <!-- aksi -->
            <div class="mt-4 flex flex-col gap-2 justify-center">
                <PrimaryButton
                    @click="emit('edit', dataMenu)"
                    :class="'w-full flex justify-center'"
                >
                    <i class="fas fa-plus mr-2"></i>Ubah Menu
                </PrimaryButton>
                <DangerButton
                    @click="emit('hapus', dataMenu)"
                    :class="'w-full flex justify-center'"
                >
                    <i class="fas fa-trash mr-2"></i>Hapus Menu
                </DangerButton>
            </div>
        </div>
    </div>
</template>
