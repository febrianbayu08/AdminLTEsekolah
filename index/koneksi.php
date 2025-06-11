<?php
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "sekolah";
    private $koneksi;

    function __construct()
    {
        // Koneksi ke MySQL tanpa memilih database dulu
        $this->koneksi = new mysqli($this->host, $this->username, $this->password);

        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }

        // Inisialisasi database dan tabel jika belum ada
        $this->initDatabase();

        // Pilih database yang telah dibuat
        $this->koneksi->select_db($this->database);
    }

    private function initDatabase()
    {
        // Membuat database jika belum ada
        $queryDB = "CREATE DATABASE IF NOT EXISTS {$this->database}";
        $this->koneksi->query($queryDB);

        // Pilih database
        $this->koneksi->select_db($this->database);

        // Membuat tabel jurusan
        $queryJurusan = "CREATE TABLE IF NOT EXISTS jurusan (
            kodejurusan INT PRIMARY KEY AUTO_INCREMENT,
            namajurusan VARCHAR(50) NOT NULL
        )";
        $this->koneksi->query($queryJurusan);

        // Membuat tabel agama
        $queryAgama = "CREATE TABLE IF NOT EXISTS agama (
            kodeagama INT PRIMARY KEY AUTO_INCREMENT,
            agama VARCHAR(50) NOT NULL
        )";
        $this->koneksi->query($queryAgama);

        // Membuat tabel siswa
// Membuat tabel siswa (dengan tipe data yang benar untuk foreign key)
        $querySiswa = "CREATE TABLE IF NOT EXISTS siswa (
    nisn VARCHAR(15) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jeniskelamin ENUM('L', 'P') NOT NULL,
    kodejurusan INT NOT NULL,  -- Ubah dari VARCHAR(10) ke INT agar cocok dengan jurusan
    kelas VARCHAR(10) NOT NULL,
    alamat TEXT NOT NULL,
    agama INT NOT NULL,
    nohp VARCHAR(15) NOT NULL,
    FOREIGN KEY (kodejurusan) REFERENCES jurusan(kodejurusan) ON DELETE CASCADE,
    FOREIGN KEY (agama) REFERENCES agama(kodeagama) ON DELETE CASCADE
    )";

        $this->koneksi->query($querySiswa);
    }

    public function getKoneksi()
    {
        return $this->koneksi;
    }

    function tampil_data_siswa()
    {
        $query = "SELECT 
                    s.nisn, 
                    s.nama, 
                    s.jeniskelamin, 
                    j.namajurusan AS jurusan,
                    s.kelas, 
                    s.alamat, 
                    a.agama AS agama,
                    s.nohp
                  FROM siswa s
                  INNER JOIN jurusan j ON s.kodejurusan = j.kodejurusan
                  INNER JOIN agama a ON s.agama = a.kodeagama";

        $result = $this->koneksi->query($query);

        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "Error: " . $this->koneksi->error;
        }

        return $data;
    }

    public function tambah_siswa($nisn, $nama, $jeniskelamin, $kodejurusan, $kelas, $alamat, $agama, $nohp)
    {
        $stmt = $this->koneksi->prepare("INSERT INTO siswa (nisn, nama, jeniskelamin, kodejurusan, kelas, alamat, agama, nohp) 
                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $nisn, $nama, $jeniskelamin, $kodejurusan, $kelas, $alamat, $agama, $nohp);
        return $stmt->execute();
    }

    public function get_siswa_by_nisn($nisn)
    {
        $sql = "SELECT * FROM siswa WHERE nisn = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nisn);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update_siswa($nisn, $nama, $jeniskelamin, $kodejurusan, $kelas, $alamat, $agama, $nohp)
    {
        $jeniskelamin = ($jeniskelamin == "Laki-laki") ? "L" : "P";
        $sql = "UPDATE siswa SET 
                    nama = ?, 
                    jeniskelamin = ?, 
                    kodejurusan = ?, 
                    kelas = ?, 
                    alamat = ?, 
                    agama = ?, 
                    nohp = ?
                WHERE nisn = ?";

        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ssssssss", $nama, $jeniskelamin, $kodejurusan, $kelas, $alamat, $agama, $nohp, $nisn);

        return $stmt->execute();
    }



    public function hapus_siswa($nisn)
    {
        $query = "DELETE FROM siswa WHERE nisn = ?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("s", $nisn);
        return $stmt->execute();
    }

    // Add this method to your Database class in koneksi.php

    public function cari_data_siswa($keyword)
    {
        $keyword = "%$keyword%";
        $query = "SELECT s.nisn, s.nama, s.jeniskelamin, j.namajurusan AS jurusan, 
                         s.kelas, s.alamat, a.agama AS agama, s.nohp 
                  FROM siswa s
                  INNER JOIN jurusan j ON s.kodejurusan = j.kodejurusan
                  INNER JOIN agama a ON s.agama = a.kodeagama
                  WHERE s.nisn LIKE ? 
                     OR s.nama LIKE ? 
                     OR j.namajurusan LIKE ? 
                     OR s.kelas LIKE ? 
                     OR s.alamat LIKE ? 
                     OR a.agama LIKE ? 
                     OR s.nohp LIKE ?";

        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("sssssss", $keyword, $keyword, $keyword, $keyword, $keyword, $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    // Add this method to your Database class in ../index/koneksi.php
    public function tambah_jurusan($kodejurusan, $namajurusan)
    {
        $conn = $this->getKoneksi();

        // Escape inputs to prevent SQL injection
        $kodejurusan = mysqli_real_escape_string($conn, $kodejurusan);
        $namajurusan = mysqli_real_escape_string($conn, $namajurusan);

        // SQL query to insert a new department
        $query = "INSERT INTO jurusan (kodejurusan, namajurusan) VALUES ('$kodejurusan', '$namajurusan')";

        // Execute the query
        $result = mysqli_query($conn, $query);

        // Return boolean indicating success or failure
        return $result;
    }

    public function tambah_agama($kodeagama, $agama)
    {
        $conn = $this->getKoneksi();

        // Escape inputs to prevent SQL injection
        $kodeagama = mysqli_real_escape_string($conn, $kodeagama);
        $agama = mysqli_real_escape_string($conn, $agama);

        // SQL query to insert a new department
        $query = "INSERT INTO agama (kodeagama, agama) VALUES ('$kodeagama', '$agama')";

        // Execute the query
        $result = mysqli_query($conn, $query);

        // Return boolean indicating success or failure
        return $result;
    }

    function tampil_agama()
    {
        $query = "SELECT * FROM agama ORDER BY kodeagama ASC";
        $result = mysqli_query($this->koneksi, $query);

        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    // Function to get agama by ID (kode_agama)
    function get_agama_by_id($kodeagama)
    {
        $kodeagama = mysqli_real_escape_string($this->koneksi, $kodeagama);

        $query = "SELECT * FROM agama WHERE kodeagama = '$kodeagama' LIMIT 1";
        $result = mysqli_query($this->koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    // Function to update agama
    function update_agama($kode_agama_lama, $kode_agama_baru, $agama)
    {
        $kode_agama_lama = mysqli_real_escape_string($this->koneksi, $kode_agama_lama);
        $kode_agama_baru = mysqli_real_escape_string($this->koneksi, $kode_agama_baru);
        $agama = mysqli_real_escape_string($this->koneksi, $agama);

        $query = "UPDATE agama SET kodeagama = '$kode_agama_baru', agama = '$agama' WHERE kodeagama = '$kode_agama_lama'";

        if (mysqli_query($this->koneksi, $query)) {
            return true;
        } else {
            return false;
        }
    }

    // Function to delete agama
    function hapus_agama($kodeagama)
    {
        $kodeagama = mysqli_real_escape_string($this->koneksi, $kodeagama);

        $query = "DELETE FROM agama WHERE kodeagama = '$kodeagama'";

        if (mysqli_query($this->koneksi, $query)) {
            return true;
        } else {
            return false;
        }
    }


    // Add other needed functions here...

    function tampil_jurusan()
    {
        $query = "SELECT * FROM jurusan ORDER BY kodejurusan ASC";
        $result = mysqli_query($this->koneksi, $query);

        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    // Function to get agama by ID (kode_agama)
    function get_jurusan_by_id($kodejurusan)
    {
        $kodejurusan = mysqli_real_escape_string($this->koneksi, $kodejurusan);

        $query = "SELECT * FROM jurusan WHERE kodejurusan = '$kodejurusan' LIMIT 1";
        $result = mysqli_query($this->koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    // Function to update agama
    function update_jurusan($kode_jurusan_lama, $kode_jurusan_baru, $namajurusan)
    {
        $kode_jurusan_lama = mysqli_real_escape_string($this->koneksi, $kode_jurusan_lama);
        $kode_jurusan_baru = mysqli_real_escape_string($this->koneksi, $kode_jurusan_baru);
        $namajurusan = mysqli_real_escape_string($this->koneksi, $namajurusan);

        $query = "UPDATE jurusan SET kodejurusan = '$kode_jurusan_baru', namajurusan = '$namajurusan' WHERE kodejurusan = '$kode_jurusan_lama'";

        if (mysqli_query($this->koneksi, $query)) {
            return true;
        } else {
            return false;
        }
    }

    // Function to delete agama
    function hapus_jurusan($kodejurusan)
    {
        $kodejurusan = mysqli_real_escape_string($this->koneksi, $kodejurusan);

        $query = "DELETE FROM jurusan WHERE kodejurusan = '$kodejurusan'";

        if (mysqli_query($this->koneksi, $query)) {
            return true;
        } else {
            return false;
        }
    }

    // Tambahkan fungsi-fungsi berikut di kelas Database yang sudah ada:

    public function create_users_table()
    {
        $query = "CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        nama VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        role ENUM('admin'') NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
        return $this->koneksi->query($query);
    }

    public function check_login($username, $password)
    {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    public function register_user($username, $password, $nama, $email, $role = 'user')
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password, nama, email, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("sssss", $username, $hashed_password, $nama, $email, $role);

        return $stmt->execute();
    }

    public function is_username_exists($username)
    {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function is_email_exists($email)
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    function tampil_users()
    {
        $query = "SELECT * FROM users ORDER BY id ASC";
        $result = mysqli_query($this->koneksi, $query);

        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    // Function to get agama by ID (kode_agama)
    function get_users_by_id($id)
    {
        $id = mysqli_real_escape_string($this->koneksi, $id);

        $query = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($this->koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    // Function to update agama

    // Function to delete agama
    function hapus_users($id)
    {
        $id = mysqli_real_escape_string($this->koneksi, $id);

        $query = "DELETE FROM users WHERE id = '$id'";

        if (mysqli_query($this->koneksi, $query)) {
            return true;
        } else {
            return false;
        }
    }

    function __destruct()
    {
        mysqli_close($this->koneksi);
    }

    public function cari_data_users($keyword)
    {
        $keyword = "%$keyword%";
        $query = "SELECT id, username, nama, email, role, created_at
              FROM users
              WHERE username LIKE ? OR nama LIKE ? OR email LIKE ? OR role LIKE ?";

        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("ssss", $keyword, $keyword, $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function tampil_data_users()
    {
        $query = "SELECT 
                id,
                username,
                nama,
                email,
                role,
                created_at
              FROM users";

        $result = $this->koneksi->query($query);

        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "Error: " . $this->koneksi->error;
        }

        return $data;
    }



}
?>