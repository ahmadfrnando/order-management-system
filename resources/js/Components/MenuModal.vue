<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/ui/SecondaryButton.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        default: () => ({}),
    },
    action: {
        type: String,
        default: "create",
    },
    categories: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["submit", "close"]);
const isDisabled = ref(false);
const menu = ref({
    name: "",
    price: "",
    image: "",
    category_id: "",
    slug: "",
    description: "",
    is_best_seller: false,
    is_available: false,
});

const handleSubmit = () => {
    isDisabled.value = true;
    emit("submit", menu.value);
};
</script>
<template>
    <Modal :show="show" @close="closeModal('editMenu')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ props.action === "create" ? "Tambah Menu" : "Ubah Menu" }}
            </h2>
            <div class="mt-6">
                <form @submit.prevent="handleSubmit">
                    <div class="mt-2">
                        <InputLabel for="name" value="Nama Menu" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="menu.name"
                            required
                            autofocus
                        />
                    </div>
                    <div class="mt-2">
                        <InputLabel for="name" value="Nama Menu" />
                        <select
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="menu.category_id"
                            ref="input"
                        >
                            <option value="">- Pilih -</option>
                            <option v-for="category in categories" :value="category.id" :key="category.id">{{ category.name }}</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <InputLabel for="price" value="Harga" />
                        <TextInput
                            id="price"
                            type="number"
                            step="0.01"
                            min="0"
                            class="mt-1 block w-full"
                            v-model="menu.price"
                            required
                            autofocus
                        />
                    </div>
                    <div class="mt-2">
                        <InputLabel for="image" value="Foto Produk" />
                        <TextInput
                            id="image"
                            type="file"
                            accept="image/*"
                            class="mt-1 block w-full"
                            v-model="menu.image"
                            required
                            autofocus
                        />
                    </div>
                    <div class="mt-2">
                        <InputLabel for="description" value="Deskripsi Menu" />
                        <textarea
                            id="description"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            v-model="menu.description"
                        ></textarea>
                    </div>
                    <div class="flex justify-end mt-4">
                        <SecondaryButton
                            @click="emit('close')"
                            class="ms-4"
                            :class="{ 'opacity-25': customer.processing }"
                            :disabled="customer.processing"
                        >
                            Batal
                        </SecondaryButton>
                        <PrimaryButton
                            :disabled="isDisabled"
                            :type="`submit`"
                            class="ms-4"
                        >
                            Lakukan Pemesanan
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </Modal>
</template>
