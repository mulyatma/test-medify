<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Kategori {{ $category->kode }}</title>
    <style>
        /* --- TEMA MODERN & BERSIH --- */
        body {
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #334155;
            /* Warna teks abu-abu gelap agar lebih lembut di mata */
            background-color: #f8fafc;
            /* Latar belakang sedikit off-white */
            padding-bottom: 40px;
        }

        /* Styling Header Laporan */
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #3b82f6;
            /* Garis aksen biru di bawah header */
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 6px 0 0;
            font-size: 12px;
            color: #64748b;
        }

        /* Styling Kotak/Container */
        .box {
            margin-bottom: 20px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 16px;
            border-radius: 8px;
        }

        .box h3 {
            margin-top: 0;
            margin-bottom: 12px;
            color: #0f172a;
            font-size: 14px;
            border-left: 4px solid #3b82f6;
            /* Aksen garis biru di samping judul */
            padding-left: 8px;
        }

        /* Styling Tabel Global */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px 12px;
            vertical-align: middle;
        }

        /* Styling Tabel Informasi (Summary) */
        /* Hanya menargetkan th yang ada di dalam tbody (Tabel pertama) */
        tbody th {
            text-align: left;
            background-color: #f1f5f9;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            width: 30%;
        }

        tbody td {
            border-bottom: 1px solid #e2e8f0;
        }

        /* Styling Tabel Data (List Item) */
        thead th {
            background-color: #1e293b;
            /* Warna header tabel gelap */
            color: #ffffff;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        /* Efek belang-belang (Zebra cross) untuk tabel data */
        tbody tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        /* Utility Classes */
        .text-center {
            text-align: center !important;
        }

        .muted {
            color: #94a3b8;
            font-style: italic;
        }

        /* Styling Footer */
        .footer {
            position: fixed;
            bottom: -10px;
            left: 0px;
            right: 0px;
            height: 20px;
            font-size: 10px;
            color: #64748b;
            text-align: right;
            border-top: 1px dashed #cbd5e1;
            padding-top: 8px;
        }
    </style>
</head>

<body>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}
    </div>

    <div class="header">
        <h1>Detail Kategori</h1>
        <p>Laporan kategori dan item terkait</p>
    </div>

    <div class="box">
        <table>
            <tr>
                <th>Kode Kategori</th>
                <td>{{ $category->kode }}</td>
            </tr>
            <tr>
                <th>Nama Kategori</th>
                <td>{{ $category->nama }}</td>
            </tr>
            <tr>
                <th>Jumlah Item</th>
                <td>{{ $category->masterItems->count() }}</td>
            </tr>
        </table>
    </div>

    <div class="box">
        <h3>Daftar Item dalam Kategori</h3>
        <table>
            <thead>
                <tr>
                    <th width="8%" class="text-center">No</th>
                    <th width="20%">Kode Barang</th>
                    <th>Nama Barang</th>
                    <th width="20%">Harga Beli</th>
                    <th width="22%">Supplier</th>
                </tr>
            </thead>
            <tbody>
                @forelse($category->masterItems as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td>{{ $item->supplier }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center muted">Belum ada barang di kategori ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>