<!DOCTYPE html>
<html>
<head>
    <title>Laporan Neraca</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, td, th { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body>
    <h2>Laporan Neraca</h2>
    <table>
        <tr>
        <th>Aset</th>
        <th>Jumlah</th>
        </tr>
        <tr>
            <td>Kas</td>
            <td>Rp {{ number_format($kas, 0, ',', '.') }}</td>
        </tr>
        <tr>
                                        <td>Tabungan Dompet Elektronik</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Giro</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Deposito</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Piutang Usaha</td>
                                        <td>Rp.0</td>
                                    </tr>
        <tr>
            <td>Persediaan</td>
            <td>Rp {{ number_format($persediaan, 0, ',', '.') }}</td>
        </tr>
        <tr>
                                        <td>Asset Lain</td>
                                        <td>Rp.0</td>
                                    </tr>
        <tr>
            <td><strong>Total Aset</strong></td>
            <td><strong>Rp {{ number_format($totalAset, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
                                        <th>Kewajiban</th>
                                        <th>Jumlah</th>
                                    </tr>
                                    <tr>
                                        <td>Utang Bank</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Utang Usaha</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Kewajiban Lain</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Utang Beban</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Utang Non Bank</td>
                                        <td>Rp.0</td>
                                    </tr>
        <tr>
            <td>Modal</td>
            <td>Rp {{ number_format($modal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Laba Ditahan</td>
            <td>Rp {{ number_format($labaKotor, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Pasiva</strong></td>
            <td><strong>Rp {{ number_format($modal + $labaKotor, 0, ',', '.') }}</strong></td>
        </tr>
    </table>
</body>
</html>
