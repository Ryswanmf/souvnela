// Floating WhatsApp script (CodeIgniter 4 version)
document.addEventListener("DOMContentLoaded", function () {
    // === KONFIGURASI ===
    const phoneNumber = settings.general.whatsapp_number || "6282183150556"; // Nomor WhatsApp kamu (format internasional tanpa + atau 0)
    const defaultMessage = settings.general.whatsapp_message || "Halo Souvnela, saya tertarik dengan produk souvenir Polinela."; 

    // Bangun URL WhatsApp
    const encodedMsg = encodeURIComponent(defaultMessage);
    const waUrl = `https://wa.me/${phoneNumber}?text=${encodedMsg}`;
    
    // Set link ke tombol
    const waLink = document.getElementById("wa-link");
    if (waLink) waLink.href = waUrl;
});
