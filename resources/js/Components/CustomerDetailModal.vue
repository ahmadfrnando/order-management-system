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
});

const emit = defineEmits(["submit", "close"]);
const isDisabled = ref(false);
const customer = ref({
    nama_pemesan: "",
    no_meja: "",
    catatan: "",
});

const handleSubmit = () => {
    isDisabled.value = true;
    emit("submit", customer.value);
    customer.value = {
        nama_pemesan: "",
        no_meja: "",
        catatan: "",
    };
};
</script>
<template>
    <Modal :show="show" @close="closeModal('customer')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Information Customer
            </h2>
            <div class="mt-6">
                <form @submit.prevent="handleSubmit">
                    <div class="mt-2">
                        <InputLabel for="no_meja" value="Nomor Meja" />
                        <TextInput
                            id="no_meja"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="customer.no_meja"
                            required
                            autofocus
                        />
                    </div>
                    <div class="mt-2">
                        <InputLabel for="nama_pemesan" value="Nama Pemesan" />
                        <TextInput
                            id="nama_pemesan"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="customer.nama_pemesan"
                            required
                            autofocus
                        />
                    </div>
                    <div class="mt-2">
                        <InputLabel for="catatan" value="Catatan" />
                        <textarea
                            id="catatan"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            v-model="customer.catatan"
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
