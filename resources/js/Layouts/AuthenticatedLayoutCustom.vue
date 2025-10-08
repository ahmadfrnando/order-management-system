<script setup>
import { watch, onMounted, computed } from "vue";
import { Link, Head, usePage, router } from "@inertiajs/vue3";
import SidebarLink from "@/Components/SidebarLink.vue";
import { useToast } from '@/Composables/useToast';
import { useCurrency } from "@/Composables/useCurrency";

const { formatCurrency } = useCurrency()


// onMounted(() => {
//   setInterval(() => {
//     router.reload({ only: ['global'] })
//   }, 1000)
// })

const page = usePage()
const { toast } = useToast()

const totalPesanan = computed(() => page.props.global.total_pesanan)
const totalHarga = computed(() => page.props.global.total_harga)

watch(
  () => page.props.flash,
  (flash) => {
    if (flash?.message) {
      toast(flash.message, flash.type || 'info')
    }
  },
  { immediate: true }
)

watch(
    () => page.props.confirmation,
    (confirmation) => {
        if (confirmation?.message) {
            if (confirm(confirmation.message)) {
                window.location.href = confirmation.link
            }
        }
    },
    { immediate: true }
)

const sidebarMenu = [
  {
    name: "Pesanan",
    href: route("dashboard"),
    active: route().current('dashboard') || route().current('pesanan.*'),
    icon: "fas fa-shopping-basket",
  },
  {
    name: "Riwayat",
    href: route("riwayat.index"),
    active: route().current('riwayat.*'),
    icon: "fas fa-history",
  },
  {
    name: "Kelola Menu",
    href: route("menu.index"),
    active: route().current('menu.*'),
    icon: "fas fa-coffee",
  },
]
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
                    <li class="my-3 mb-5" v-for="(menu, i) in sidebarMenu" :key="i">
                        <SidebarLink
                            :href="menu.href"
                            :active="menu.active"
                        >
                            <i :class="menu.icon" class="mr-2"></i>
                            <span>{{ menu.name }}</span>
                        </SidebarLink>
                    </li>
                </ul>
            </nav>
        </div>
        <!--nav end-->
        <main class="lg:col-span-4">
            <div class="flex justify-center md:justify-end">
                <div class="mr-auto">
                    <slot name="title" />
                </div>
                <button
                    class="font-bold rounded-full bg-white mr-2 py-2 px-3 shadow sm:block hidden cart"
                >
                    <i class="fas fa-shopping-basket"></i> {{ totalPesanan }} items - {{ formatCurrency(totalHarga) }}
                </button>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="font-bold rounded-full bg-gray-300 py-2 px-3 ml-2"
                    ><i class="fas fa-sign-out-alt"></i>Logout</Link
                >
            </div>
            <button
                class="font-bold rounded-full bg-white mr-2 py-2 px-3 shadow block sm:hidden mt-5 w-full cart"
            >
                <i class="fas fa-shopping-basket mr-3"></i> {{ totalPesanan }} items - {{ formatCurrency(totalHarga) }}
            </button>
            <slot />
        </main>
    </div>
</template>
