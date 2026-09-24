<?php

session_start();

require_once "../config/database.php";

// Cek apakah admin sudah login
if (!isset($_SESSION["admin_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

$adminName = $_SESSION["admin_name"];
$adminEmail = $_SESSION["admin_email"];

// Mengambil jumlah admin dari database
$sql = "SELECT COUNT(*) AS total_admin FROM admins";

$stmt = $pdo->query($sql);

$totalAdmin = $stmt->fetch()["total_admin"];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin</title>

    <link rel="stylesheet"
        href="../assets/css/style.css">

</head>

<body>

<div class="admin-layout">


    <!-- =========================
         SIDEBAR
    ========================== -->

    <aside class="sidebar">

        <div class="sidebar-logo">

            <div class="sidebar-icon">
                👤
            </div>

            <div>
                <h2>Admin Panel</h2>
                <span>Management System</span>
            </div>

        </div>


        <!-- MENU -->

        <nav class="sidebar-menu">

            <p class="menu-title">
                MENU UTAMA
            </p>

            <a
                href="index.php"
                class="sidebar-link active"
            >
                <span>▣</span>
                Dashboard
            </a>


            <a
                href="../admin/create.php"
                class="sidebar-link"
            >
                <span>＋</span>
                Tambah Admin
            </a>


            <p class="menu-title menu-space">
                AKUN
            </p>


            <div class="sidebar-user">

                <div class="user-avatar">
                    <?= strtoupper(substr($adminName, 0, 1)) ?>
                </div>

                <div class="user-detail">

                    <strong>
                        <?= htmlspecialchars($adminName) ?>
                    </strong>

                    <small>
                        Administrator
                    </small>

                </div>

            </div>

        </nav>


        <!-- LOGOUT -->

        <div class="sidebar-bottom">

            <a
                href="../auth/logout.php"
                class="sidebar-logout"
            >
                <span>↪</span>
                Logout
            </a>

        </div>

    </aside>


    <!-- =========================
         MAIN CONTENT
    ========================== -->

    <main class="main-content">


        <!-- TOPBAR -->

        <header class="topbar">

            <div>

                <h1>
                    Dashboard
                </h1>

                <p>
                    Selamat datang kembali,
                    <?= htmlspecialchars($adminName) ?>.
                </p>

            </div>


            <div class="topbar-user">

                <div class="topbar-avatar">
                    <?= strtoupper(substr($adminName, 0, 1)) ?>
                </div>

                <div>

                    <strong>
                        <?= htmlspecialchars($adminName) ?>
                    </strong>

                    <span>
                        Admin
                    </span>

                </div>

            </div>

        </header>


        <!-- =========================
             STATISTIK
        ========================== -->

        <section class="stats-grid">


            <!-- TOTAL ADMIN -->

            <div class="stat-card">

                <div class="stat-icon blue">
                    👥
                </div>

                <div class="stat-content">

                    <span>
                        Total Admin
                    </span>

                    <strong>
                        <?= $totalAdmin ?>
                    </strong>

                    <small>
                        Admin terdaftar
                    </small>

                </div>

            </div>


            <!-- STATUS SISTEM -->

            <div class="stat-card">

                <div class="stat-icon green">
                    ●
                </div>

                <div class="stat-content">

                    <span>
                        Status Sistem
                    </span>

                    <strong>
                        Aktif
                    </strong>

                    <small>
                        Sistem berjalan normal
                    </small>

                </div>

            </div>


            <!-- ADMIN LOGIN -->

            <div class="stat-card">

                <div class="stat-icon purple">
                    ✓
                </div>

                <div class="stat-content">

                    <span>
                        Admin Aktif
                    </span>

                    <strong>
                        1
                    </strong>

                    <small>
                        Sedang login
                    </small>

                </div>

            </div>

        </section>


        <!-- =========================
             WELCOME
        ========================== -->

        <section class="welcome-card">

            <div class="welcome-content">

                <span class="welcome-label">
                    ADMIN DASHBOARD
                </span>

                <h2>
                    Selamat Datang,
                    <?= htmlspecialchars($adminName) ?>!
                </h2>

                <p>
                    Anda berhasil masuk ke sistem
                    administrator. Kelola akun admin
                    melalui panel yang tersedia.
                </p>

                <a
                    href="../admin/create.php"
                    class="welcome-button"
                >
                    + Tambah Admin
                </a>

            </div>

            <div class="welcome-decoration">
                ADMIN
            </div>

        </section>


        <!-- =========================
             INFORMASI ADMIN
        ========================== -->

        <section class="dashboard-card admin-info-card">

            <div class="section-heading">

                <div>

                    <h2>
                        Informasi Admin
                    </h2>

                    <p>
                        Informasi akun yang sedang digunakan
                    </p>

                </div>

            </div>


            <div class="admin-info">


                <!-- NAMA -->

                <div class="info-item">

                    <span class="info-label">
                        Nama
                    </span>

                    <span class="info-value">
                        <?= htmlspecialchars($adminName) ?>
                    </span>

                </div>


                <!-- EMAIL -->

                <div class="info-item">

                    <span class="info-label">
                        Email
                    </span>

                    <span class="info-value">
                        <?= htmlspecialchars($adminEmail) ?>
                    </span>

                </div>


                <!-- STATUS -->

                <div class="info-item">

                    <span class="info-label">
                        Status
                    </span>

                    <span class="status-login">
                        ● Sedang Login
                    </span>

                </div>

            </div>

        </section>


    </main>

</div>

</body>

</html>