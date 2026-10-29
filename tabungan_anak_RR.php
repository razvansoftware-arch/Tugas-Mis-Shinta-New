<?php
// Fungsi bonus saldo: makin besar setoran, makin besar bonus
function hitungBonus($setoran) {
    if ($setoran >= 500000) {
        return $setoran * 0.05;   // bonus 5%
    } elseif ($setoran >= 200000) {
        return $setoran * 0.02;   // bonus 2%
    } else {
        return 0;                 // belum mencapai batas
    }
}

function rupiah($angka) {
    return "Rp " . number_format($angka, 0, ",", ".");
}

$saldoAwal = isset($_POST["saldo_awal"]) ? (int)$_POST["saldo_awal"] : 0;
$setoran   = isset($_POST["setoran"]) ? (int)$_POST["setoran"] : 0;
$bulan     = isset($_POST["bulan"]) ? (int)$_POST["bulan"] : 0;
$proses    = isset($_POST["hitung"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tabungan Anak</title>
</head>
<body>
    <h3>Simulasi Tabungan Anak</h3>

    <form method="POST">
        <p>
            Saldo Awal (Rp):<br>
            <input type="number" name="saldo_awal" min="0" value="<?= $proses ? $saldoAwal : 0 ?>" required>
        </p>
        <p>
            Setoran Bulanan (Rp):<br>
            <input type="number" name="setoran" min="1" value="<?= $setoran > 0 ? $setoran : "" ?>" required><br>
            <small>Bonus 2% jika setoran minimal Rp 200.000, bonus 5% jika minimal Rp 500.000.</small>
        </p>
        <p>
            Jumlah Bulan:<br>
            <input type="number" name="bulan" min="1" value="<?= $bulan > 0 ? $bulan : "" ?>" required>
        </p>
        <button type="submit" name="hitung">Simulasikan</button>
    </form>

    <?php if ($proses && $bulan > 0 && $setoran > 0):
        $saldo = $saldoAwal;
        $totalBonus = 0;
        $bonus = hitungBonus($setoran);
    ?>
        <hr>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Bulan ke-</th>
                <th>Saldo Awal</th>
                <th>Setoran</th>
                <th>Bonus</th>
                <th>Saldo Akhir</th>
            </tr>
            <?php for ($i = 1; $i <= $bulan; $i++):
                $sebelum = $saldo;
                $saldo += $setoran + $bonus;
                $totalBonus += $bonus; ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= rupiah($sebelum) ?></td>
                    <td><?= rupiah($setoran) ?></td>
                    <td><?= rupiah($bonus) ?></td>
                    <td><?= rupiah($saldo) ?></td>
                </tr>
            <?php endfor; ?>
        </table>

        <p>Total Setoran: <?= rupiah($setoran * $bulan) ?></p>
        <p>Total Bonus: <?= rupiah($totalBonus) ?></p>
        <p>Saldo Akhir (bulan ke-<?= $bulan ?>): <b><?= rupiah($saldo) ?></b></p>
    <?php endif; ?>
</body>
</html>
