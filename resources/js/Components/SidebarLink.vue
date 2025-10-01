<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'rounded-lg py-2 px-3 text-md tracking-wider font-bold bg-custom-yellow block transition duration-150 ease-in-out'
        : 'rounded-lg py-2 px-3 text-md tracking-wider font-bold transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
