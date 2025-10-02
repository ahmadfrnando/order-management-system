import { ref, computed, watch } from "vue"

const cart = ref([])

// Load cart dari localStorage saat pertama kali composable dipakai
if (typeof window !== "undefined") {
  const savedCart = localStorage.getItem("cart")
  if (savedCart) {
    cart.value = JSON.parse(savedCart)
  }
}

// Simpan otomatis ke localStorage kalau ada perubahan
watch(cart, (newVal) => {
  localStorage.setItem("cart", JSON.stringify(newVal))
}, { deep: true })

export function useCart() {
  // ✅ tambah item
  function addToCart(item) {
    const found = cart.value.find(c => c.id === item.id)
    if (found) {
      found.qty += 1
    } else {
      cart.value.push({ ...item, qty: 1 })
    }
  }

  // ✅ kurangi qty
  function decreaseQty(item) {
    const found = cart.value.find(c => c.id === item.id)
    if (found) {
      found.qty -= 1
      if (found.qty <= 0) {
        removeFromCart(item.id)
      }
    }
  }

  // ✅ hapus item
  function removeFromCart(itemId) {
    cart.value = cart.value.filter(c => c.id !== itemId)
  }

  // ✅ reset semua
  function clearCart() {
    cart.value = []
  }

  // ✅ total qty & harga
  const totalQty = computed(() =>
    cart.value.reduce((sum, item) => sum + item.qty, 0)
  )

  const totalPrice = computed(() =>
    cart.value.reduce((sum, item) => sum + item.price * item.qty, 0)
  )

  return {
    cart,
    addToCart,
    decreaseQty,
    removeFromCart,
    clearCart,
    totalQty,
    totalPrice
  }
}
