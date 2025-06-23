import './bootstrap';
import 'preline';

// Inisialisasi Preline setelah Livewire melakukan navigasi
document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.autoInit();
});

// JUGA inisialisasi saat pertama kali halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    window.HSStaticMethods.autoInit();
});
