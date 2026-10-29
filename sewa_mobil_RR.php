<?php
// Fungsi menentukan tarif harian berdasarkan jenis kendaraan
function tarifHarian($jenis) {
    if ($jenis == "Sedan") {
        return 300000;
    } elseif ($jenis == "SUV") {
        return 500000;
    } elseif ($jenis == "MPV") {
        return 400000;
    } else {
        return 0;
    }
}

// Fungsi menentukan diskon: 10% jika sewa lebih dari 3 hari
function hitungDiskon($lamaSewa, $subtotal) {
    if ($lamaSewa > 3) {
        return $subtotal * 0.10;
    }
    return 0;
}

function rupiah($angka) {
    return "Rp " . number_format($angka, 0, ",", ".");
}

$jenis  = $_POST["jenis"] ?? "Sedan";
$lama   = isset($_POST["lama"]) ? (int)$_POST["lama"] : 0;
$proses = isset($_POST["hitung"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sewa Mobil</title>
</head>
<body>
    <h3>Kalkulator Sewa Mobil</h3>

    <form method="POST">
        <p>
            Jenis Kendaraan:<br>
            <select name="jenis">
                <?php foreach (["Sedan", "SUV", "MPV"] as $j): ?>
                    <option value="<?= $j ?>" <?= $jenis == $j ? "selected" : "" ?>>
                        <?= $j ?> (<?= rupiah(tarifHarian($j)) ?>/hari)
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            Lama Sewa (hari):<br>
            <input type="number" name="lama" min="1" value="<?= $lama > 0 ? $lama : "" ?>" required>
        </p>
        <button type="submit" name="hitung">Hitung</button>
    </form>

    <?php if ($proses && $lama > 0):
        $tarif = tarifHarian($jenis);
        $subtotal = 0;
    ?>
        <hr>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Hari ke-</th>
                <th>Biaya Sewa</th>
                <th>Akumulasi</th>
            </tr>
            <?php for ($hari = 1; $hari <= $lama; $hari++):
                $subtotal += $tarif; ?>
                <tr>
                    <td><?= $hari ?></td>
                    <td><?= rupiah($tarif) ?></td>
                    <td><?= rupiah($subtotal) ?></td>
                </tr>
            <?php endfor; ?>
        </table>

        <?php
        $diskon = hitungDiskon($lama, $subtotal);
        $totalBayar = $subtotal - $diskon;
        ?>
        <p>Jenis kendaraan: <b><?= $jenis ?></b></p>
        <p>Subtotal: <?= rupiah($subtotal) ?></p>
        <p>
            Diskon:
            <?php if ($diskon > 0): ?>
                10% (<?= rupiah($diskon) ?>)
            <?php else: ?>
                Tidak ada (sewa 3 hari atau kurang)
            <?php endif; ?>
        </p>
        <p>Total Pembayaran: <b><?= rupiah($totalBayar) ?></b></p>
    <?php endif; ?>
</body>
</html>
