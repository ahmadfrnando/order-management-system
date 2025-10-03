<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, computed, onMounted, watch } from "vue";
import HeroCoffee from "@/assets/images/coffee-hero.png";
import CoffeeIcon from "@/assets/icons/coffee-icon.png";
import DrinksIcon from "@/assets/icons/drinks-icon.png";
import CartModal from "@/Components/CartModal.vue";
import { useToast } from "@/Composables/useToast";
import ProductCard from "@/Components/ProductCard.vue";
import { useCart } from "@/Composables/useCart";
import CustomerDetailModal from "@/Components/CustomerDetailModal.vue";

const page = usePage();
const { toast } = useToast();
const {
    cart,
    addToCart,
    decreaseQty,
    removeFromCart,
    clearCart,
    totalQty,
    totalPrice,
} = useCart();

const form = useForm({
    nama_pemesan: "",
    no_meja: "",
    catatan: "",
    items: [],
});

function submitOrder(customerData) {
    console.log(customerData.no_meja);
    form.no_meja = customerData.no_meja;
    form.nama_pemesan = customerData.nama_pemesan;
    form.catatan = customerData.catatan;
    form.items = cart.value;
    form.post("/orders", {
        onSuccess: () => {
            form.reset();
            clearCart();
            closeModal("ordering");
            closeModal("customer");
        },
    });
}

watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.message) {
            toast(flash.message, flash.type || "info");
        }
    },
    { immediate: true }
);

const activeModal = ref(null);
const openModal = (modal) => (activeModal.value = modal);
const closeModal = () => (activeModal.value = null);
// onMounted(() => {
//     const savedCart = localStorage.getItem("cart");
//     if (savedCart) {
//         cart.value = JSON.parse(savedCart);
//     }
// });

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

// const cart = ref([]);
// function addToCart(items) {
//     const item = cart.value.find((c) => c.name === items.name);
//     if (item) {
//         item.qty += 1;
//     } else {
//         cart.value.push({
//             ...items,
//             qty: 1,
//         });
//     }
// }

// watch(
//     cart,
//     (newVal) => {
//         localStorage.setItem("cart", JSON.stringify(newVal));
//     },
//     { deep: true }
// );

// const totalQty = computed(() => {
//     return cart.value.reduce((sum, item) => sum + item.qty, 0);
// });

// function submitOrder() {
//     form.items = cart.value;

//     form.post("/orders", {
//         onSuccess: () => {
//             form.reset();
//             cart.value = [];
//             closeModal("ordering");
//             closeModal("customer");
//         },
//         onError: (errors) => {
//             console.error(errors);
//         },
//     });
// }
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
    <CartModal
        :show="activeModal === 'ordering'"
        :cart="cart"
        @close="closeModal('ordering')"
        @addItem="addToCart"
        @decreaseItem="decreaseQty"
        @removeItem="removeFromCart"
        @openCustomer="openModal('customer')"
    />
    <CustomerDetailModal
        :show="activeModal === 'customer'"
        @close="closeModal('customer')"
        @submit="submitOrder"
    />

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
            <ProductCard
                v-for="(coffee, index) in coffees"
                :key="index"
                :product="coffee"
                @add="addToCart"
            />
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
            <ProductCard
                v-for="(drink, index) in drinks"
                :key="index"
                :product="drink"
                @add="addToCart"
            />
        </div>
    </section>
    <!--contact start-->
    <section id="contact">
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
    </section>
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
