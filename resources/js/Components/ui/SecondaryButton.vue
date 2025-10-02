<script setup>
defineProps({
  type: {
    type: String,
    default: "button"
  },
  class: {
    type: String,
    default: ""
  }
})
</script>

<template>
  <button
    :type="type"
    class="inline-flex items-center px-5 py-2.5 rounded-full font-semibold text-sm 
           bg-white text-amber-700 border border-amber-700 
           hover:bg-amber-50 hover:border-amber-800 hover:text-amber-800
           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400
           disabled:opacity-50 transition duration-200 ease-in-out active:scale-95"
    :class="class"
  >
    <slot />
  </button>
</template>
