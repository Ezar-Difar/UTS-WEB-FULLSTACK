<!DOCTYPE html>
<html>
<head>
    <title>Laporan EduSync</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 0px; }
        p { text-align: center; margin-top: 5px; color: #555; }
    </style>
</head>
<body>

    <h2>LAPORAN ANOMALI DATA PIP</h2>
    <p>Sistem Integrasi EduSync Validator</p>
    <hr>

<<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Cek</th>
            <th>NISN</th>
            <th>Nama Siswa</th> <th>Status Akhir</th>
            <th>Detail Kendala</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y, H:i') }}</td>
            <td>{{ $row->siswa_id }}</td>
            <td>{{ $row->nama_siswa ?? '-' }}</td> <td>{{ $row->status_pip }}</td>
            <td>{{ $row->pesan_error ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>