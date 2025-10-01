import Swal from 'sweetalert2'

export function useToast() {
  const toast = (message, type = 'success') => {
    Swal.fire({
      icon: type,
      title: message,
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2500,
      timerProgressBar: true,
    })
  }

  return { toast }
}
