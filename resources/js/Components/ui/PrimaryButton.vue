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
    class="inline-flex items-center px-5 py-2.5 rounded-full font-semibold text-sm shadow-md transition duration-200 ease-in-out 
           bg-gradient-to-r from-amber-700 to-yellow-600 text-white 
           hover:from-amber-800 hover:to-yellow-700 
           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 
           active:scale-95"
    :class="class"
  >
    <slot />
  </button>
</template>
