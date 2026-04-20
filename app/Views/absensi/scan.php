<?= view('layout/header', ['title' => 'Scan Kehadiran']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .card-scan { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto; text-align: center; }
    #reader { width: 100%; border-radius: 10px; overflow: hidden; border: 2px solid #1e5631; }
    .scan-instruction { margin-bottom: 20px; color: #555; }
</style>

<div class="card-scan">
    <h3 style="margin-top:0; color:#1e5631;"><i class="fas fa-camera"></i> Kamera Pemindai Kehadiran</h3>
    <p class="scan-instruction">Arahkan QR Code Siswa/Guru/Staf ke layar kamera untuk mencatat jam masuk.</p>
    
    <div id="reader"></div>
</div>

<script>
    // 1. Inisialisasi Scanner
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false
    );

    // 2. Fungsi yang dijalankan SAAT QR Code BERHASIL TERBACA
    function onScanSuccess(decodedText, decodedResult) {
        
        // Hentikan sementara scanner agar tidak men-scan berulang-ulang
        html5QrcodeScanner.pause();

        // Tampilkan loading
        Swal.fire({ title: 'Memproses data...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });

        // Kirim data ke Controller menggunakan Fetch API (AJAX)
        let formData = new FormData();
        formData.append('qr_data', decodedText);

        fetch('<?= base_url('absensi/proses_scan') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                // Notifikasi Sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Kehadiran Tercatat!',
                    html: `<b>${data.nama}</b><br><small>${data.role}</small>`,
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => { html5QrcodeScanner.resume(); }); // Lanjutkan scan
            } 
            else if(data.status === 'warning') {
                // Notifikasi Sudah Absen
                Swal.fire({ icon: 'warning', title: 'Sudah Absen', text: data.message })
                .then(() => { html5QrcodeScanner.resume(); });
            } 
            else {
                // Notifikasi Gagal/Tidak Terdaftar
                Swal.fire({ icon: 'error', title: 'Akses Ditolak', text: data.message })
                .then(() => { html5QrcodeScanner.resume(); });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error').then(() => { html5QrcodeScanner.resume(); });
        });
    }

    function onScanFailure(error) {
        // Abaikan peringatan ini, ini hanya proses pencarian QR yang terus berjalan
    }

    // 3. Render kamera ke dalam tag div id="reader"
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

<?= view('layout/footer') ?>