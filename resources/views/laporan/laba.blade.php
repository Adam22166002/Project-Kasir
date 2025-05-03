<!DOCTYPE html>
<html>
<head>
    <title>Laporan Laba</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, td, th { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body>
    <h2>Laporan Laba</h2>
    <table>
        <tr>
            <td>Total Penghasilan</td>
            <td>Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
        </tr>
        <tr><td>Beban - Listrik</td><td>Rp 150.000</td></tr>
        <tr><td>Beban - Air</td><td>Rp 80.000</td></tr>
        <tr><td>Beban Lainnya</td><td>Rp 0</td></tr>
        <tr>
            <td><strong>Laba Kotor</strong></td>
            <td><strong>Rp {{ number_format($labaKotor, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td><strong>Modal</strong></td>
            <td>Rp {{ number_format($modal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Laba Bersih</strong></td>
            <td><strong>Rp {{ number_format($labaBersih, 0, ',', '.') }}</strong></td>
        </tr>
    </table>
</body>
</html>
