# kafyx-3/laravel-datatables-export

> Package Laravel untuk memuat CDN **DataTables v2 + jQuery + Export Buttons (Copy, CSV, Excel, PDF, Print)** lengkap dengan dukungan tema **Bootstrap 5 & Bootstrap 4** — cukup satu tag Blade di layout.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kafyx-3/laravel-datatables-export.svg?style=flat-square)](https://packagist.org/packages/kafyx-3/laravel-datatables-export)
[![Total Downloads](https://img.shields.io/packagist/dt/kafyx-3/laravel-datatables-export.svg?style=flat-square)](https://packagist.org/packages/kafyx-3/laravel-datatables-export)
[![Laravel](https://img.shields.io/badge/Laravel-6.x–12.x-red?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-%3E%3D7.3-blue?style=flat-square&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

---

## Fitur Utama

- **Satu Tag Blade** — Tidak perlu copy-paste 10+ link CDN DataTables, jQuery, JSZip, PDFMake, dan Buttons di setiap halaman.
- **Tema Bootstrap 5 & 4 Built-in** — Tinggal tambah `theme="bootstrap5"` agar pagination, search box, dan tombol export langsung mengikuti style Bootstrap.
- **Warna Pagination Otomatis** — Atur warna tombol pagination (`« ‹ 1 › »` / Next-Prev) lewat prop `color="primary"` (`success`, `danger`, `warning`, `info`, `dark`) tanpa tulis CSS manual.
- **Warna Tombol Export Praktis** — Langsung pakai `className: 'btn-primary'`, `'btn-success'`, `'btn-danger'`, dll tanpa ketimpa `btn-secondary` bawaan DataTables.
- **Anti Double-Load** — JS di-push via `@pushOnce` ke stack terpisah (`datatables-scripts`), aman untuk banyak tabel dalam satu halaman.
- **Bebas Konfigurasi** — Kamu tetap menulis `$('#id').DataTable(...)` sendiri dengan fleksibilitas penuh.

---

## Instalasi

```bash
composer require kafyx-3/laravel-datatables-export
```

### Update ke versi terbaru

```bash
composer require kafyx-3/laravel-datatables-export:^1.2
php artisan view:clear
```

> Auto-discovery aktif di Laravel 5.5+. Untuk Laravel 5.4 ke bawah, daftarkan `Kafyx3\DataTablesExport\DataTablesExportServiceProvider::class` di `config/app.php`.

---

## Quick Start

### 1. Pasang di Layout Utama

Taruh `<x-datatables-export::scripts />` di dalam `<head>` (setelah CSS Bootstrap jika memakai Bootstrap), lalu tambahkan `@stack('datatables-scripts')` **sebelum** `@stack('scripts')` di bawah `<body>`:

```blade
{{-- resources/views/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'App')</title>

    {{-- CSS Bootstrap 5 kamu (jika pakai Bootstrap) --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- Muat CSS DataTables (pilih salah satu) --}}
    <x-datatables-export::scripts theme="bootstrap5" color="primary" />
    {{-- Atau tema default DataTables: <x-datatables-export::scripts /> --}}
</head>
<body>
    @yield('content')

    @stack('datatables-scripts')  {{-- jQuery + DataTables + Export JS --}}
    @stack('scripts')             {{-- Script inisialisasi tabel --}}
</body>
</html>
```

> **Penting:** `@stack('datatables-scripts')` wajib berada **di atas** `@stack('scripts')` agar jQuery dan DataTables sudah siap sebelum script halaman dijalankan.

### 2. Buat Tabel & Script Inisialisasi

```blade
@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <table id="tabelAlat" class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Alat</th>
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
                <td>{{ $a->kategori->nama_kategori }}</td>
                <td>{{ $a->stok }}</td>
                <td>
                    <a href="{{ route('alat.edit', $a->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ route('alat.destroy', $a->id) }}" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#tabelAlat').DataTable({
        layout: {
            topStart: {
                buttons: [
                    { extend: 'copy',  text: 'Copy',  className: 'btn-secondary' },
                    { extend: 'csv',   text: 'CSV',   className: 'btn-primary' },
                    { extend: 'excel', text: 'Excel', className: 'btn-success' },
                    { extend: 'pdf',   text: 'PDF',   className: 'btn-danger' },
                    { extend: 'print', text: 'Print', className: 'btn-info text-white' }
                ]
            }
        }
    });
});
</script>
@endpush
```

---

## Tema & Warna Bootstrap

Aktifkan tema Bootstrap lewat prop pada `<x-datatables-export::scripts />`:

```blade
{{-- Bootstrap 5 dengan pagination biru (primary) --}}
<x-datatables-export::scripts theme="bootstrap5" color="primary" />

{{-- Bootstrap 5 dengan pagination hijau (success) --}}
<x-datatables-export::scripts theme="bootstrap5" color="success" />

{{-- Bootstrap 4 --}}
<x-datatables-export::scripts theme="bootstrap4" color="primary" />
```

Atau set secara global di `config/datatables-export.php` (setelah `vendor:publish`):

```php
'theme' => 'bootstrap5', // 'default' | 'bootstrap5' | 'bootstrap4'
'color' => 'primary',    // 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info' | 'dark'
```

Dengan `theme="bootstrap5"`:
- **Pagination (`« ‹ 1 › »` / Next-Prev)** & **Search box** otomatis mengikuti style Bootstrap 5.
- **Tombol Export** langsung bisa diberi warna Bootstrap (`btn-primary`, `btn-success`, `btn-danger`, `btn-warning`, `btn-info`, `btn-dark`, `btn-outline-*`) tanpa perlu CSS tambahan.

---

## Referensi Component

### `<x-datatables-export::scripts />`

Taruh sekali di `<head>` layout.

| Prop | Tipe | Default | Pilihan | Keterangan |
|---|---|---|---|---|
| `theme` | `string` | `default` | `default`, `bootstrap5`, `bootstrap4` | Tema CSS & adapter JS DataTables + Buttons. |
| `color` | `string` | `primary` | `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `dark` | Warna pagination Bootstrap (aktif saat `theme` = `bootstrap5` / `bootstrap4`). |

### `<x-datatables-export::table />` *(Opsional)*

Render elemen `<table>` HTML murni tanpa injeksi script.

| Prop | Tipe | Default | Keterangan |
|---|---|---|---|
| `id` | `string` | — *(wajib)* | ID unik elemen `<table>`. |
| `class` | `string` | `display` | Class CSS pada `<table>` (misal `table table-bordered table-striped`). |

---

## Contoh Lainnya

### Kecualikan Kolom (Gambar & Aksi) + Custom Judul Ekspor

Secara default, semua kolom ikut diekspor (termasuk kolom `Aksi` berisi tombol Edit/Delete) dan judul dokumen mengikuti `<title>` halaman. Gunakan `exportOptions.columns` dan `title` untuk merapikannya:

```js
$(document).ready(function () {
    // Index kolom mulai dari 0:
    // 0: #, 1: Nama Alat, 2: Gambar (skip), 3: Keterangan, 4: Kategori, 5: Stok, 6: Aksi (skip)
    const exportCols = [0, 1, 3, 4, 5];

    $('#tabelAlat').DataTable({
        layout: {
            topStart: {
                buttons: [
                    { extend: 'copy',  text: 'Copy',  className: 'btn-secondary',       title: 'Data Alat', exportOptions: { columns: exportCols } },
                    { extend: 'csv',   text: 'CSV',   className: 'btn-primary',         title: 'Data Alat', exportOptions: { columns: exportCols } },
                    { extend: 'excel', text: 'Excel', className: 'btn-success',         title: 'Data Alat', exportOptions: { columns: exportCols } },
                    { extend: 'pdf',   text: 'PDF',   className: 'btn-danger',          title: 'Data Alat', exportOptions: { columns: exportCols } },
                    { extend: 'print', text: 'Print', className: 'btn-info text-white', title: 'Data Alat', exportOptions: { columns: exportCols } }
                ]
            }
        }
    });
});
```

> **Tip:** Jika cuma ingin mengecualikan kolom terakhir (`Aksi`) tanpa menghitung index kolom, cukup ganti `columns: exportCols` menjadi `columns: ':not(:last-child)'`.

### Custom Nama File & Teks Pagination (`Previous` / `Next`)

```js
$(document).ready(function () {
    $('#myTable').DataTable({
        language: {
            paginate: {
                previous: 'Previous',
                next: 'Next'
            }
        },
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Download Excel',
                        className: 'btn-success',
                        title: 'Laporan Data Alat',
                        filename: 'laporan-data-alat'
                    },
                    {
                        extend: 'pdf',
                        text: 'Download PDF',
                        className: 'btn-danger',
                        title: 'Laporan Data Alat',
                        filename: 'laporan-data-alat'
                    }
                ]
            },
            bottomEnd: {
                paging: {
                    firstLast: false // sembunyikan tombol « dan »
                }
            }
        }
    });
});
```

---

## Konfigurasi

### Publish Config & Views

```bash
# Publish config ke config/datatables-export.php
php artisan vendor:publish --tag=datatables-export-config

# Publish views ke resources/views/vendor/datatables-export/ (opsional)
php artisan vendor:publish --tag=datatables-export-views
```

### Struktur `config/datatables-export.php`

```php
return [
    'datatables_version' => '2.3.4',
    'buttons_version'    => '3.2.5',
    'jszip_version'      => '3.10.1',
    'pdfmake_version'    => '0.2.7',

    'theme' => 'default', // 'default' | 'bootstrap5' | 'bootstrap4'
    'color' => 'primary', // 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info' | 'dark'

    'themes' => [
        'default' => [
            'datatables_css'      => 'https://cdn.datatables.net/{version}/css/dataTables.dataTables.min.css',
            'buttons_css'         => 'https://cdn.datatables.net/buttons/{buttons_version}/css/buttons.dataTables.min.css',
            'datatables_theme_js' => null,
            'buttons_theme_js'    => null,
        ],
        'bootstrap5' => [
            'datatables_css'      => 'https://cdn.datatables.net/{version}/css/dataTables.bootstrap5.min.css',
            'buttons_css'         => 'https://cdn.datatables.net/buttons/{buttons_version}/css/buttons.bootstrap5.min.css',
            'datatables_theme_js' => 'https://cdn.datatables.net/{version}/js/dataTables.bootstrap5.min.js',
            'buttons_theme_js'    => 'https://cdn.datatables.net/buttons/{buttons_version}/js/buttons.bootstrap5.min.js',
        ],
        'bootstrap4' => [
            'datatables_css'      => 'https://cdn.datatables.net/{version}/css/dataTables.bootstrap4.min.css',
            'buttons_css'         => 'https://cdn.datatables.net/buttons/{buttons_version}/css/buttons.bootstrap4.min.css',
            'datatables_theme_js' => 'https://cdn.datatables.net/{version}/js/dataTables.bootstrap4.min.js',
            'buttons_theme_js'    => 'https://cdn.datatables.net/buttons/{buttons_version}/js/buttons.bootstrap4.min.js',
        ],
    ],

    'cdn' => [
        'datatables_css'   => 'https://cdn.datatables.net/{version}/css/dataTables.dataTables.min.css',
        'buttons_css'      => 'https://cdn.datatables.net/buttons/{buttons_version}/css/buttons.dataTables.min.css',
        'jquery_js'        => 'https://code.jquery.com/jquery-3.7.1.min.js',
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

---

## Kompatibilitas

| Laravel | PHP | Blade Component (`<x-...>`) | Auto-Discovery |
|---|---|---|---|
| 10.x – 12.x | 8.1+ | ✅ | ✅ |
| 7.x – 9.x | 7.3+ | ✅ | ✅ |
| 6.x | 7.3+ | ❌ *(pakai `@component`)* | ✅ |

---

## Changelog

Lihat riwayat lengkap di [CHANGELOG.md](CHANGELOG.md).

- **v1.2.1** — Prop `color` untuk warna pagination Bootstrap otomatis + auto-remove `btn-secondary` saat tombol export memakai warna custom.
- **v1.2.0** — Dukungan tema `bootstrap5` dan `bootstrap4` lewat prop `theme` & config.
- **v1.1.1** — Stack JS terpisah `datatables-scripts` agar urutan load selalu benar.
- **v1.1.0** — Auto-load jQuery 3.7.1 via CDN.
- **v1.0.0** — Rilis awal.

---

## License

MIT © [kafyx-3](https://github.com/kafyx-3/datatables-push)
