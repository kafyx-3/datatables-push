# kafyx-3/laravel-datatables-export

> CDN DataTables v2 + tombol Export (Copy, CSV, Excel, PDF, Print) untuk Laravel — **tanpa jQuery**, satu tag Blade di layout, langsung jalan.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kafyx-3/laravel-datatables-export.svg?style=flat-square)](https://packagist.org/packages/kafyx-3/laravel-datatables-export)
[![Total Downloads](https://img.shields.io/packagist/dt/kafyx-3/laravel-datatables-export.svg?style=flat-square)](https://packagist.org/packages/kafyx-3/laravel-datatables-export)
[![Laravel](https://img.shields.io/badge/Laravel-6.x–12.x-red?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-%3E%3D7.3-blue?style=flat-square&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

---

## Apa ini?

Package ini membuatmu **tidak perlu copy-paste CDN DataTables** di setiap halaman. Cukup taruh `<x-datatables-export::scripts />` sekali di layout, semua CDN termuat otomatis — CSS di `<head>`, JS di akhir `<body>` via `@pushOnce` tanpa double-load.

Kamu tetap menulis `new DataTable(...)` sendiri, bebas konfigurasi apapun.

**Sebelum pakai package ini:**
```html
<!-- Di setiap halaman, copy-paste ini semua -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.5/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
```

**Sesudah:**
```blade
<x-datatables-export::scripts />
```

---

## Requirement

| Komponen | Versi minimum |
|---|---|
| PHP | 7.3 |
| Laravel | 6.x |
| illuminate/support | ^6.0 |

---

## Instalasi

```bash
composer require kafyx-3/laravel-datatables-export
```

Auto-discovery aktif di Laravel 5.5+. Tidak perlu daftar provider manual.

### Via path lokal (development)

Tambahkan ke `composer.json` project Laravel kamu:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./packages/kafyx-3/laravel-datatables-export"
        }
    ],
    "require": {
        "kafyx-3/laravel-datatables-export": "*"
    }
}
```

```bash
composer update kafyx-3/laravel-datatables-export
```

### Laravel 5.4 ke bawah — daftarkan manual

```php
// config/app.php
'providers' => [
    Kafyx3\DataTablesExport\DataTablesExportServiceProvider::class,
],
```

---

## Quick Start

**1. Tambah `<x-datatables-export::scripts />` di layout dan pastikan ada `@stack('datatables-scripts')` dan `@stack('scripts')` sebelum `</body>`:**

```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'App')</title>

    <x-datatables-export::scripts />  {{-- CSS termuat di sini --}}
</head>
<body>
    @yield('content')

    @stack('datatables-scripts')  {{-- jQuery + DataTables CDN muncul di sini --}}
    @stack('scripts')             {{-- script inisialisasi halaman muncul di sini --}}
</body>
</html>
```

**2. Di halaman, pakai component table dan tulis script inisialisasi:**

```blade
@extends('layouts.app')

@section('content')
    <x-datatables-export::table id="tabelAlat" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </x-datatables-export::table>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    new DataTable('#tabelAlat', {
        layout: {
            topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            }
        }
    });
});
</script>
@endpush
```

---

## Cara Kerja

`<x-datatables-export::scripts />` melakukan dua hal:

- **CSS** — langsung di-render di tempat tag dipasang (cocok di `<head>`)
- **JS** — di-push ke `@stack('scripts')` via `@pushOnce`, muncul sebelum `</body>`, tidak double-load walau ada beberapa tabel di satu halaman

`<x-datatables-export::table />` hanya render `<table>` HTML. **Tidak ada script inisialisasi yang otomatis diinjeksi.** Kamu tulis `new DataTable(...)` sendiri — bebas konfigurasi apapun.

---

## Referensi Props

### `<x-datatables-export::scripts />`

Tidak ada props. Taruh sekali di `<head>` layout.

### `<x-datatables-export::table />`

| Prop | Tipe | Default | Keterangan |
|---|---|---|---|
| `id` | `string` | — *(wajib)* | ID unik elemen `<table>`. Harus unik per halaman. |
| `class` | `string` | `display` | Class CSS pada `<table>`. Bisa dikombinasi dengan Bootstrap, dll. |

---

## Contoh

### Kolom Gambar + Aksi tidak ikut ekspor

Gunakan `exportOptions.columns` di tiap button untuk memilih kolom mana saja yang masuk file ekspor:

```blade
<x-datatables-export::table id="tabelAlat" class="table table-bordered table-striped align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Alat</th>
            <th>Gambar Alat</th>
            <th>Keterangan</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($alat as $a)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $a->nama_alat }}</td>
            <td>
                @if ($a->gambar_alat)
                <img src="{{ asset('storage/' . $a->gambar_alat) }}" width="80">
                @endif
            </td>
            <td>{{ $a->keterangan_alat }}</td>
            <td>{{ $a->kategori->nama_kategori }}</td>
            <td>{{ $a->stok }}</td>
            <td>
                <a href="{{ route('alat.edit', $a->id) }}" class="btn btn-sm btn-warning">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</x-datatables-export::table>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Kolom indeks 2 (Gambar) dan 6 (Aksi) tidak ikut ekspor
    new DataTable('#tabelAlat', {
        layout: {
            topStart: {
                buttons: [
                    { extend: 'copy',  exportOptions: { columns: [0, 1, 3, 4, 5] } },
                    { extend: 'csv',   exportOptions: { columns: [0, 1, 3, 4, 5] } },
                    { extend: 'excel', exportOptions: { columns: [0, 1, 3, 4, 5] } },
                    { extend: 'pdf',   exportOptions: { columns: [0, 1, 3, 4, 5] } },
                    { extend: 'print', exportOptions: { columns: [0, 1, 3, 4, 5] } }
                ]
            }
        }
    });
});
</script>
@endpush
```

### Custom judul dan nama file ekspor

```js
new DataTable('#myTable', {
    layout: {
        topStart: {
            buttons: [
                {
                    extend: 'excel',
                    text: 'Download Excel',
                    title: 'Laporan Data Pengguna',
                    filename: 'laporan-pengguna',
                    exportOptions: { columns: [0, 1, 2] }
                },
                {
                    extend: 'pdf',
                    text: 'Download PDF',
                    title: 'Laporan Data Pengguna',
                    filename: 'laporan-pengguna',
                    exportOptions: { columns: [0, 1, 2] }
                }
            ]
        }
    }
});
```

### Tombol di bawah tabel

```js
new DataTable('#myTable', {
    layout: {
        topStart: null,
        bottomStart: {
            buttons: ['excel', 'pdf', 'print']
        }
    }
});
```

---

## Konfigurasi

### Publish config

```bash
php artisan vendor:publish --tag=datatables-export-config
```

File akan muncul di `config/datatables-export.php`. Gunakan ini untuk ganti versi CDN atau URL mirror.

### Publish views (opsional)

```bash
php artisan vendor:publish --tag=datatables-export-views
```

Views disalin ke `resources/views/vendor/datatables-export/` untuk kustomisasi tampilan.

### Semua opsi config

```php
// config/datatables-export.php
return [
    'datatables_version' => '2.3.4',
    'buttons_version'    => '3.2.5',
    'jszip_version'      => '3.10.1',
    'pdfmake_version'    => '0.2.7',

    'cdn' => [
        'datatables_css'   => 'https://cdn.datatables.net/{version}/css/dataTables.dataTables.min.css',
        'buttons_css'      => 'https://cdn.datatables.net/buttons/{buttons_version}/css/buttons.dataTables.min.css',
        'datatables_js'    => 'https://cdn.datatables.net/{version}/js/dataTables.min.js',
        'jszip_js'         => 'https://cdnjs.cloudflare.com/ajax/libs/jszip/{jszip_version}/jszip.min.js',
        'pdfmake_js'       => 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/{pdfmake_version}/pdfmake.min.js',
        'vfs_fonts_js'     => 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/{pdfmake_version}/vfs_fonts.js',
        'buttons_js'       => 'https://cdn.datatables.net/buttons/{buttons_version}/js/dataTables.buttons.min.js',
        'buttons_html5_js' => 'https://cdn.datatables.net/buttons/{buttons_version}/js/buttons.html5.min.js',
        'buttons_print_js' => 'https://cdn.datatables.net/buttons/{buttons_version}/js/buttons.print.min.js',
    ],
];
```

Placeholder `{version}`, `{buttons_version}`, `{jszip_version}`, `{pdfmake_version}` otomatis diganti sesuai nilai di atas.

---

## Kompatibilitas Laravel

| Laravel | PHP | Blade Component | Auto-Discovery | Catatan |
|---|---|---|---|---|
| 12.x | 8.2+ | ✅ | ✅ | Full support |
| 11.x | 8.2+ | ✅ | ✅ | Full support |
| 10.x | 8.1+ | ✅ | ✅ | Full support |
| 9.x | 8.0+ | ✅ | ✅ | Full support |
| 8.x | 7.3+ | ✅ | ✅ | Full support |
| 7.x | 7.2.5+ | ✅ | ✅ | Full support |
| 6.x | 7.2+ | ❌ | ✅ | Gunakan `@component` atau publish views |
| 5.5–5.8 | 7.1+ | ❌ | ✅ | Gunakan `@component` atau publish views |
| 5.4 ke bawah | 7.0+ | ❌ | ❌ | Daftarkan provider manual di `config/app.php` |

> Blade Component (`<x-...>`) baru tersedia di Laravel 7+. Di Laravel 5–6 gunakan `@component('datatables-export::components.table', ['id' => 'myTable'])`.

---

## Changelog

### v1.1.1
- Fix urutan load JS: CDN sekarang di-push ke stack `datatables-scripts` terpisah dari `scripts`, agar jQuery + DataTables selalu termuat sebelum script inisialisasi halaman

### v1.1.0
- jQuery 3.7.1 otomatis dimuat via CDN — tidak perlu taruh script jQuery manual di layout
- Key `jquery_js` ditambahkan ke config `cdn` untuk kustomisasi versi/URL jQuery

### v1.0.1
- Component `<x-datatables-export::table />` tidak lagi auto-inject script inisialisasi — script ditulis sendiri oleh user untuk kebebasan konfigurasi penuh
- JS CDN sekarang di-push via `@pushOnce('scripts')` ke `@stack('scripts')` di layout, bukan di-render inline
- Prop `buttons` dan `exportColumns` dihapus dari component `table`, digantikan prop `class`

### v1.0.0
- Rilis pertama
- Component `<x-datatables-export::scripts />`: muat CDN DataTables v2 + Buttons + JSZip + PDFMake otomatis. CSS inline di head, JS via `@pushOnce` ke stack `scripts`
- Component `<x-datatables-export::table />`: render `<table>` HTML murni dengan prop `id` dan `class`
- Konfigurasi CDN versi dan URL dapat di-publish dan dikustomisasi via `config/datatables-export.php`
- Support Laravel 6–12, PHP 7.3+

---

## License

MIT © [kafyx-3](https://github.com/kafyx-3/datatables-push)
