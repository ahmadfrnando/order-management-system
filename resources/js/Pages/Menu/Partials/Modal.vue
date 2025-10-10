<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/ui/DangerButton.vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    mode: {
        type: String,
        default: "create", // or 'edit'
    },
    data: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(["submit", "close"]);
const isDisabled = ref(false);
const imagePreview = ref(null);
const menu = ref({
    name: "",
    price: "",
    description: "",
    category_id: "",
    image: null,
    is_best_seller: false,
    is_available: true,
});

console.log(props.data);

watch(
    () => props.data,
    (newData) => {
        if (props.mode === "edit" && newData) {
            menu.value = {
                name: newData.name || "",
                price: newData.price || "",
                description: newData.description || "",
                category_id: newData.category_id || "",
                image: null, // reset image input
                is_best_seller: Boolean(newData.is_best_seller) || false,
                is_available: Boolean(newData.is_available) || true,
            };
            imagePreview.value = `/${newData.image}` || null; // set preview to existing image
        } else {
            // reset form for create mode
            menu.value = {
                name: "",
                price: "",
                description: "",
                category_id: "",
                image: null,
                is_best_seller: false,
                is_available: true,
            };
            imagePreview.value = null;
        }
    },
    { immediate: true }
)

function formatRupiah(angka) {
    if (!angka) return "";
    const number = angka.replace(/\D/g, "");
    return new Intl.NumberFormat("id-ID").format(number);
}

function onInput(e) {
    const raw = e.target.value.replace(/\D/g, "");
    menu.value.price = raw;

    // ubah tampilan input secara langsung tanpa trigger re-render
    e.target.value = formatRupiah(raw);
}

const handleSubmit = () => {
    imagePreview.value = null;
    isDisabled.value = true;
    emit("submit", menu.value);
    isDisabled.value = false;
    menu.value = {
        name: "",
        price: "",
        description: "",
        category_id: "",
        image: null,
        is_best_seller: false,
        is_available: true,
    };
};

function handleChange(event) {
    const file = event.target.files[0];
    if (!file) return;

    menu.value.image = file;

    // buat URL lokal untuk preview
    const reader = new FileReader();
    reader.onload = (e) => {
        imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
}
</script>
<template>
    <Modal :show="show" @close="closeModal('menu')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">{{ mode === 'create' ? 'Tambah Menu' : 'Edit Menu' }}</h2>
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
                        <InputLabel for="category_id" value="Kategori" />
                        <select
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="menu.category_id"
                            ref="input"
                        >
                            <option value="">- Pilih -</option>
                            <option value="1">Coffee</option>
                            <option value="2">Drink</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <InputLabel for="price" value="Harga Menu" />
                        <TextInput
                            id="price"
                            type="text"
                            class="mt-1 block w-full"
                            @input="onInput"
                            v-model="menu.price"
                            required
                            autofocus
                        />
                    </div>
                    <div class="mt-2">
                        <InputLabel for="description" value="Deskripsi" />
                        <textarea
                            id="description"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            v-model="menu.description"
                            required
                        ></textarea>
                    </div>
                    <div class="mt-2">
                        <InputLabel
                            for="image"
                            value="Upload Gambar Menu. maksimal 2MB"
                        />
                        <input
                            @change="handleChange"
                            accept="image/*"
                            name="image"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                            id="file_input"
                            type="file"
                        />
                        <!-- Preview -->
                        <div v-if="imagePreview" class="mt-3">
                            <p class="text-sm text-gray-600 mb-1">Preview:</p>
                            <img
                                :src="imagePreview"
                                alt="Preview"
                                class="w-32 h-32 object-cover rounded-lg border border-gray-300"
                            />
                        </div>
                    </div>
                    <div class="mt-2 flex items-center gap-4">
                        <Checkbox
                            name="is_best_seller"
                            v-model:checked ="menu.is_best_seller"
                        />
                        <label
                            for="is_best_seller"
                            class="text-sm font-medium cursor-pointer"
                        >
                            Best Seller
                        </label>
                        <Checkbox
                            name="is_available"
                            v-model:checked ="menu.is_available"
                        />
                        <label
                            for="is_available"
                            class="text-sm font-medium cursor-pointer"
                        >
                            Menu Tersedia
                        </label>
                    </div>
                    <div class="flex justify-end mt-4">
                        <DangerButton @click="emit('close')" class="ms-4">
                            Batal
                        </DangerButton>
                        <PrimaryButton
                            :disabled="isDisabled"
                            :type="`submit`"
                            class="ms-4"
                        >
                            {{ mode === 'create' ? 'Simpan Menu' : 'Update Menu' }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </Modal>
</template>
