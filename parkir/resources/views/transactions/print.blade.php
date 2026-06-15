<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Parkir - {{ $transaction->no_tiket }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #fff;
            margin: 0;
            padding: 10px;
        }

        .ticket {
            background-color: #fff;
            width: 280px;
            margin: 0 auto;
            /* Menggantikan flexbox untuk memposisikan tiket di tengah lembar PDF */
            padding: 15px;
            border: 2px dashed #ccc;
            text-align: center;
        }

        .ticket-header {
            border-bottom: 2px dashed #ccc;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .ticket-header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .ticket-header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #666;
        }

        .ticket-body {
            margin-bottom: 20px;
        }

        .ticket-table {
            width: 100%;
            font-size: 13px;
            border-collapse: collapse;
        }

        .ticket-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .barcode {
            margin: 15px 0;
            font-size: 20px;
            letter-spacing: 2px;
            font-weight: bold;
        }

        .ticket-footer {
            border-top: 2px dashed #ccc;
            padding-top: 10px;
            font-size: 11px;
            color: #666;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="ticket-header">
            <h2>PARKING SIJA</h2>
            <p>{{ $transaction->location->location_name }}</p>
        </div>

        <div class="ticket-body">
            <table class="ticket-table">
                <tr>
                    <td>No. Tiket:</td>
                    <td class="text-right"><strong>{{ $transaction->no_tiket }}</strong></td>
                </tr>
                <tr>
                    <td>Kendaraan:</td>
                    <td class="text-right"><strong>{{ strtoupper($transaction->vehicleType->jenis) }}</strong></td>
                </tr>
                <tr>
                    <td>Waktu Masuk:</td>
                    <td class="text-right">
                        <strong>{{ \Carbon\Carbon::parse($transaction->masuk)->format('d/m/Y H:i') }}</strong></td>
                </tr>
                @if($transaction->keluar)
                    <tr>
                        <td>Waktu Keluar:</td>
                        <td class="text-right">
                            <strong>{{ \Carbon\Carbon::parse($transaction->keluar)->format('d/m/Y H:i') }}</strong></td>
                    </tr>
                    <tr>
                        <td>Total Bayar:</td>
                        <td class="text-right"><strong>Rp
                                {{ number_format($transaction->total_bayar, 0, ',', '.') }}</strong></td>
                    </tr>
                @endif
            </table>
        </div>

        <div class="barcode">
            || ||| || ||| || ||
            <div style="font-size: 10px; font-weight: normal; letter-spacing: normal; margin-top: 5px;">
                *{{ $transaction->no_tiket }}*
            </div>
        </div>

        <div class="ticket-footer">
            <p>Simpan tiket ini baik-baik.<br>Kerusakan/kehilangan tiket adalah tanggung jawab pemilik kendaraan.</p>
        </div>
    </div>
</body>

</html>