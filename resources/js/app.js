import './bootstrap';
import 'preline';
import Swal from 'sweetalert2'

window.Swal = Swal

// Inisialisasi Preline setelah Livewire melakukan navigasi
document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.autoInit();
});

// JUGA inisialisasi saat pertama kali halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    window.HSStaticMethods.autoInit();
});
