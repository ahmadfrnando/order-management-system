<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref, computed, onMounted, watch } from "vue";
import HeroCoffee from "@/assets/images/coffee-hero.png";
import CoffeeIcon from "@/assets/icons/coffee-icon.png";
import DrinksIcon from "@/assets/icons/drinks-icon.png";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

const confirmingOrderingMenu = ref(false);
const confirmingCustomerDetail = ref(false);

const openModal = (modal) => {
    modal == "ordering"
        ? (confirmingOrderingMenu.value = true)
        : (confirmingCustomerDetail.value = true);
};

const closeModal = (modal) => {
    modal == "ordering"
        ? (confirmingOrderingMenu.value = false)
        : (confirmingOrderingMenu.value = false);
};

onMounted(() => {
    const savedCart = localStorage.getItem("cart");
    if (savedCart) {
        cart.value = JSON.parse(savedCart);
    }
});

defineProps({
    coffees: {
        type: Array,
        required: true,
        default: () => [],
    },
    drinks: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const cart = ref([]);
function addToCart(items) {
    const item = cart.value.find((c) => c.name === items.name);
    if (item) {
        item.qty += 1;
    } else {
        cart.value.push({
            ...items,
            qty: 1,
        });
    }
}

watch(
    cart,
    (newVal) => {
        localStorage.setItem("cart", JSON.stringify(newVal));
    },
    { deep: true }
);

const totalQty = computed(() => {
    return cart.value.reduce((sum, item) => sum + item.qty, 0);
});

const form = useForm({
    nama_pemesan: "",
    no_meja: "",
    catatan: "",
    items: [],
});

function submitOrder() {
    form.items = cart.value;

    form.post("/orders", {
        onSuccess: () => {
            alert("Pesanan berhasil disimpan!");
            cart.value = [];
        },
        onError: (errors) => {
            console.error(errors);
            alert("Gagal menyimpan pesanan");
        },
    });
}
</script>

<template>
    <Head title="Welcome" />
    <!-- hero start -->
    <button
        @click="openModal('ordering')"
        class="fixed bottom-5 right-5 font-bold rounded-full bg-custom-secondary text-custom-dark py-2 px-5 z-40"
    >
        <i class="fas fa-cart-plus"></i>
        My Orders
        <div
            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-custom-primary border-2 border-white rounded-full -top-2 -end-2"
        >
            {{ totalQty }}
        </div>
    </button>
    <Modal :show="confirmingOrderingMenu" @close="closeModal('ordering')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Your Orders</h2>
            <p class="mt-1 text-sm text-gray-600">
                Review your selected items before proceeding to checkout.
            </p>
            <div class="mt-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Name
                            </th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Price
                            </th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Quantity
                            </th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            ></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(item, index) in cart" :key="index">
                            <td class="px-6 py-4">{{ item.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{
                                    new Intl.NumberFormat("id-ID", {
                                        style: "currency",
                                        currency: "IDR",
                                    }).format(item.price * item.qty)
                                }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ item.qty }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                            >
                                <button
                                    @click="item.qty += 1"
                                    type="button"
                                    class="p-2 ms-2 text-xs text-center font-medium inline-flex items-center text-white bg-stone-700 rounded-full hover:bg-stone-800 focus:ring-4 focus:outline-none focus:ring-stone-300"
                                >
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button
                                    @click="
                                        item.qty > 1
                                            ? (item.qty -= 1)
                                            : cart.splice(index, 1)
                                    "
                                    type="button"
                                    class="p-2 ms-2 text-xs text-center font-medium inline-flex items-center text-white bg-yellow-500 rounded-full hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300"
                                >
                                    <i class="fas fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal('ordering')">
                    Take me back
                </SecondaryButton>

                <PrimaryButton class="ms-3" @click="openModal('customer')">
                    Lanjut Pemesanan
                </PrimaryButton>
            </div>
        </div>
    </Modal>
    <Modal :show="confirmingCustomerDetail" @close="closeModal('customer')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Information Customer
            </h2>
            <div class="mt-6">
                <form @submit.prevent="submitOrder">
                    <div class="mt-2">
                        <InputLabel for="no_meja" value="Nomor Meja" />
                        <TextInput
                            id="no_meja"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.no_meja"
                            required
                            autofocus
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.no_meja"
                        />
                    </div>
                    <div class="mt-2">
                        <InputLabel for="nama_pemesan" value="Nama Pemesan" />
                        <TextInput
                            id="nama_pemesan"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nama_pemesan"
                            required
                            autofocus
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.nama_pemesan"
                        />
                    </div>
                    <div class="mt-2">
                        <InputLabel for="catatan" value="Catatan" />
                        <Textarea
                            id="catatan"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            v-model="form.catatan"
                        ></Textarea>
                        <InputError
                            class="mt-2"
                            :message="form.errors.nama_pemesan"
                        />
                    </div>
                    <div class="flex justify-end mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Lakukan Pemesanan
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </Modal>
    <div
        class="top-0 left-0 right-0 p-16 bg-custom-primary h-screen-75 rounded-b-full"
    >
        <div class="flex justify-center text-custom-light">
            <div class="font-bold uppercase mr-auto">
                <a href="index.html" class="text-xl"
                    ><i class="fas fa-user-ninja mr-2"></i>The
                    <span class="text-orange-600">Secret</span></a
                >
            </div>
            <div class="font-bold">
                <a href="#" class="py-2 px-5">Home</a>
                <a href="#order" class="py-2 px-5">Order</a>
                <a href="#contact" class="py-2 px-5">Contact</a>
            </div>
            <div class="ml-auto font-bold">
                <button
                    class="relative font-bold rounded-full bg-custom-secondary py-2 px-5 ml-2"
                >
                    <i class="fas fa-cart-plus"></i>
                    My Orders
                    <div
                        class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-custom-primary border-2 border-white rounded-full -top-2 -end-2"
                    >
                        {{ totalQty }}
                    </div>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12">
            <div
                class="lg:col-span-7 lg:ml-48 mt-12 lg:mt-32 text-center text-custom-light lg:text-left"
            >
                <span class="font-bold text-hero"> Kedai Kopi </span>
                <span
                    class="font-bold text-6xl block ml-auto mr-auto hidden xl:block"
                >
                    The Secret
                </span>
            </div>
            <div class="col-span-5 lg:mt-40 hidden md:block">
                <img :src="HeroCoffee" class="h-64 mx-auto lg:mx-0" />
            </div>
        </div>
    </div>
    <!--hero end-->
    <!--main start-->
    <div class="p-32" id="order">
        <div class="font-bold text-center text-custom-dark text-5xl">
            What's the mood?
        </div>
        <div
            class="grid grid-cols-2 gap-2 mt-12 font-bold text-center items-center text-lg"
        >
            <Link
                href="#coffee"
                class="bg-custom-primary rounded-xl py-6 w-full mx-auto"
            >
                <span class="bg-white p-4 rounded-full text-center"
                    ><i class="fas fa-coffee"></i
                ></span>
                <span class="block mt-5 text-custom-light">Coffee</span>
            </Link>
            <Link
                href="#drinks"
                class="bg-custom-primary rounded-xl py-6 w-full mx-auto"
            >
                <span class="bg-white p-4 rounded-full text-center"
                    ><i class="fas fa-cocktail"></i
                ></span>
                <span class="block mt-5 text-custom-light">Drinks</span>
            </Link>
        </div>
    </div>
    <!-- Coffee section -->
    <section class="mb-8 p-16 bg-dots-darker dark:bg-dots-lighter">
        <div>
            <span class="font-bold text-2xl md:text-4xl">Coffee</span
            ><img
                :src="CoffeeIcon"
                class="h-6 w-6 md:h-8 md:w-8 mb-3 ml-2 md:ml-5 inline-flex"
            />
        </div>
        <div class="mt-5 grid lg:grid-cols-5 sm:grid-cols-2 gap-16">
            <div
                v-for="(coffee, index) in coffees"
                :key="index"
                class="bg-white rounded-lg shadow-md p-3 hover:shadow-lg item"
            >
                <img
                    :src="coffee.image"
                    :alt="coffee.name"
                    class="w-full transform hover:scale-90 transition duration-300"
                />
                <div class="m-3 text-center">
                    <span class="font-bold text-xl">{{ coffee.name }}</span>
                    <span class="block text-gray-600 text-sm">{{
                        coffee.description
                    }}</span>
                    <span
                        class="block text-custom-yellow mt-3 font-bold text-xl"
                        >{{
                            new Intl.NumberFormat("id-ID", {
                                style: "currency",
                                currency: "IDR",
                            }).format(coffee.price)
                        }}</span
                    >
                </div>
                <PrimaryButton
                    @click="addToCart(coffee)"
                    id="coffee"
                    class="w-full flex justify-center"
                    >Add to Cart</PrimaryButton
                >
            </div>
        </div>
    </section>
    <!-- drinks section -->
    <section id="drinks" class="mb-8 p-16 bg-dots-darker dark:bg-dots-lighter">
        <div>
            <span class="font-bold text-2xl md:text-4xl">Drinks</span
            ><img
                :src="DrinksIcon"
                class="h-6 w-6 md:h-8 md:w-8 mb-3 ml-2 md:ml-5 inline-flex"
            />
        </div>
        <div class="mt-5 grid lg:grid-cols-5 sm:grid-cols-2 gap-16">
            <div
                v-for="(drink, index) in drinks"
                :key="index"
                class="bg-white rounded-lg shadow-md p-3 hover:shadow-lg item"
            >
                <img
                    :src="drink.image"
                    alt="drink"
                    class="w-full transform hover:scale-90 transition duration-300"
                />
                <div class="m-3 text-center">
                    <span class="font-bold text-xl">{{ drink.name }}</span>
                    <span class="block text-gray-600 text-sm">{{
                        drink.description
                    }}</span>
                    <span
                        class="block text-custom-yellow mt-3 font-bold text-xl"
                        >{{
                            new Intl.NumberFormat("id-ID", {
                                style: "currency",
                                currency: "IDR",
                            }).format(drink.price)
                        }}</span
                    >
                </div>
                <PrimaryButton
                    @click="addToCart(drink)"
                    id="coffee"
                    class="w-full flex justify-center"
                    >Add to Cart</PrimaryButton
                >
            </div>
        </div>
    </section>
    <!--contact start-->
    <div
        class="bottom-0 left-0 right-0 bg-custom-primary py-20 text-center text-custom-light"
        id="contact"
    >
        <span class="mt-12 font-bold text-5xl">Drop us a line</span>
        <form class="mt-10 w-1/2 mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                <input
                    type="text"
                    class="rounded-lg bg-gray-200 p-2"
                    placeholder="name"
                />
                <input
                    type="text"
                    class="rounded-lg bg-gray-200 p-2"
                    placeholder="email"
                />
            </div>
            <div class="mt-10">
                <textarea
                    class="rounded-lg bg-gray-200 p-2 w-full h-screen-25"
                    placeholder="message"
                ></textarea>
            </div>
            <div class="mt-6">
                <button
                    type="submit"
                    class="text-white text-xl hover:shadow-lg rounded-lg bg-custom-secondary px-5 py-2"
                >
                    Send
                </button>
            </div>
        </form>
        <hr class="mt-20 bg-gray-200 w-2/3 mx-auto" />
        <div class="flex justify-center w-2/3 mx-auto">
            <div class="font-bold mt-10 mr-auto">
                <span class="mx-5">
                    <a href="shortcodes.html"> Shrotcodes </a>
                </span>
                <span class="mx-5">
                    <a href="documentation.html"> Documentation </a>
                </span>
                <span class="mx-5">
                    <a href="https://github.com/panbak" target="_blank">
                        Author
                    </a>
                </span>
            </div>
            <div class="font-bold mt-10 ml-auto">&copy; Panos Bakas</div>
        </div>
    </div>
    <!--contact end-->
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
