<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $model;

    public function __construct($db) {
        $this->model = new User($db);
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }
        require __DIR__ . '/../views/auth/login.php';
    }

    public function processLogin() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Username dan password harus diisi!";
            header("Location: index.php?page=login");
            exit;
        }

        $user = $this->model->getByUsername($username);

        if ($user && password_verify($password, $user['passw'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: index.php?page=dashboard");
            exit;
        } else {
            $_SESSION['error'] = "Username atau password salah!";
            header("Location: index.php?page=login");
            exit;
        }
    }

    // ✅ TAMBAHAN: Tampilkan form register
    public function register() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }
        require __DIR__ . '/../views/auth/register.php';
    }

    // ✅ TAMBAHAN: Proses register
    public function processRegister() {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Validasi
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Semua field harus diisi!";
            header("Location: index.php?page=register");
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = "Password minimal 6 karakter!";
            header("Location: index.php?page=register");
            exit;
        }

        if ($password !== $confirm_password) {
            $_SESSION['error'] = "Password tidak cocok!";
            header("Location: index.php?page=register");
            exit;
        }

        // Cek username sudah ada
        if ($this->model->getByUsername($name)) {
            $_SESSION['error'] = "Username sudah digunakan!";
            header("Location: index.php?page=register");
            exit;
        }

        // Cek email sudah ada
        if ($this->model->getByEmail($email)) {
            $_SESSION['error'] = "Email sudah terdaftar!";
            header("Location: index.php?page=register");
            exit;
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Simpan ke database
        $data = [
            'name' => $name,
            'email' => $email,
            'passw' => $hashed_password
        ];

        if ($this->model->create($data)) {
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: index.php?page=login");
            exit;
        } else {
            $_SESSION['error'] = "Registrasi gagal! Silakan coba lagi.";
            header("Location: index.php?page=register");
            exit;
        }
    }

    public function dashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
        
        // ✅ Ambil data user dari model
        $user = $this->model->getById($_SESSION['user_id']);
        
        // ✅ Kirim variable $user ke view
        require __DIR__ . '/../views/auth/dashboard.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
?>