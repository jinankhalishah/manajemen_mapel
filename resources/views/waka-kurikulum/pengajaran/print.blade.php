<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Pengajaran - {{ $tahunAktif?->tahun ?? '' }}</title>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 24px;
            color: #111827;
            font-size: 13px;
        }

        .toolbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            background: #1f2937;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-end;
        }

        .filter-field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 4px;
            color: #4b5563;
        }

        .filter-field select {
            padding: 7px 10px;
            font-size: 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            min-width: 180px;
        }

        .kepala {
            text-align: center;
            border-bottom: 3px double #111827;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .kepala h1 {
            font-size: 18px;
            margin: 0 0 4px;
            text-transform: uppercase;
        }

        .kepala h2 {
            font-size: 15px;
            margin: 0;
        }

        .info {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .section-kelas {
            margin-bottom: 24px;
            page-break-inside: avoid;
        }

        .section-kelas h3 {
            font-size: 14px;
            margin: 0 0 8px;
            padding: 6px 10px;
            background: #f3f4f6;
            border-left: 4px solid #1f2937;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        table th,
        table td {
            border: 1px solid #374151;
            padding: 7px 10px;
            text-align: left;
        }

        table th {
            background: #e5e7eb;
            font-weight: 700;
        }

        table td.no { text-align: center; width: 40px; }
        table td.hari { text-align: center; width: 90px; }
        table td.jam { text-align: center; width: 130px; }
        table td.jpm { text-align: center; width: 70px; }

        .kosong {
            padding: 24px;
            text-align: center;
            color: #6b7280;
            border: 1px dashed #9ca3af;
            border-radius: 8px;
        }

        .ttd {
            margin-top: 48px;
            text-align: right;
            page-break-inside: avoid;
        }

        .ttd p { margin: 0 0 4px; }

        .ttd .nama {
            margin-top: 72px;
            font-weight: 700;
            text-decoration: underline;
        }

        @media print {
            body { padding: 0; }

            .toolbar,
            .no-print { display: none !important; }

            .section-kelas { page-break-inside: avoid; }
        }
    </style>
</head>

<body>

    <div class="toolbar no-print">

        <div class="filter-form">

            <form method="GET" action="{{ route('pengajaran.cetak') }}" class="filter-form">

                <div class="filter-field">
                    <label for="tahun_ajaran_id">Tahun Ajaran</label>
                    <select id="tahun_ajaran_id" name="tahun_ajaran_id">
                        <option value="">Semua</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}"
                                {{ (string) $filterTahun === (string) $ta->id ? 'selected' : '' }}>
                                {{ $ta->tahun }} ({{ $ta->semester }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-field">
                    <label for="kelas_id">Kelas</label>
                    <select id="kelas_id" name="kelas_id">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}"
                                {{ (string) $filterKelas === (string) $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->jurusan?->kode }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn">Terapkan Filter</button>

            </form>

        </div>

        <div>
            <a href="{{ route('pengajaran.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="button" class="btn" onclick="window.print()">
                Cetak / Simpan PDF
            </button>
        </div>

    </div>

    <div class="kepala">
        <h1>Jadwal Pengajaran</h1>
        <h2>SMK Manajemen Mapel</h2>
    </div>

    <div class="info">
        <div>
            <strong>Tahun Ajaran:</strong>
            @if($filterTahun && ($ta = $tahunAjaran->firstWhere('id', (int) $filterTahun)))
                {{ $ta->tahun }} ({{ $ta->semester }})
            @else
                {{ $tahunAktif?->tahun }} ({{ $tahunAktif?->semester }}) - Tahun Ajaran Aktif
            @endif
        </div>
        <div>
            <strong>Semester:</strong> {{ $tahunAktif?->semester ?? '-' }}
        </div>
        <div>
            <strong>Dicetak:</strong> {{ now()->format('d M Y') }}
        </div>
    </div>

    @forelse($rows as $items)

        @php $kelasItem = $items->first()->kelas; @endphp

        <div class="section-kelas">

            <h3>
                Kelas {{ $kelasItem->nama_kelas }}
                ({{ $kelasItem->jurusan?->nama }})
            </h3>

            <table>

                <thead>
                    <tr>
                        <th class="no">No</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th class="jpm">JPM</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($items as $item)

                        <tr>
                            <td class="no">{{ $loop->iteration }}</td>
                            <td class="hari">{{ $item->hari }}</td>
                            <td class="jam">{{ $item->jam_mulai->format('H:i') }} - {{ $item->jam_selesai->format('H:i') }}</td>
                            <td>{{ $item->mataPelajaran?->nama }}</td>
                            <td>{{ $item->guru?->nama }}</td>
                            <td class="jpm">{{ $item->jam_per_minggu }}</td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @empty

        <div class="kosong">
            Tidak ada data jadwal pengajaran untuk filter yang dipilih.
        </div>

    @endforelse

    <div class="ttd">

        <p>{{ now()->format('d F Y') }}</p>
        <p>Waka Kurikulum,</p>

        <p class="nama">{{ auth()->user()->name }}</p>

    </div>

</body>

</html>