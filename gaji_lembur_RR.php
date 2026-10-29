<?php
// Fungsi gaji pokok harian berdasarkan golongan
function gajiHarian($golongan) {
    if ($golongan == "I") {
        return 100000;
    } elseif ($golongan == "II") {
        return 150000;
    } elseif ($golongan == "III") {
        return 200000;
    } else {
        return 0;
    }
}

// Fungsi uang lembur harian berdasarkan golongan
function uangLembur($golongan) {
    if ($golongan == "I") {
        return 20000;
    } elseif ($golongan == "II") {
        return 30000;
    } elseif ($golongan == "III") {
        return 40000;
    } else {
        return 0;
    }
}

function rupiah($angka) {
    return "Rp " . number_format($angka, 0, ",", ".");
}

$nama      = trim($_POST["nama"] ?? "");
$golongan  = $_POST["golongan"] ?? "I";
$hariKerja = isset($_POST["hari"]) ? (int)$_POST["hari"] : 0;
$proses    = isset($_POST["hitung"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gaji dan Lembur Karyawan</title>
</head>
<body>
    <h3>Kalkulator Gaji dan Lembur Karyawan</h3>

    <form method="POST">
        <p>
            Nama Karyawan:<br>
            <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" required>
        </p>
        <p>
            Golongan:<br>
            <select name="golongan">
                <?php foreach (["I", "II", "III"] as $g): ?>
                    <option value="<?= $g ?>" <?= $golongan == $g ? "selected" : "" ?>>
                        Golongan <?= $g ?> (Gaji <?= rupiah(gajiHarian($g)) ?>/hari, Lembur <?= rupiah(uangLembur($g)) ?>/hari)
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            Jumlah Hari Kerja:<br>
            <input type="number" name="hari" min="1" value="<?= $hariKerja > 0 ? $hariKerja : "" ?>" required>
        </p>
        <button type="submit" name="hitung">Hitung</button>
    </form>

    <?php if ($proses && $hariKerja > 0):
        $gaji  = gajiHarian($golongan);
        $bonus = uangLembur($golongan);
        $totalGaji = 0;
        $totalLembur = 0;
    ?>
        <hr>
        <p>Karyawan: <b><?= htmlspecialchars($nama) ?></b> | Golongan: <b><?= $golongan ?></b></p>

        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Hari ke-</th>
                <th>Gaji Harian</th>
                <th>Uang Lembur</th>
                <th>Akumulasi Gaji</th>
                <th>Akumulasi Lembur</th>
            </tr>
            <?php for ($hari = 1; $hari <= $hariKerja; $hari++):
                $totalGaji += $gaji;
                $totalLembur += $bonus; ?>
                <tr>
                    <td><?= $hari ?></td>
                    <td><?= rupiah($gaji) ?></td>
                    <td><?= rupiah($bonus) ?></td>
                    <td><?= rupiah($totalGaji) ?></td>
                    <td><?= rupiah($totalLembur) ?></td>
                </tr>
            <?php endfor; ?>
        </table>

        <p>Total Gaji Pokok: <?= rupiah($totalGaji) ?></p>
        <p>Total Bonus Lembur: <?= rupiah($totalLembur) ?></p>
        <p>Total Diterima: <b><?= rupiah($totalGaji + $totalLembur) ?></b></p>
    <?php endif; ?>
</body>
</html>
