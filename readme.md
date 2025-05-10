# Servana – Sistem Manajemen Layanan TI Berbasis ITIL

## Ringkasan Proyek

Servana adalah aplikasi manajemen layanan TI internal yang dikembangkan berdasarkan kerangka kerja ITIL. Aplikasi berbasis web ini menyediakan modul untuk Manajemen Insiden, Permintaan Layanan, Manajemen Masalah, Pelaporan & Analitik, Manajemen Pengguna, dan Pemantauan Kinerja Real-Time. Backend menggunakan Laravel (PHP) dan frontend memakai Vue.js dengan Vuetify dan template Sneat. Servana dirancang untuk membantu tim TI mengelola siklus hidup layanan dengan efektif, transparan, dan sesuai praktik terbaik ITIL (misalnya menjaga kinerja layanan dan kepuasan pengguna).

## Arsitektur Sistem (C4 Model)

### Diagram Konteks

![Diagram konteks Servana (file `system-context.png`)](documentations/system-context.png)
&#x20;*Diagram konteks Servana (file `system-context.png`) menunjukkan entitas utama yang berinteraksi dengan sistem Servana. Servana berperan sebagai platform layanan TI internal yang menyediakan lingkungan pengembangan dan operasional stabil. Sistem ini berhubungan dengan tim pengguna internal (misalnya staf lapangan Posyandu) dan vendor IT pemeliharaan sistem. Diagram ini menegaskan batas sistem Servana dan peran eksternal seperti aplikasi layanan Posyandu serta tim Quality Assurance yang mengakses layanan Servana.*

### Diagram Kontainer

![Diagram kontainer Servana (file `container-overview.png`)](documentations/container-overview.png)
&#x20;*Diagram kontainer Servana (file `container-overview.png`) menggambarkan pembagian sistem ke dalam container utama: aplikasi Web, aplikasi API, dan database.*

* **Web Application**: Aplikasi antarmuka pengguna berbasis Vue.js (Vuetify dengan template Sneat) diakses oleh pengguna layanan (misalnya kader Posyandu atau remaja).
* **API Application**: Backend Laravel yang menangani semua logika bisnis dan menyediakan endpoint RESTful (API) untuk operasi data.
* **Database**: MySQL sebagai basis data relasional, menyimpan informasi insiden, permintaan, pengguna, dll., yang dibaca/ditulis oleh API melalui koneksi SQL (port 3306).

Web App berkomunikasi dengan API lewat protokol HTTPS/REST, dan API membaca/menulis data ke Database. Struktur ini memastikan pemisahan jelas antara antarmuka pengguna, logika bisnis, dan penyimpanan data.

## Fitur Utama

Seluruh fitur utama yang dibangun dalam aplikasi ini adalah di bawah ini:
[Fitur Utama](fitur.md)

## Cara Kontribusi

Kami menyambut kontribusi dari komunitas. Untuk mulai berkontribusi, lihat:

* [Panduan Kolaborasi](collaboration_guide.md) untuk alur pengembangan dan aturan kontribusi.
* [Kode Etik](code_of_conduct.md) untuk tata tertib dan etika proyek.

## Lisensi

Proyek ini dilisensikan di bawah **MIT License**. MIT adalah lisensi perangkat lunak bebas yang permisif dengan pembatasan minimal terhadap penggunaan ulang kode. Lihat file `LICENSE` untuk teks lengkap lisensi ini.

## Catatan Implementasi

* **Backend (Laravel)**: API disusun secara modular per fitur. Setiap modul (mis. Insiden, Permintaan) memiliki folder tersendiri untuk Model, Controller, Route, dll..
* **Frontend (Vue.js)**: Menggunakan *Single-File Components* (`.vue`) untuk menggabungkan template, logika, dan gaya dalam satu file. UI dibuat dengan Vuetify dan tema Sneat.
* **Database**: MySQL sebagai basis data relasional.
* **RESTful API**: Frontend berkomunikasi dengan backend melalui endpoint JSON (CRUD resources) menggunakan standar REST (data dikirim/diterima dalam format JSON).

Dengan struktur ini, Servana memberikan dokumentasi arsitektur yang jelas dan modul yang terpisah per fitur, sesuai dengan prinsip pengembangan perangkat lunak modern dan praktik ITIL.

**Referensi:** Dokumentasi ITIL dan praktik arsitektur C4.
