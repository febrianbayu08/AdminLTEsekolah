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

🔑 Fitur Login
📄 Halaman index.php (form login) memungkinkan pengguna untuk:

Masuk ke dalam sistem menggunakan username & password yang valid

Mendapatkan feedback jika:

Username tidak ditemukan ❌

Password salah ❌

🔐 Jika login berhasil:

Sistem menyimpan data penting pengguna dalam session seperti user_id, username, nama, dan role.

Pengguna langsung diarahkan ke halaman dashboard.php

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

