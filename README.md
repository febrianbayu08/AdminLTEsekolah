🛡️ Sistem Login & Register – Sistem Informasi Sekolah
Modul ini menyediakan sistem otentikasi sederhana namun aman, terdiri dari fitur Login, Register, dan Logout. Sistem ini memungkinkan hanya pengguna yang terdaftar (admin) untuk mengakses halaman dashboard dan fitur internal lainnya.

![image](https://github.com/user-attachments/assets/ea0d1e34-fcb7-4df4-8286-5f10850975cd)


🔐 Fitur Register
📄 Halaman register.php memungkinkan calon pengguna untuk:

Mendaftar akun baru sebagai Admin

Mengisi data seperti:

Nama lengkap 👤

Alamat email 📧

Username 🆔

Password 🔑 (dengan konfirmasi)

Pilihan role (default: admin)

✅ Validasi dilakukan untuk:

Semua field harus diisi

Email harus valid

Password minimal 6 karakter dan harus cocok dengan konfirmasi

Username & Email tidak boleh sama dengan yang sudah terdaftar

🛡️ Password akan disimpan dalam database dalam bentuk hash menggunakan algoritma bcrypt.


![image](https://github.com/user-attachments/assets/152aab98-90d9-414a-b59f-c6144779d4ae)


🔑 Fitur Login
📄 Halaman index.php (form login) memungkinkan pengguna untuk:

Masuk ke dalam sistem menggunakan username & password yang valid

Mendapatkan feedback jika:

Username tidak ditemukan ❌

Password salah ❌

🔐 Jika login berhasil:

Sistem menyimpan data penting pengguna dalam session seperti user_id, username, nama, dan role.

Pengguna langsung diarahkan ke halaman dashboard.php


----------------------------------------------------------------------------------------------------


🚪 Fitur Logout
📄 Halaman logout.php akan:

Menghapus semua session aktif

Menghancurkan session

Mengarahkan kembali ke halaman login

🧱 Struktur Tabel Database
Saat pertama kali halaman register dijalankan, sistem akan otomatis membuat tabel users jika belum tersedia. Tabel berisi:

Field	Tipe Data	Keterangan
id	INT, AUTO_INCREMENT	Primary Key
username	VARCHAR(50)	Unik, wajib
password	VARCHAR(255)	Terenkripsi dengan hash
nama	VARCHAR(100)	Nama lengkap admin
email	VARCHAR(100)	Unik, wajib
role	ENUM('admin')	Default role: admin
created_at	TIMESTAMP	Waktu pembuatan akun

🛠️ Teknologi Digunakan
💻 PHP 7+

💾 MySQL / MariaDB

🔐 Session-based authentication

🎨 Bootstrap 5 untuk antarmuka responsif

🔒 Keamanan
Input divalidasi dan disanitasi

Password disimpan dengan password_hash() dan diverifikasi dengan password_verify()

Session dicek sebelum mengakses halaman sensitif


---------------------------------------------------------------------------------------


📊 Dashboard – SMK N 6 Surakarta
Halaman Dashboard menyajikan tampilan ringkas (at‑a‑glance) dari seluruh data sekolah: siswa, jurusan, agama, dan pengguna. Dilengkapi grafik interaktif untuk membantu admin memahami distribusi data secara cepat dan intuitif.

![image](https://github.com/user-attachments/assets/2c0a902a-82d0-4f50-a400-b75ab56df93c)


✨ Sorotan Fitur
💎 Fitur	Deskripsi Singkat
🔢 Kartu Statistik	Menampilkan total Siswa, Jurusan, Agama, dan Users dalam kotak warna‑warni yang responsif.
📊 Bar Chart	Distribusi Siswa per Jurusan—mudah melihat jurusan terpopuler.
🥧 Pie Chart Overview	Ringkasan empat kategori utama (Siswa, Jurusan, Agama, Users) dalam satu grafik lingkaran.
🍩 Donut Chart	Distribusi Siswa per Agama agar keragaman siswa dapat dipantau.
🖱️ Sidebar Navigasi	Akses cepat ke Data, Tambah Data, Users, dan Profil.
🎨 Tema Responsif	Menggunakan AdminLTE v4 & Bootstrap 5—tampilan adaptive di desktop maupun perangkat seluler.

🔄 Alur Kerja Dashboard
Hitung Data

Dashboard memuat total setiap tabel (siswa, jurusan, agama, users).

Ambil Data Grafik

Query khusus menyiapkan dataset siswa‑per‑jurusan & siswa‑per‑agama.

Render Chart

Menggunakan ApexCharts untuk bar, pie, dan donut chart.

Tampilkan

Statistik dipasang di kartu, grafik di dalam panel kartu.

Tampilan menyesuaikan layar kecil (mobile‑friendly).

⚙️ Teknologi Pendukung
🐘 PHP & MySQL (klasik)

📚 AdminLTE v4 (Tema Dashboard Bootstrap 5)

🎨 Bootstrap 5 (UI responsif)

📈 ApexCharts (Grafik interaktif)

🌀 OverlayScrollbars (Scroll sidebar mulus)

💾 Session untuk autentikasi

🔐 Keamanan
Hanya pengguna login (dikonfirmasi via session) yang dapat mengakses dashboard.

Input dan query dijalankan lewat koneksi database terenkapsulasi.


-------------------------------------------------------------------------------


📘 Data Siswa – Sistem Informasi Sekolah
Halaman Data Siswa adalah pusat kendali untuk melihat, mencari, menambah, mengedit, dan menghapus informasi siswa di SMK Negeri 6 Surakarta. Dibangun dengan struktur modern, antarmuka responsif, dan sistem pencarian cepat.

![image](https://github.com/user-attachments/assets/e8834f59-92c5-4fc4-8a79-b26938f10d72)


🎯 Fitur Utama
🔍 Fitur	📄 Deskripsi
👥 Daftar Siswa	Menampilkan seluruh data siswa lengkap dengan kolom NISN, Nama, Jenis Kelamin, Jurusan, Kelas, Agama, dan Nomor HP.
🔎 Pencarian	Cari siswa dengan cepat berdasarkan nama atau kata kunci lain.
➕ Tambah Siswa	Tombol cepat untuk menambahkan data siswa baru.
🖊️ Edit Data	Akses tombol edit per baris untuk memperbarui informasi siswa.
🗑️ Hapus Data	Hapus data siswa secara langsung dengan konfirmasi aman.
📦 Sidebar Navigasi	Terintegrasi dengan sidebar AdminLTE untuk akses cepat ke halaman lain.

💡 Alur Penggunaan
🔐 Login Admin diperlukan untuk mengakses halaman.

🗃️ Data siswa ditarik dari database melalui class Database.

🔄 Jika ada kata kunci pencarian, sistem akan memfilter hasil berdasarkan input.

📋 Data ditampilkan dalam tabel responsif dengan scrollbar vertikal.

🧾 Admin dapat menambah, mengedit, atau menghapus data langsung dari antarmuka.

🧩 Teknologi yang Digunakan
🐘 PHP + MySQL untuk backend dan manajemen data.

🎨 Bootstrap 5 + AdminLTE 4 untuk tampilan modern dan mobile-friendly.

🧰 OverlayScrollbars untuk scroll sidebar yang lebih nyaman.

🎛️ Font & Icons dari Bootstrap Icons dan Source Sans Pro.

🛠️ Struktur Tabel
Tabel menampilkan kolom penting berikut:

No

NISN

Nama

Jenis Kelamin

Jurusan

Kelas

Alamat

Agama

No HP

Aksi (Edit / Hapus)

🧭 Navigasi
🔹 Navigasi sidebar terintegrasi mencakup:

Dashboard

Data Siswa

Data Jurusan

Data Agama

Tambah Data

Users

Profil

Logout


---------------------------------------------------------------------


✏️ Edit Data Siswa – Sistem Informasi Sekolah
Halaman Edit Siswa dirancang untuk memudahkan admin dalam memperbarui informasi siswa yang sudah terdaftar di SMK Negeri 6 Surakarta. Halaman ini bersifat aman, efisien, dan terintegrasi penuh dengan sistem.

![image](https://github.com/user-attachments/assets/82ef98f6-3af2-4277-8408-fa6ddc1bc1b0)


🎯 Fitur Utama
📌 Fitur	📄 Deskripsi
🆔 Autentikasi NISN	NISN digunakan sebagai parameter unik untuk identifikasi siswa dan ditampilkan secara readonly.
📋 Formulir Dinamis	Formulir diisi otomatis dengan data siswa saat ini berdasarkan NISN.
🧾 Dropdown Interaktif	Daftar jurusan dan agama diambil langsung dari database dan dipilihkan sesuai data siswa.
📦 Validasi Otomatis	Semua input wajib diisi sebelum dapat disimpan.
🔁 Redirect Otomatis	Jika NISN tidak ditemukan, akan diarahkan kembali ke halaman data siswa.

🧩 Komponen Form
Form ini terbagi menjadi dua kolom, masing-masing berisi:

Kolom Kiri:
🔢 NISN (readonly)

👤 Nama Lengkap

👨‍👩‍👧 Jenis Kelamin (L/P)

🧭 Jurusan

Kolom Kanan:
🏫 Kelas

📍 Alamat

🕊️ Agama

☎️ Nomor Telepon

📦 Alur Kerja
🔗 Akses halaman dengan parameter ?nisn=xxxx.

🔍 Data siswa diambil menggunakan method get_siswa_by_nisn().

🔄 Dropdown jurusan dan agama dibentuk dari tabel jurusan dan agama.

📝 Admin mengedit data sesuai kebutuhan.

💾 Klik tombol Simpan Perubahan untuk memperbarui.

✅ Jika berhasil, akan diarahkan kembali ke halaman datasiswa.php.

🛡️ Keamanan
⛔ Data tidak bisa diedit jika NISN tidak valid.

🔐 Validasi form dilakukan secara wajib (required).

🧹 Proteksi input untuk menghindari kesalahan umum.

🛠️ Teknologi
🌐 PHP + MySQL

🎨 Bootstrap 5

🧱 AdminLTE v4

🎯 OverlayScrollbars

📎 Catatan
Pastikan class Database memiliki method update_siswa() dan get_siswa_by_nisn().

Disarankan untuk menambahkan sanitasi/validasi tambahan pada level backend.


-----------------------------------------------------------------------------


🗑️ Hapus Data Siswa – Sistem Informasi Sekolah

![Screenshot 2025-06-11 175708](https://github.com/user-attachments/assets/b9a24c5c-408a-442c-ba4b-6bb9c5afb0dd)

Fitur ini digunakan untuk menghapus data siswa berdasarkan NISN secara aman dan langsung dari halaman antarmuka admin.

⚙️ Cara Kerja
🔗 Admin mengakses halaman hapus_siswa.php?nisn=XXXX.

✅ Sistem memeriksa apakah parameter nisn tersedia.

🧠 Fungsi hapus_siswa() pada class Database dijalankan.

💬 Jika berhasil, akan muncul pesan notifikasi berhasil.

❌ Jika gagal, akan muncul pesan kesalahan.

🔁 Seluruh proses menggunakan JavaScript alert dan otomatis diarahkan kembali ke halaman utama (index.php).

🧩 Fitur
🔍 Fitur	📄 Deskripsi
📌 Parameter NISN	Identifikasi unik siswa sebagai target penghapusan.
🔒 Validasi	Hanya dijalankan jika parameter nisn tersedia.
💬 Notifikasi Alert	Memberi informasi hasil aksi kepada admin.
🔁 Redirect Otomatis	Admin langsung diarahkan ke halaman awal setelah aksi selesai.

🚫 Perlindungan
Tidak akan mengeksekusi penghapusan jika nisn tidak tersedia.

Akses tanpa parameter akan langsung diarahkan ulang.

🧠 Catatan Tambahan
Disarankan menambahkan konfirmasi pengguna sebelum mengakses URL ini (misalnya via confirm() di tombol hapus).

Untuk keamanan yang lebih baik, sebaiknya:

🔑 Hanya admin yang bisa mengakses halaman ini.

🔐 Gunakan token CSRF di masa depan untuk proteksi tambahan.

📦 Kebutuhan
✅ Class Database harus memiliki method hapus_siswa($nisn) yang menghapus data dari database berdasarkan NISN.

🌐 Terhubung dengan file koneksi.php untuk koneksi database.


----------------------------------------------------------------------------------------


📚 Data Jurusan – Sistem Informasi Sekolah
Halaman ini digunakan untuk menampilkan, menambahkan, mengedit, dan menghapus daftar jurusan yang tersedia di sekolah secara interaktif dan responsif.

![image](https://github.com/user-attachments/assets/d59675d6-a4b6-4e54-9884-80e103ee4095)


🎯 Fitur Utama
✅ Fitur	📝 Deskripsi
📄 Menampilkan Data	Daftar semua jurusan yang tersedia ditampilkan dalam bentuk tabel.
➕ Tambah Jurusan	Admin dapat menambahkan jurusan baru ke dalam sistem.
✏️ Edit Jurusan	Admin dapat mengedit data jurusan secara langsung.
🗑️ Hapus Jurusan	Admin dapat menghapus data jurusan dengan konfirmasi terlebih dahulu.
🔍 Pencarian & Sortir	Tabel mendukung pencarian dan pengurutan data otomatis menggunakan DataTables.

⚙️ Cara Kerja
Data jurusan diambil dari database melalui method tampil_jurusan().

Jika parameter action=delete&id=... terdeteksi, maka sistem akan:

✅ Memanggil hapus_jurusan(id)

💬 Menampilkan pesan berhasil atau gagal

Tabel ditampilkan menggunakan DataTables dengan fitur pencarian, paginasi, dan styling Bootstrap 5.

Tombol aksi menggunakan ikon Bootstrap:

✏️ Edit → membuka halaman editjurusan.php

🗑️ Hapus → muncul konfirmasi JavaScript alert sebelum dihapus

💡 Catatan Tambahan
🚨 Konfirmasi sebelum menghapus untuk mencegah kehilangan data tidak sengaja.

🔐 Idealnya hanya user dengan peran admin yang bisa mengakses halaman ini.

📦 Integrasi sidebar dan topbar mengikuti gaya layout AdminLTE 4.

📦 Kebutuhan
File/folder yang harus tersedia:

Database class (dengan method hapus_jurusan() dan tampil_jurusan())

File sidebar: ../navbar/sidebar.php

Bootstrap 5 & DataTables CDN

File editjurusan.php dan tambahjurusan.php

🧠 UX Design
✅ Layout responsif dan ramah pengguna

🔍 Kolom dapat dicari secara real-time

⚙️ Scrollbar dikustomisasi untuk tampilan modern

----------------------------------------------------------------------


✏️ Edit & 🗑️ Hapus Jurusan – Sistem Informasi Sekolah
Halaman dan skrip ini digunakan untuk melakukan pengeditan dan penghapusan data jurusan pada sistem informasi sekolah berbasis web.

🛠️ Edit Jurusan
🎯 Fungsi
Memungkinkan admin untuk memperbarui kode jurusan dan nama jurusan yang telah terdaftar.

🧩 Alur Kerja
✅ Data jurusan diambil berdasarkan parameter id (kodejurusan) dari URL.

📄 Form ditampilkan dengan data jurusan yang sudah ada.

✏️ Admin dapat mengubah kode atau nama jurusan.

💾 Setelah menekan "Simpan Perubahan", data akan diperbarui ke database menggunakan method update_jurusan().

✅ Redirect kembali ke halaman daftar jurusan setelah berhasil.

⚠️ Validasi
Jika parameter id tidak tersedia atau data tidak ditemukan, pengguna langsung diarahkan kembali ke datajurusan.php.

🗑️ Hapus Jurusan
📂 File: hapus_jurusan.php
🧩 Alur Kerja
Parameter kodejurusan diterima melalui $_GET.

SQL DELETE FROM jurusan WHERE kodejurusan = ... dijalankan.

🔍 Setelah penghapusan:

Sistem mengecek apakah tabel jurusan kosong.

Jika kosong, AUTO_INCREMENT akan di-reset ke 1.

🔄 Redirect:

Jika tersedia, pengguna diarahkan ke halaman sebelumnya.

Jika tidak, diarahkan ke halaman data_jurusan.php.

⚠️ Validasi
Menampilkan pesan error jika kodejurusan tidak diberikan atau query gagal.


------------------------------------------------------------------------------


📋 Halaman Data Agama – Sistem Informasi Sekolah
Halaman ini berfungsi sebagai pusat pengelolaan daftar agama yang digunakan dalam data siswa di sistem sekolah.

![image](https://github.com/user-attachments/assets/057dd02b-3f74-4aeb-83f2-313502c75d99)


🎯 Tujuan Halaman
Halaman ini memungkinkan admin untuk:

🧾 Menampilkan seluruh daftar agama

➕ Menambahkan data agama baru

✏️ Mengedit nama agama yang sudah ada

🗑️ Menghapus data agama yang tidak diperlukan

🔍 Melakukan pencarian dan filter data dengan mudah

⚙️ Cara Kerja
Data ditampilkan dalam bentuk tabel yang rapi dan interaktif berkat integrasi dengan DataTables.

Setiap baris memiliki tombol aksi untuk edit dan hapus.

Terdapat fitur konfirmasi sebelum menghapus agar tidak terjadi kesalahan.

Pesan sukses ✅ atau gagal ❌ akan muncul setelah melakukan aksi, untuk memberi tahu status perubahan.

📌 Catatan Penting
Data agama ini biasanya digunakan sebagai pilihan dalam formulir siswa. Jadi, pastikan tidak menghapus agama yang sedang digunakan oleh data siswa aktif.

Sistem ini dirancang agar mudah digunakan oleh admin, dengan tampilan responsif dan ikon yang intuitif.


-------------------------------------------------------------------------------------------------------------------------------------------------------------


✏️ Halaman Edit Agama & 🗑️ Proses Hapus Agama
✨ Fungsi Halaman Edit Agama
Halaman ini dibuat agar admin dapat melakukan perubahan pada data agama yang sudah tercatat sebelumnya.

🔧 Fitur yang tersedia:

Menampilkan formulir dengan informasi agama berdasarkan ID (kode agama).

Memungkinkan admin mengganti nama agama atau kode agama.

Menyimpan perubahan langsung ke database saat tombol Simpan Perubahan diklik.

Jika terjadi kesalahan saat update, akan muncul notifikasi ❗.

📌 Catatan:

Setelah berhasil diperbarui, admin akan otomatis diarahkan kembali ke halaman daftar agama.

Jika data tidak ditemukan, sistem otomatis kembali ke halaman sebelumnya.

🗑️ Fitur Penghapusan Data Agama
Data agama juga bisa dihapus dari sistem melalui tombol hapus di halaman daftar agama.

🔍 Alur penghapusan:

Sistem memeriksa apakah kodeagama tersedia.

Jika ya, dicek apakah data tersebut benar-benar ada di database.

Jika data ditemukan ✅, maka akan dihapus.

Jika tidak ditemukan ❌, ditampilkan pesan "Agama tidak ditemukan!".

📢 Setelah penghapusan:

Admin diarahkan kembali ke halaman utama daftar agama.

Tidak ada penghapusan jika kodeagama tidak dikirim atau tidak valid.

⚠️ Penting untuk Diingat
Agama yang sedang digunakan dalam data siswa sebaiknya tidak dihapus.

Fitur ini harus digunakan dengan hati-hati untuk menjaga integritas data siswa.


-------------------------------------------------------------------------------------


👥 Halaman Data Users (Admin)

![image](https://github.com/user-attachments/assets/5642bdbc-6011-47f8-8f3e-757063f31fdf)

Halaman ini bertugas menampilkan daftar semua akun pengguna (users) yang ada dalam sistem 🔐. Admin bisa:

🕵️‍♂️ Melihat informasi penting seperti username, nama lengkap, email, role, dan waktu dibuat.

🔍 Mencari user berdasarkan kata kunci (username/nama/email).

🗑️ Menghapus user langsung dari daftar.

📋 Melihat data dalam tabel yang responsif dan mudah dinavigasi.

🔎 Fitur Pencarian
Di bagian atas daftar user, tersedia kolom pencarian agar admin bisa dengan cepat menemukan user tertentu.
✅ Ketik nama/email/username → klik cari 🔍
❌ Klik ikon silang untuk menghapus pencarian dan menampilkan semua data kembali.

🗑️ Fitur Hapus
Setiap baris user memiliki tombol hapus berwarna merah.
Saat ditekan:

Muncul konfirmasi: "Yakin ingin menghapus user ini?"

Jika setuju, data user akan langsung dihapus dari database.

✅ Jika berhasil: muncul pesan hijau.

❌ Jika gagal: muncul pesan merah.

📋 Tampilan Tabel
Header tabel tetap terlihat (sticky) meski kamu scroll ke bawah.

Data ditampilkan dengan rapi, mulai dari ID hingga waktu pembuatan akun.

Tombol aksi tersedia di ujung kanan untuk tiap user.

💡 Kesan Admin
Fitur ini sangat cocok untuk manajemen user karena:

Mudah digunakan 🖱️

Tersedia pencarian instan 🔍

Desain modern dan responsif 🌐

Aman karena ada konfirmasi saat menghapus 🛡️


-----------------------------------------------------------------------------


👤 Halaman Profil Admin
Halaman ini dirancang khusus untuk pengguna yang sedang login agar bisa:

🔍 Melihat detail akun mereka (nama, email, role, tanggal bergabung).

🔐 Mengganti password dengan aman dan mudah.

👑 Informasi Akun
Di bagian kiri tampil kartu profil cantik 🎨:

Foto profil (ikon default user 👤).

Nama pengguna, username, dan role (misalnya "admin", "siswa", dsb).

Informasi kapan akun dibuat (contoh: "Member since Jan 2024").

🟦 Di bagian kanan tersedia info lengkap berupa:

Username

Nama Lengkap

Email

Role (dengan badge warna biru)

Tanggal bergabung (dengan waktu)

Semua data ditampilkan secara readonly, hanya untuk dilihat 👁️.

🔒 Fitur Ubah Password
Form ini dilengkapi:

Input password lama

Input password baru (min. 6 karakter)

Konfirmasi password baru

💡 Dilengkapi juga dengan:

👁️ Tombol untuk melihat/menyembunyikan password (bi-eye).

✅ Validasi langsung saat mengetik: jika password terlalu pendek atau konfirmasi tidak cocok, akan muncul tanda merah.

Jika berhasil:

✅ Muncul pesan hijau "Password berhasil diubah!"
Jika gagal:

❌ Muncul pesan merah, contohnya "Password lama salah!" atau "Konfirmasi tidak cocok!"

🛠️ Keamanan & UX
Password disimpan dalam format hash (aman dari pencurian data).

Validasi berjalan baik, tidak bisa submit sembarangan.

Fitur password_verify() dan password_hash() memastikan keamanan backend 🔐.

User yang belum login akan otomatis diarahkan ke halaman login 👮‍♂️.

🎨 Desain
Warna cerah, gradien ungu-biru pada kartu profil 💜💙.

Tabel dan form di-wrap dalam card bergaya Bootstrap 5.

Scrollbar disesuaikan agar halus dan menyatu dengan tema.

![image](https://github.com/user-attachments/assets/0a2c014b-7805-4fd7-a8d3-f0d815a9574e)


