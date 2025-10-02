export function useDate(locale = "id-ID") {
  const formatDate = (value) => {
    if (!value) return "-";
    return new Intl.DateTimeFormat(locale, {
      year: 'numeric',
      month: 'long',
      day: '2-digit',
    }).format(new Date(value));
  };

  return { formatDate };
}
