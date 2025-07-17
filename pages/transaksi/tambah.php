<?php
require '../../config/koneksi.php';

// Ambil pesanan yang status = selesai (1)
// It's good practice to fetch total_bayar here if possible to display it
$pesanan = mysqli_query($koneksi, "
    SELECT p.id_pesanan, u.nama, m.no_meja, SUM(dp.subtotal) AS total_pesanan
    FROM pesanan p
    JOIN user u ON p.id_user = u.id_user
    JOIN meja m ON p.no_meja = m.no_meja
    JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
    WHERE p.status = 1
    GROUP BY p.id_pesanan
    ORDER BY p.id_pesanan DESC
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pesanan = $_POST['id_pesanan'];
    $metode = $_POST['metode_pembayaran'];
    $waktu = date('Y-m-d H:i:s');

    // Re-calculate total to ensure data integrity
    $getTotal = mysqli_query($koneksi, "
        SELECT SUM(subtotal) as total 
        FROM detail_pesanan 
        WHERE id_pesanan = '$id_pesanan'
    ");
    $total = mysqli_fetch_assoc($getTotal)['total'];

    // Start a transaction to ensure atomicity
    mysqli_begin_transaction($koneksi);

    try {
        // Insert into transaksi table
        mysqli_query($koneksi, "
            INSERT INTO transaksi (id_pesanan, total_bayar, metode_pembayaran, waktu_transaksi)
            VALUES ('$id_pesanan', '$total', '$metode', '$waktu')
        ");

        // Update pesanan status to 'completed' or 'paid' (e.g., status = 2)
        mysqli_query($koneksi, "
            UPDATE pesanan SET status = 2 WHERE id_pesanan = '$id_pesanan'
        ");

        mysqli_commit($koneksi);
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        // Handle error, e.g., display an error message
        echo "<script>alert('Terjadi kesalahan saat menyimpan transaksi: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #5A7CFF;
            /* Vibrant Blue */
            --primary-dark: #4366E5;
            --secondary-color: #6C757D;
            --secondary-dark: #5A6268;
            --success-color: #28B463;
            /* Green for success */
            --success-dark: #219B54;
            --background-light: #F8F9FA;
            --background-card: #FFFFFF;
            --text-dark: #2C3E50;
            --text-light: #ECF0F1;
            --border-radius-large: 16px;
            --border-radius-small: 8px;
            --box-shadow-light: 0 6px 20px rgba(0, 0, 0, 0.05);
            --box-shadow-hover: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 0;
            /* Add padding top/bottom */
        }

        .container {
            max-width: 600px;
            /* Max width for the form card */
            width: 100%;
        }

        .card-custom {
            background: var(--background-card);
            border: none;
            border-radius: var(--border-radius-large);
            box-shadow: var(--box-shadow-light);
            padding: 2.5rem;
            /* More internal padding */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-hover);
        }

        .card-header-custom {
            background-color: transparent;
            /* Make header background transparent */
            border-bottom: none;
            padding-bottom: 1.5rem;
            /* Space below header */
            text-align: center;
            position: relative;
            /* For the subtle line effect */
        }

        .card-header-custom h2 {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-header-custom h2 .icon {
            margin-right: 12px;
            font-size: 2.5rem;
        }

        .card-header-custom::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            /* Short line */
            height: 4px;
            background-color: var(--primary-color);
            border-radius: 2px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.6rem;
            display: block;
            /* Ensure it takes full width */
        }

        .form-select {
            border-radius: var(--border-radius-small);
            padding: 0.8rem 1rem;
            border: 1px solid #ced4da;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(90, 124, 255, 0.25);
            outline: none;
        }

        .form-select option {
            padding: 0.5rem;
            /* Add padding to options for better spacing */
        }

        .btn {
            border-radius: var(--border-radius-small);
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            /* Space between icon and text */
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
            box-shadow: 0 4px 10px rgba(40, 180, 99, 0.25);
        }

        .btn-success:hover {
            background-color: var(--success-dark);
            border-color: var(--success-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(40, 180, 99, 0.35);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: var(--text-light);
        }

        .btn-secondary:hover {
            background-color: var(--secondary-dark);
            border-color: var(--secondary-dark);
            transform: translateY(-2px);
        }

        .btn-group-footer {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            gap: 15px;
            /* Space between buttons */
        }

        /* Message for no available orders */
        .no-orders-message {
            text-align: center;
            padding: 1.5rem;
            background-color: #f0f4f7;
            border-radius: var(--border-radius-small);
            color: var(--secondary-color);
            font-style: italic;
            margin-top: 1rem;
        }

        /* Enhance dropdown option display */
        .order-option-detail {
            font-size: 0.9em;
            color: #666;
            margin-left: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card-custom {
                padding: 1.5rem;
                margin: 0 15px;
                /* Add horizontal margin on small screens */
            }

            .card-header-custom h2 {
                font-size: 1.8rem;
            }

            .card-header-custom h2 .icon {
                font-size: 2rem;
            }

            .btn-group-footer {
                flex-direction: column;
                gap: 10px;
            }

            .btn-group-footer .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card card-custom">
            <div class="card-header-custom">
                <h2 class="text-center"><i class="fas fa-money-check-alt icon"></i> Tambah Transaksi Baru</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-4">
                        <label for="id_pesanan" class="form-label">Pilih Pesanan Selesai</label>
                        <select name="id_pesanan" id="id_pesanan" class="form-select" required>
                            <?php if (mysqli_num_rows($pesanan) > 0) : ?>
                                <?php while ($p = mysqli_fetch_assoc($pesanan)) : ?>
                                    <option value="<?= $p['id_pesanan'] ?>">
                                        #<?= $p['id_pesanan'] ?> &mdash; Meja <?= $p['no_meja'] ?> (<span class="fw-semibold"><?= $p['nama'] ?></span>) &mdash; <span class="text-success fw-bold">Rp <?= number_format($p['total_pesanan'], 0, ',', '.') ?></span>
                                    </option>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <option value="" disabled selected>Tidak ada pesanan yang selesai untuk ditambahkan</option>
                            <?php endif; ?>
                        </select>
                        <?php if (mysqli_num_rows($pesanan) == 0) : ?>
                            <div class="no-orders-message mt-3">
                                Saat ini tidak ada pesanan dengan status 'selesai' yang menunggu pembayaran.
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Debit">Debit</option>
                            <option value="Kredit">Kredit</option>
                        </select>
                    </div>

                    <div class="btn-group-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> Simpan Transaksi
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-times-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>