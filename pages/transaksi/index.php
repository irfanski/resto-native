<?php
require '../../config/koneksi.php';

$query = mysqli_query($koneksi, "
    SELECT t.*, u.nama AS nama_user, m.no_meja
    FROM transaksi t
    JOIN pesanan p ON t.id_pesanan = p.id_pesanan
    JOIN user u ON p.id_user = u.id_user
    JOIN meja m ON p.no_meja = m.no_meja
    ORDER BY t.waktu_transaksi DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #5A7CFF;
            /* A vibrant blue */
            --secondary-color: #6C757D;
            --accent-color: #28B463;
            /* For success/info buttons like 'Cetak' */
            --background-light: #F8F9FA;
            --background-card: #FFFFFF;
            --text-dark: #2C3E50;
            /* Darker text for better contrast */
            --text-light: #ECF0F1;
            --border-radius: 12px;
            --box-shadow-light: 0 4px 15px rgba(0, 0, 0, 0.08);
            --box-shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-light);
            color: var(--text-dark);
            line-height: 1.6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            /* Align to top */
            min-height: 100vh;
            padding: 3rem 0;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            padding-top: 0;
            padding-bottom: 0;
        }

        .card-custom {
            background: var(--background-card);
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-light);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-hover);
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            padding: 0 1rem;
            /* Adjust padding for alignment */
        }

        .header-section h2 {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 2.2rem;
            display: flex;
            align-items: center;
        }

        .header-section h2 .icon {
            margin-right: 12px;
            color: var(--primary-color);
            font-size: 2.5rem;
        }

        .btn-group-custom .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 4px 10px rgba(90, 124, 255, 0.3);
        }

        .btn-primary:hover {
            background-color: #4366E5;
            /* Slightly darker primary */
            border-color: #4366E5;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(90, 124, 255, 0.4);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: var(--text-light);
        }

        .btn-secondary:hover {
            background-color: #5A6268;
            /* Darker secondary */
            border-color: #5A6268;
            transform: translateY(-2px);
        }

        .btn-accent {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
        }

        .btn-accent:hover {
            background-color: #219B54;
            /* Darker accent */
            border-color: #219B54;
            transform: translateY(-2px);
        }

        .table-responsive {
            border-radius: var(--border-radius);
            overflow: hidden;
            /* Ensures rounded corners on table */
        }

        .table {
            margin-bottom: 0;
            /* Remove default table bottom margin */
        }

        .table thead th {
            background-color: var(--text-dark);
            /* Dark header */
            color: var(--text-light);
            font-weight: 600;
            padding: 1rem 1.25rem;
            white-space: nowrap;
            border-bottom: none;
            /* Remove default border */
        }

        .table tbody tr {
            transition: background-color 0.2s ease-in-out;
        }

        .table tbody tr:nth-child(even) {
            background-color: #FDFEFE;
            /* Slight stripe effect */
        }

        .table tbody tr:hover {
            background-color: #EBF2FF;
            /* Light blue on hover */
        }

        .table td,
        .table th {
            vertical-align: middle;
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            /* Lighter border */
        }

        .table td:last-child {
            white-space: nowrap;
            /* Prevent action buttons from wrapping */
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 6px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 2rem;
            }

            .header-section h2 {
                margin-bottom: 1rem;
                font-size: 1.8rem;
            }

            .btn-group-custom {
                width: 100%;
                display: flex;
                justify-content: space-between;
            }

            .btn-group-custom .btn {
                flex: 1;
                margin: 0 5px;
            }

            .btn-group-custom .btn:first-child {
                margin-left: 0;
            }

            .btn-group-custom .btn:last-child {
                margin-right: 0;
            }

            .table thead {
                display: none;
                /* Hide table header on small screens */
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: var(--border-radius);
                box-shadow: var(--box-shadow-light);
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .table tbody td:last-child {
                border-bottom: none;
            }

            .table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 1rem;
                color: var(--primary-color);
            }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="header-section">
            <h2 class="text-dark"><i class="fas fa-receipt icon"></i>Daftar Transaksi</h2>
            <div class="btn-group-custom">
                <a href="../dashboard.php" class="btn btn-secondary me-2"><i class="fas fa-arrow-left"></i> Dashboard</a>
                <a href="tambah.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Transaksi</a>
            </div>
        </div>

        <div class="card card-custom p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>No. Meja</th>
                            <th>Nama Pelanggan</th>
                            <th>Total Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Waktu Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($query) > 0) : ?>
                            <?php while ($t = mysqli_fetch_assoc($query)) : ?>
                                <tr>
                                    <td data-label="ID Transaksi"><?= $t['id_transaksi'] ?></td>
                                    <td data-label="No. Meja"><span class="badge bg-info text-dark p-2"><?= $t['no_meja'] ?></span></td>
                                    <td data-label="Nama Pelanggan"><?= $t['nama_user'] ?></td>
                                    <td data-label="Total Pembayaran">Rp <?= number_format($t['total_bayar'], 0, ',', '.') ?></td>
                                    <td data-label="Metode Pembayaran"><span class="badge bg-secondary p-2"><?= $t['metode_pembayaran'] ?></span></td>
                                    <td data-label="Waktu Transaksi"><?= date('d M Y, H:i', strtotime($t['waktu_transaksi'])) ?></td>
                                    <td data-label="Aksi">
                                        <a href="cetak.php?id=<?= $t['id_transaksi'] ?>" target="_blank" class="btn btn-sm btn-accent"><i class="fas fa-print me-1"></i> Cetak</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">Tidak ada data transaksi ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>