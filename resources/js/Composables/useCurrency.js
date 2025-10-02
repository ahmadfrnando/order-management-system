// resources/js/composables/useCurrency.js
export function useCurrency(locale = "id-ID", currency = "IDR") {
  const formatCurrency = (value) => {
    if (isNaN(value)) return "Rp0";
    return new Intl.NumberFormat(locale, {
      style: "currency",
      currency,
    }).format(value);
  };

  return { formatCurrency };
}
