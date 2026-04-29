<?= view('layout/header', ['title' => 'Scan Kehadiran']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .card-scan { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto; text-align: center; }
    
    .scan-header { margin-bottom: 25px; }
    .scan-instruction { color: #555; margin-top: 5px; }
    
    .scan-body { display: flex; flex-wrap: wrap; gap: 25px; align-items: flex-start; justify-content: center; }
    
    .scan-camera { flex: 1; min-width: 300px; }
    #reader { width: 100%; border-radius: 10px; overflow: hidden; border: 2px solid #1e5631; }
    
    .scan-note { 
        flex: 0 0 250px; 
        background-color: #fff3cd; 
        color: #856404; 
        padding: 20px; 
        border-radius: 8px; 
        border-left: 5px solid #ffc107; 
        text-align: left;
        font-size: 14px;
        line-height: 1.6;
    }
    .scan-note h4 { margin: 0 0 10px 0; color: #856404; font-weight: bold; }
    .scan-note i { font-size: 24px; color: #ffc107; margin-bottom: 10px; display: block; }

    /* CSS Tambahan untuk Timer Skripsi */
    .timer-box {
        background-color: #e9ecef;
        border: 2px solid #6c757d;
        padding: 10px 20px;
        border-radius: 50px;
        display: inline-block;
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }
    .timer-box span { color: #dc3545; font-size: 22px; }
    .btn-reset-timer {
        background: #6c757d; color: white; border: none; padding: 5px 15px; border-radius: 4px; cursor: pointer; font-size: 12px; margin-left: 10px; vertical-align: middle;
    }
</style>

<div class="card-scan">
    <div class="scan-header">
        <h3 style="margin-top:0; color:#1e5631;"><i class="fas fa-camera"></i> Kamera Pemindai Kehadiran</h3>
        <p class="scan-instruction">Arahkan QR Code Siswa/Guru/Staf ke layar kamera untuk mencatat presensi.</p>
    </div>
    
    <div class="scan-body">
        <div class="scan-camera">
            
            <div class="timer-box">
                <i class="fas fa-stopwatch"></i> Waktu Scan: <span id="scan-timer">0.00</span> dtk
                <button onclick="resetTimerManual()" class="btn-reset-timer"><i class="fas fa-sync"></i> Reset Uji</button>
            </div>

            <div id="reader"></div>
        </div>

        <div class="scan-note">
            <i class="fas fa-info-circle"></i>
            <h4>Petunjuk Pemindaian:</h4>
            <p>Mohon untuk dipaskan tepat di dalam kotak hijau (*scan area*).</p>
            <p>Pastikan kartu <strong>tidak terlalu jauh</strong> dan <strong>tidak terlalu dekat</strong> dari kamera agar QR Code dapat terbaca dengan cepat.</p>
        </div>
    </div>
</div>

<script>
    // --- VARIABEL TIMER ---
    let startTime = Date.now();
    let timerInterval;
    let timeElapsed = 0;

    // Fungsi Menjalankan Stopwatch
    function startTimer() {
        startTime = Date.now();
        timerInterval = setInterval(() => {
            timeElapsed = ((Date.now() - startTime) / 1000).toFixed(2);
            document.getElementById('scan-timer').innerText = timeElapsed;

            // Logika Revisi: Jika lebih dari 30 detik, munculkan Warning
            if (timeElapsed >= 30.00) {
                clearInterval(timerInterval); // Hentikan hitungan
                html5QrcodeScanner.pause();   // Jeda kamera

                Swal.fire({
                    icon: 'warning',
                    title: 'Batas Waktu Terlampaui!',
                    text: 'Pemindaian gagal karena melebihi 30 detik. Tingkat kerusakan QR Code mungkin terlalu tinggi (> 30%) atau pencahayaan kurang.',
                    confirmButtonText: 'Ulangi Pemindaian',
                    confirmButtonColor: '#d33'
                }).then(() => {
                    resetTimerManual(); // Reset waktu ke 0
                    html5QrcodeScanner.resume(); // Lanjutkan kamera
                });
            }
        }, 50); // Update angka setiap 50 milidetik agar terlihat mulus
    }

    // Fungsi Tombol Reset Uji Skripsi
    function resetTimerManual() {
        clearInterval(timerInterval);
        document.getElementById('scan-timer').innerText = "0.00";
        startTimer();
    }

    // 1. Inisialisasi Scanner
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false
    );

    // 2. Fungsi yang dijalankan SAAT QR Code BERHASIL TERBACA
    function onScanSuccess(decodedText, decodedResult) {
        
        // Catat Waktu Akhir Scan
        let finalTime = timeElapsed;
        
        // Hentikan sementara scanner dan timer
        html5QrcodeScanner.pause();
        clearInterval(timerInterval);

        // Tampilkan loading
        Swal.fire({ title: 'Memproses data...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });

        // Kirim data ke Controller menggunakan Fetch API
        let formData = new FormData();
        formData.append('qr_data', decodedText);

        fetch('<?= base_url('absensi/proses_scan') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                // Notifikasi Sukses + Menampilkan Waktu Scan
                Swal.fire({
                    icon: 'success',
                    title: data.title,
                    html: `<b>${data.nama}</b><br><small>${data.role}</small>
                           <hr style="margin:10px 0; border-top:1px dashed #ccc;">
                           <span style="color:#28a745; font-weight:bold;"><i class="fas fa-check-circle"></i> Berhasil dibaca dalam: ${finalTime} detik</span>`,
                    confirmButtonColor: '#1e5631',
                    confirmButtonText: 'Lanjut Scan'
                }).then(() => { 
                    resetTimerManual();
                    html5QrcodeScanner.resume(); 
                });
            } 
            else if(data.status === 'warning') {
                Swal.fire({ icon: 'warning', title: 'Sudah Absen', text: data.message })
                .then(() => { resetTimerManual(); html5QrcodeScanner.resume(); });
            } 
            else {
                Swal.fire({ icon: 'error', title: 'Akses Ditolak', text: data.message })
                .then(() => { resetTimerManual(); html5QrcodeScanner.resume(); });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error')
            .then(() => { resetTimerManual(); html5QrcodeScanner.resume(); });
        });
    }

    function onScanFailure(error) {
        // Biarkan kosong, ini hanya loop pencarian QR
    }

    // 3. Render kamera & Mulai Timer
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    
    // Jalankan timer pertama kali saat halaman dimuat
    startTimer();
</script>

<?= view('layout/footer') ?>