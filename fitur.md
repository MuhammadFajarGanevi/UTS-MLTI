### Manajemen Insiden

Modul ini digunakan untuk mencatat, melacak, dan menyelesaikan insiden (gangguan layanan) secepat mungkin. Tujuannya adalah mengembalikan layanan normal dengan cepat dan meminimalkan dampak bisnis. Setiap insiden akan didokumentasikan dan diupdate statusnya oleh tim TI.

Endpoint utama:

* `GET /api/v1/incidents` – daftar semua insiden.
* `POST /api/v1/incidents` – buat insiden baru.
* `GET /api/v1/incidents/{id}` – lihat detail insiden.
* `PUT /api/v1/incidents/{id}` – update data insiden.

Relasi modul:

* **Masalah**: Insiden berulang dapat di-escalate ke Manajemen Masalah.
* **Pengguna**: Informasi penanggung jawab insiden diambil dari Manajemen Pengguna.

Integrasi Dashboard:

* Menampilkan jumlah insiden terbuka, kategori, dan metrik waktu penyelesaian (SLA) pada dashboard layanan.

### Manajemen Permintaan Layanan

Modul ini memastikan permintaan layanan pengguna (misalnya reset password, akses aplikasi, atau permintaan peralatan) ditangani secara efisien sesuai kebutuhan bisnis. Setiap permintaan dicatat, diprioritaskan, dan diselesaikan dengan kolaborasi tim dukungan TI.

Endpoint utama:

* `GET /api/v1/requests` – daftar semua permintaan layanan.
* `POST /api/v1/requests` – buat permintaan layanan baru.
* `GET /api/v1/requests/{id}` – lihat detail permintaan.
* `PUT /api/v1/requests/{id}` – update status permintaan.

Relasi modul:

* **Pengguna**: Informasi pengguna pengaju dan approver di Manajemen Pengguna.
* **Pelaporan**: Statistik permintaan layanan diambil untuk laporan.

Integrasi Dashboard:

* Menampilkan jumlah permintaan per kategori dan status terkini pada dashboard analitik.

### Manajemen Masalah

Modul ini mengidentifikasi akar penyebab masalah dari insiden yang berulang atau berdampak besar. Tim melakukan investigasi untuk menemukan dan menerapkan solusi jangka panjang sehingga insiden serupa tidak terulang.

Endpoint utama:

* `GET /api/v1/problems` – daftar semua masalah.
* `POST /api/v1/problems` – buat entri masalah baru.
* `GET /api/v1/problems/{id}` – lihat detail masalah.
* `PUT /api/v1/problems/{id}` – update status atau solusi masalah.

Relasi modul:

* **Insiden**: Menghubungkan insiden terkait ke entri masalah.
* **Permintaan**: Jika solusi masalah menghasilkan permintaan perbaikan, modul permintaan layanan terkait.

Integrasi Dashboard:

* Grafik jumlah masalah yang terselesaikan, kategori akar masalah terbanyak, dan metrik penanganan ditampilkan pada dashboard.

### Pelaporan & Analitik

Modul ini mengumpulkan dan menyajikan data kinerja layanan (insiden, permintaan, masalah, dst.) dalam bentuk laporan dan grafik. Analisis membantu tim mengidentifikasi tren, pola, dan area perbaikan layanan (sesuai prinsip Continual Service Improvement ITIL).

Endpoint utama:

* `GET /api/v1/reports/summary` – ringkasan metrik kunci (jumlah insiden/permintaan, dsb.).
* `GET /api/v1/reports/incidents` – statistik insiden (per kategori, waktu rata-rata, dll.).
* `GET /api/v1/analytics/performance` – data analitik kinerja real-time (uptime, SLA, dll.).

Relasi modul:

* **Insiden, Permintaan, Masalah, Monitoring**: Menggabungkan data dari semua modul layanan untuk laporan terpadu.

Integrasi Dashboard:

* Menyediakan dashboard analitik interaktif dengan grafik tren insiden, KPI kinerja, dan metrik layanan lainnya.

### Manajemen Pengguna

Modul ini mengelola akun, otorisasi, dan profil pengguna sistem. Sesuai dengan proses **Access Management** ITIL, hanya pengguna yang berwenang yang dapat mengakses layanan tertentu. Pengelolaan peran dan hak akses dijalankan di sini untuk mendukung kontrol keamanan layanan.

Endpoint utama:

* `GET /api/v1/users` – daftar semua pengguna.
* `POST /api/v1/users` – buat akun pengguna baru.
* `GET /api/v1/users/{id}` – lihat profil pengguna.
* `PUT /api/v1/users/{id}` – update informasi atau hak akses pengguna.

Relasi modul:

* **Semua modul layanan**: Digunakan untuk otentikasi/otorisasi ketika mengakses insiden, permintaan, atau masalah.

Integrasi Dashboard:

* Menampilkan statistik pengguna aktif, distribusi peran, dan aktivitas login di bagian administrasi.

### Pemantauan Kinerja Real-Time

Modul ini memantau metrik kinerja sistem dan layanan secara langsung (misalnya respon API, beban server) dan menyediakan data real-time. Informasi ini mendukung proses **Pelaporan & Analisis** dengan data mutakhir untuk melakukan tindakan preventif atau penyesuaian layanan.

Endpoint utama:

* `GET /api/v1/metrics/system` – metrik real-time sistem (CPU, memori, dll.).
* `GET /api/v1/metrics/service` – metrik layanan (response time, uptime, throughput).

Relasi modul:

* **Pelaporan & Analitik**: Data monitoring real-time disediakan ke dashboard analitik.

Integrasi Dashboard:

* Grafik kesehatan sistem dan indikator kinerja (dashboard monitoring) diperbarui secara real-time di panel operasional.
