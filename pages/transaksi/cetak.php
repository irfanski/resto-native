<?php
require '../../config/koneksi.php';

$id_transaksi = $_GET['id'] ?? 0;

// Ambil detail transaksi + user + meja
$transaksi = mysqli_query($koneksi, "
    SELECT t.*, u.nama AS nama_user, m.no_meja, p.waktu_pesanan 
    FROM transaksi t
    JOIN pesanan p ON t.id_pesanan = p.id_pesanan
    JOIN user u ON p.id_user = u.id_user
    JOIN meja m ON p.no_meja = m.no_meja
    WHERE t.id_transaksi = '$id_transaksi'
");

$data = mysqli_fetch_assoc($transaksi);
if (!$data) {
    echo "Transaksi tidak ditemukan.";
    exit();
}

// Ambil detail menu
$detail = mysqli_query($koneksi, "
    SELECT dp.*, me.nama_menu, me.harga 
    FROM detail_pesanan dp
    JOIN menu me ON dp.id_menu = me.id_menu
    WHERE dp.id_pesanan = '{$data['id_pesanan']}'
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            font-family: 'Courier New', Courier, monospace;
        }
    </style>
</head>

<body class="p-4">
    <div class="container bg-white p-4 shadow" style="max-width: 500px;">
        <h4 class="text-center mb-2">Resto App</h4>
        <p class="text-center mb-4">Struk Pembayaran</p>

        <table class="w-100 mb-3">
            <tr>
                <td>No Transaksi</td>
                <td>: <?= $data['id_transaksi'] ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: <?= $data['waktu_transaksi'] ?></td>
            </tr>
            <tr>
                <td>Meja</td>
                <td>: <?= $data['no_meja'] ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>: <?= $data['nama_user'] ?></td>
            </tr>
            <tr>
                <td>Metode</td>
                <td>: <?= $data['metode_pembayaran'] ?></td>
            </tr>
        </table>

        <hr>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th class="text-end">Harga</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = mysqli_fetch_assoc($detail)) : ?>
                    <tr>
                        <td><?= $item['nama_menu'] ?></td>
                        <td class="text-end">Rp <?= number_format($item['harga']) ?></td>
                        <td class="text-center"><?= $item['jumlah'] ?></td>
                        <td class="text-end">Rp <?= number_format($item['subtotal']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <hr>

        <h5 class="text-end">Total: Rp <?= number_format($data['total_bayar']) ?></h5>

        <div class="text-center mt-4">
            <p>Terima kasih! 🙏</p>
        </div>

        <div class="text-center no-print">
            <button onclick="window.print()" class="btn btn-success">🖨 Cetak</button>
            <a href="index.php" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>
</body>

</html>