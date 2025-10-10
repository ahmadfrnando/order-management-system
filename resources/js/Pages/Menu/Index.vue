<script setup>
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import AuthenticatedLayoutCustom from "@/Layouts/AuthenticatedLayoutCustom.vue";
import MenuCard from "./Partials/MenuCard.vue";
import Modal from "./Partials/Modal.vue";
import { useCurrency } from "@/Composables/useCurrency";
import PrimaryButton from "@/Components/ui/PrimaryButton.vue";
import Swal from "sweetalert2";

const props = defineProps(
    {
        menu: Array,
        required: true,
        default: () => [],
    },
    {
        categories: Array,
        required: true,
        default: () => [],
    }
);

const form = useForm({
    name: "",
    price: "",
    description: "",
    category_id: "",
    image: null,
    is_best_seller: false,
    is_available: true,
});

const activeModal = ref(null);
const modalMode = ref("create");
const selectedMenu = ref(null);

const openModalCreate = () => {
    modalMode.value = "create";
    selectedMenu.value = null;
    activeModal.value = "menu";
};

const openModalEdit = (menu) => {
    modalMode.value = "edit";
    selectedMenu.value = menu;
    form.name = menu.name;
    form.price = menu.price;
    form.description = menu.description;
    form.category_id = menu.category_id;
    form.image = menu.image; // reset image input
    form.is_best_seller = menu.is_best_seller;
    form.is_available = menu.is_available;
    activeModal.value = "menu";
};

const hapusMenu = (menu) => {
    Swal.fire({
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin menghapus menu ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#C97C5D",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Saya Yakin!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(
                route("menu.destroy", menu.id),
                {
                    onFinish: () => {
                        router.reload({ only: ["menu"] });
                    },
                }
            );
        }
    });
}

const closeModal = () => {
    activeModal.value = null;
    form.reset();
};

const menuCoffees = computed(() =>
    props.menu.filter((item) => item.category_id === 1)
);

const menuDrinks = computed(() =>
    props.menu.filter((item) => item.category_id === 2)
);

function handleSubmitMenu(menuData) {
    form.name = menuData.name;
    form.price = menuData.price;
    form.description = menuData.description;
    form.category_id = menuData.category_id;
    // form.image = menuData.image;
    form.is_best_seller = menuData.is_best_seller;
    form.is_available = menuData.is_available;

    form.image = menuData.image instanceof File ? menuData.image : null;
    if (modalMode.value === "edit" && selectedMenu.value) {
        form.transform((data) => ({
            ...data,
            _method: "PUT", // Laravel butuh ini
        })).post(`/dashboard/menu/${selectedMenu.value.id}`, {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                form.reset();
                closeModal();
                router.reload({ only: ["menu"] });
                
            },
            onError: (errors) => {
                console.log(errors);
            },
        });
        return;
    } else {
        console.log('test nambah menu');
        form.transform((data) => ({
            ...data,
            _method: "POST", // Laravel butuh ini
        })).post("/dashboard/menu", {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                form.reset();
                closeModal();
                router.reload({ only: ["menu"] });
            },
        });
    }
}
</script>

<template>
    <Head title="Pesanan" />
    <AuthenticatedLayoutCustom>
        <template #title>
            <h1 class="text-2xl font-bold text-custom-dark">Daftar Menu</h1>
        </template>
        <div class="mt-8 flex justify-between">
            <PrimaryButton @click="openModalCreate">
                <i class="fas fa-plus mr-2"></i> Tambah Menu
            </PrimaryButton>
            <Modal
                :show="activeModal === 'menu'"
                :data="selectedMenu"
                :mode="modalMode"
                @close="closeModal('menu')"
                @submit="handleSubmitMenu"
            />
        </div>
        <div class="mt-16">
            <!-- Grid product -->
            <div class="mb-8">
                <span class="font-bold text-2xl md:text-4xl">Coffees</span>
            </div>
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8">
                <MenuCard
                    v-for="item in menuCoffees"
                    :key="item.id"
                    :menu="item"
                    @edit="openModalEdit(item)"
                    @hapus="hapusMenu(item)"
                />
            </div>
        </div>
        <div class="mt-16">
            <div class="mb-8">
                <span class="font-bold text-2xl md:text-4xl">Drinks</span>
            </div>
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8">
                <MenuCard
                    v-for="item in menuDrinks"
                    :key="item.id"
                    :menu="item"
                    @edit="openModalEdit(item)"
                    @hapus="hapusMenu(item)"
                />
            </div>
        </div>
    </AuthenticatedLayoutCustom>
</template>
