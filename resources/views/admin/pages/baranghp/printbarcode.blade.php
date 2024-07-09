<!DOCTYPE html>
<html lang="en">

<head>
    <title>Print Data Barang Habis Pakai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <h1 class="text-center m-3">Data Barang Habis Pakai</h1>
    <div class="table-responsive m-5">
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Barcode</th>
                    <th>Tahun Pengadaan</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($item as $item)
                    <tr>
                        <td>{{ $item->kodebarang }}</td>
                        <td>{{ $item->namabarang }}</td>
                        <td>{{ $item->tahunpengadaan }}</td>
                        <td style="width:150px;"><img src="/storage/{{ $item->barcode }}" alt="foto barang"
                                style="width:150px;"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="no-print">
            <button onclick="window.print()" class="btn btn-primary float-end">Print</button>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>
</body>

</html>
