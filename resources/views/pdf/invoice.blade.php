<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struk Pemesanan</title>
  <style>
    body {
      font-family: "Courier New", Courier, monospace;
      background: #fff;
      color: #000;
      padding: 20px;
      width: 300px; /* lebar untuk printer thermal */
      margin: auto;
    }

    .receipt {
      border-top: 2px dashed #000;
      border-bottom: 2px dashed #000;
      padding: 10px 0;
    }

    .header {
      text-align: center;
      border-bottom: 1px dashed #000;
      padding-bottom: 10px;
      margin-bottom: 10px;
    }

    .header img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 50%;
    }

    .header h2 {
      margin: 5px 0 0;
      font-size: 18px;
      text-transform: uppercase;
    }

    .info {
      font-size: 13px;
      line-height: 1.4;
      margin-bottom: 10px;
    }

    .info p {
      margin: 2px 0;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }

    .table th, .table td {
      text-align: left;
      padding: 4px 0;
    }

    .table th.qty,
    .table td.qty {
      width: 25px;
      text-align: center;
    }

    .table th.total,
    .table td.total {
      text-align: right;
    }

    .divider {
      border-top: 1px dashed #000;
      margin: 8px 0;
    }

    .total-section {
      margin-top: 10px;
      font-size: 14px;
    }

    .total-section table {
      width: 100%;
    }

    .total-section td {
      padding: 3px 0;
    }

    .total-section td:last-child {
      text-align: right;
    }

    .footer {
      text-align: center;
      font-size: 12px;
      margin-top: 20px;
      border-top: 1px dashed #000;
      padding-top: 10px;
    }

    @media print {
      body {
        width: auto;
        margin: 0;
        padding: 0;
      }
    }
  </style>
</head>
<body>
  <div class="receipt">
    <div class="header">
      <img src="{{ public_path('images/logo-coffee.png') }}" alt="Logo Cafe">
      <h2>The Secret Cafe</h2>
    </div>

    <div class="info">
      <p><strong>Nama:</strong> {{ $pesanan->nama_pemesan }}</p>
      <p><strong>No Pesanan:</strong> #{{ $pesanan->no_pesanan }}</p>
      <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal)->translatedFormat('d F Y') }}</p>
      <p><strong>Jam:</strong> {{ \Carbon\Carbon::parse($pesanan->jam)->translatedFormat('H:i') }}</p>
      <p><strong>Jumlah Item:</strong> {{ $pesanan->total_item }}</p>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>Menu</th>
          <th class="qty">Qty</th>
          <th class="total">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pesanan->pesanan_detail_riwayat as $item)
        <tr>
          <td>{{ $item->nama_menu }}</td>
          <td class="qty">{{ $item->jumlah }}</td>
          <td class="total">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="divider"></div>

    <div class="total-section">
      <table>
        <tr>
          <td>Subtotal</td>
          <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td><strong>Total</strong></td>
          <td><strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong></td>
        </tr>
      </table>
    </div>

    <div class="footer">
      <p>Terima kasih sudah berkunjung!</p>
      <p>Harap simpan struk ini sebagai bukti pemesanan.</p>
      <p>~ Have a nice coffee day ~</p>
    </div>
  </div>
</body>
</html>
