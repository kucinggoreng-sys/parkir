<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Parking Ticket - {{ $transaction->ticket_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 300px;
            margin: 0 auto;
            padding: 10px;
            color: #000;
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 3px 0 0 0;
            font-size: 12px;
        }

        .ticket-num {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 15px 0;
            border: 1px solid #000;
            padding: 8px;
            background-color: #f2f2f2;
        }

        .details {
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .details table {
            width: 100%;
        }

        .details td {
            padding: 3px 0;
        }

        .details td.label {
            width: 40%;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            border-top: 2px dashed #000;
            padding-top: 10px;
            margin-top: 15px;
            font-size: 11px;
        }

        .barcode {
            text-align: center;
            margin: 15px 0;
            font-size: 10px;
        }

        .barcode-line {
            height: 30px;
            background-color: #000;
            width: 80%;
            margin: 0 auto 5px auto;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>PARKIR KENDARAAN</h2>
        <p>SMKN 1 CIBINONG - ASAT PRAKTEK</p>
    </div>

    <div class="ticket-num">
        {{ $transaction->no_tiket }}
    </div>

    <div class="details">
        <table>
            <tr>
                <td class="label">Lokasi:</td>
                <td>{{ $transaction->location->location_name }}</td>
            </tr>
            <tr>
                <td class="label">Tipe:</td>
                <td>{{ ucfirst($transaction->vehicleType->jenis) }}</td>
            </tr>
            <tr>
                <td class="label">Waktu Masuk:</td>
                <td>{{ $transaction->masuk->format('d-m-Y H:i:s') }}</td>
            </tr>
        </table>
    </div>

    <div class="barcode">
        <div class="barcode-line"></div>
        *{{ $transaction->no_tiket }}*
    </div>

    <div class="footer">
        <p>Simpan tiket ini dengan baik.</p>
        <p>Tunjukkan tiket saat keluar untuk melakukan pembayaran.</p>
        <p>Terima kasih atas kunjungan Anda!</p>
    </div>

</body>

</html>