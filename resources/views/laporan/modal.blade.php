<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perubahan Modal</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, td, th { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body>
    <h2>Laporan Perubahan Modal</h2>
    <table>
        <tr>
            <td>Modal Awal</td>
            <td>Rp {{ number_format($modalAwal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Laba Bersih</td>
            <td>Rp {{ number_format($labaBersih, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Modal Akhir</strong></td>
            <td><strong>Rp {{ number_format($modalAkhir, 0, ',', '.') }}</strong></td>
        </tr>
    </table>
</body>
</html>
