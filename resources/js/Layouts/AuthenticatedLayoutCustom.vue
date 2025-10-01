<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <Head title="Dashboard" />

    <!-- hero start -->
    <div class="pt-16 px-10 grid lg:grid-cols-5 pb-20">
        <div
            class="bg-black opacity-50 z-20 top-0 bottom-0 left-0 right-0 fixed hidden"
            id="overlay"
        ></div>
        <!-- nav start -->
        <div class="lg:col-span-1">
            <nav>
                <div class="flex justify-between mb-6 px-2 md:mb-16">
                    <h1 class="font-bold uppercase">
                        <a href="index.html" class="text-xl"
                            ><i class="fas fa-user-ninja mr-2"></i>THE
                            <span class="text-red-700">SECRET</span></a
                        >
                    </h1>
                    <div class="px-4 cursor-pointer lg:hidden" id="open-menu">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
                <ul class="hidden lg:block mr-10 mb-10" id="menu">
                    <li class="my-3">
                        <SidebarLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            <i class="fas fa-shopping-basket mr-2"></i>
                            <span>Pesanan</span>
                        </SidebarLink>
                    </li>
                    <div class="mt-6">
                        <span class="px-3 text-gray-500">Akun</span>
                        <li class="my-3">
                            <a
                                class="rounded-lg py-2 px-3 text-md tracking-wider font-bold"
                                href="profile.html"
                            >
                                <i class="fas fa-key mr-2"></i>
                                <span>Ganti Password</span>
                            </a>
                        </li>
                    </div>
                </ul>
            </nav>
        </div>
        <!--nav end-->
        <main class="lg:col-span-4">
            <slot />
        </main>
        <aside
            class="transform top-0 right-0 w-full md:w-2/5 shadow-2xl bg-white fixed h-full overflow-auto ease-in-out transition-all duration-300 z-30 translate-x-full"
            id="side-panel"
        >
            <div class="p-8">
                <button
                    class="bg-gray-200 py-2 px-6 rounded-full"
                    id="close-side-panel"
                >
                    <i class="fas fa-times"></i>
                </button>
                <main class="text-center">
                    <img
                        src="images/burger.png"
                        alt="burger"
                        class="w-56 mx-auto mt-16 mb-8"
                    />
                    <span class="font-bold text-3xl">Bacon jammer</span>
                    <span class="block text-gray-600 text-sm"
                        >bacon, iceberg, mayo</span
                    >
                    <span
                        class="block text-custom-yellow mt-6 font-bold text-3xl"
                        >$ 3.50</span
                    >
                    <span class="block mt-8">
                        <input
                            type="text"
                            class="rounded-lg bg-gray-200 p-2"
                            placeholder="add a note.."
                        />
                    </span>
                    <button
                        class="rounded-lg bg-custom-yellow px-4 py-2 font-bold mt-6"
                    >
                        Add to Order
                    </button>
                </main>
            </div>
        </aside>

        <aside
            class="transform top-0 right-0 w-full md:w-2/5 shadow-2xl bg-white fixed h-full overflow-auto ease-in-out transition-all duration-300 z-30 translate-x-full"
            id="cart-panel"
        >
            <div class="p-8">
                <button
                    class="bg-gray-200 py-2 px-6 rounded-full"
                    id="close-cart-panel"
                >
                    <i class="fas fa-times"></i>
                </button>
                <main class="text-center font-bold">
                    <i class="fas fa-shopping-basket fa-3x mx-auto mt-10"></i>
                    <table class="table-auto mx-auto mt-10">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Item</th>
                                <th class="px-4 py-2">Quantity</th>
                                <th class="px-4 py-2">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2">Bacon Jammer</td>
                                <td class="border px-4 py-2">2x</td>
                                <td class="border px-4 py-2">$ 3.50</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">
                                    Pepperoni Lover
                                </td>
                                <td class="border px-4 py-2">3x</td>
                                <td class="border px-4 py-2">$ 1.00</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">
                                    Sanguine Refresher
                                </td>
                                <td class="border px-4 py-2">1x</td>
                                <td class="border px-4 py-2">$ 2.50</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-5 text-lg">
                        Total: <span class="text-custom-yellow">$12.50</span>
                    </div>
                    <button
                        class="rounded-lg bg-custom-yellow px-4 py-2 font-bold mt-6"
                    >
                        Order & Pay
                    </button>
                </main>
            </div>
        </aside>
    </div>
</template>
