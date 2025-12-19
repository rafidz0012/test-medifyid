<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>
<body>

    <h3>Detail Kategori</h3>

    <p>
        <strong>Kode Kategori:</strong> {{ $category->kode }}<br>
        <strong>Nama Kategori:</strong> {{ $category->nama }}
    </p>

    <h4>Daftar Item</h4>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Item</th>
                <th>Jenis</th>
                <th>Supplier</th>
                <th>Harga Beli</th>
            </tr>
        </thead>
        <tbody>
        @foreach($category->masterItems as $item)
            <tr>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jenis }}</td>
                <td>{{ $item->supplier }}</td>
                <td>{{ number_format($item->harga_beli) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <footer>
        Dicetak pada: {{ $printedAt }}
    </footer>

</body>
</html>
