<?php

session_start();

require_once "../config/database.php";

// Cek apakah admin sudah login
if (!isset($_SESSION["admin_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // Validasi input
    if (empty($name) || empty($email) || empty($password)) {

        $error = "Semua data wajib diisi.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Format email tidak valid.";

    } elseif (strlen($password) < 6) {

        $error = "Password minimal 6 karakter.";

    } else {

        // Cek apakah email sudah digunakan
        $sql = "SELECT id FROM admins WHERE email = :email LIMIT 1";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            "email" => $email
        ]);

        $existingAdmin = $stmt->fetch();

        if ($existingAdmin) {

            $error = "Email sudah digunakan.";

        } else {

            // Membuat password hash
            $passwordHash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Simpan admin baru
            $sql = "INSERT INTO admins
                (name, email, password)
                VALUES
                (:name, :email, :password)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                "name" => $name,
                "email" => $email,
                "password" => $passwordHash
            ]);

            $success = "Admin berhasil ditambahkan.";

            // Kosongkan form
            $name = "";
            $email = "";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Tambah Admin</title>

    <link rel="stylesheet"
        href="../assets/css/style.css">

</head>

<body>

<div class="login-container">

    <div class="login-card">

        <div class="login-header">

            <div class="admin-icon">
                +
            </div>

            <h1>Tambah Admin</h1>

            <p>
                Tambahkan administrator baru
            </p>

        </div>


        <?php if (!empty($error)): ?>

            <div class="alert-error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>


        <?php if (!empty($success)): ?>

            <div class="alert-success">
                <?= htmlspecialchars($success) ?>
            </div>

        <?php endif; ?>


        <form method="POST" action="">

            <!-- NAMA -->

            <div class="form-group">

                <label for="name">
                    Nama Admin
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Masukkan nama admin"
                    value="<?= htmlspecialchars($name ?? "") ?>"
                    required
                >

            </div>


            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Masukkan email"
                    value="<?= htmlspecialchars($email ?? "") ?>"
                    required
                >

            </div>


            <!-- PASSWORD -->

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 6 karakter"
                    required
                >

            </div>


            <!-- BUTTON -->

            <button
                type="submit"
                class="btn-login"
            >
                Tambah Admin
            </button>

        </form>


        <div style="text-align: center; margin-top: 20px;">

            <a
                href="../dashboard/index.php"
                style="
                    color: #2563eb;
                    text-decoration: none;
                    font-size: 14px;
                    font-weight: 600;
                "
            >
                ← Kembali ke Dashboard
            </a>

        </div>

    </div>

</div>

</body>
</html>