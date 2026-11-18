# kafyx-3/laravel-datatables-export

> Shortcut DataTables v2 + tombol Export (Copy, CSV, Excel, PDF, Print) untuk Laravel — **tanpa jQuery**, dua tag Blade, langsung jalan.

[![Laravel](https://img.shields.io/badge/Laravel-6.x–12.x-red?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-%3E%3D7.3-blue?logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

---

## Daftar Isi

- [Requirement](#requirement)
- [Instalasi](#instalasi)
  - [Via Packagist (normal)](#via-packagist-normal)
  - [Via path lokal (development)](#via-path-lokal-development)
  - [Laravel 5.x — daftarkan manual](#laravel-5x--daftarkan-manual)
- [Quick Start](#quick-start)
- [Referensi Props](#referensi-props)
- [Contoh Lengkap](#contoh-lengkap)
  - [Tabel sederhana](#tabel-sederhana)
  - [Kolom Gambar + Aksi tidak ikut ekspor](#kolom-gambar--aksi-tidak-ikut-ekspor)
  - [Pilih tombol tertentu saja](#pilih-tombol-tertentu-saja)
  - [Pakai di dalam layout Blade](#pakai-di-dalam-layout-blade)
- [Pemakaian Script DataTable Manual](#pemakaian-script-datatable-manual)
  - [Inisialisasi dasar](#inisialisasi-dasar)
  - [Sembunyikan kolom dari ekspor](#sembunyikan-kolom-dari-ekspor)
  - [Custom judul file ekspor](#custom-judul-file-ekspor)
  - [Tombol di bawah tabel](#tombol-di-bawah-tabel)
- [Konfigurasi](#konfigurasi)
  - [Publish config](#publish-config)
  - [Publish views (opsional)](#publish-views-opsional)
  - [Semua opsi config](#semua-opsi-config)
- [Kompatibilitas Laravel](#kompatibilitas-laravel)

---

## Requirement

| Komponen | Versi minimum |
|---|---|
| PHP | 7.3 |
| Laravel | 6.x |
| illuminate/support | ^6.0 |

> Blade Component (`<x-...>`) pertama kali hadir di **Laravel 7**. Untuk Laravel 6, lihat [catatan di bawah](#laravel-6--daftarkan-manual).

---

## Instalasi

### Via Packagist (normal)

```bash
composer require kafyx-3/laravel-datatables-export
```

Package auto-discovery aktif di Laravel 5.5+. ServiceProvider terdaftar otomatis, tidak perlu tambah apapun ke `config/app.php`.

---

### Via path lokal (development)

Kalau kamu ingin develop/test package ini langsung di project Laravel lokal, tambahkan ke `composer.json` **project Laravel** kamu (bukan composer.json package-nya):

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

Lalu jalankan:

```bash
composer update kafyx-3/laravel-datatables-export
```

---

### Laravel 5.x — daftarkan manual

Auto-discovery tidak ada di Laravel 5.4 ke bawah. Tambahkan provider ke `config/app.php`:

```php
'providers' => [
    // ...
    Kafyx3\DataTablesExport\DataTablesExportServiceProvider::class,
],
```

> **Catatan:** Blade Component (`<x-...>`) baru tersedia di Laravel 7+. Di Laravel 5–6, kamu tetap bisa render komponen via `@component('datatables-export::components.table', [...])` atau publish views dan panggil manual.

---

## Quick Start

**Langkah 1** — Muat CDN di `<head>` layout:

```blade
<head>
    <meta charset="UTF-8">
    <title>Halaman Saya</title>

    <x-datatables-export::scripts />
</head>
```

**Langkah 2** — Tambahkan tabel di halaman:

```blade
<x-datatables-export::table id="tabelSaya">
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
```

Hasilnya: tabel interaktif dengan tombol **Copy · CSV · Excel · PDF · Print** langsung muncul di atas tabel.

---

## Referensi Props

Component `<x-datatables-export::table />` menerima tiga props:

| Prop | Tipe | Default | Keterangan |
|---|---|---|---|
| `id` | `string` | — *(wajib)* | ID unik elemen `<table>`. Harus unik per halaman. |
| `buttons` | `array` | dari config | Tombol yang ditampilkan. Pilihan: `copy`, `csv`, `excel`, `pdf`, `print`. |
| `exportColumns` | `array\|null` | `null` | Indeks kolom (0-based) yang **ikut** ekspor. `null` artinya semua kolom diekspor. |

---

## Contoh Lengkap

### Tabel sederhana

Semua kolom ikut ekspor, semua tombol tampil:

```blade
<x-datatables-export::table id="tabelProduk">
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produk as $item)
        <tr>
            <td>{{ $item->nama }}</td>
            <td>{{ number_format($item->harga) }}</td>
            <td>{{ $item->stok }}</td>
        </tr>
        @endforeach
    </tbody>
</x-datatables-export::table>
```

---

### Kolom Gambar + Aksi tidak ikut ekspor

Misalnya tabel punya 5 kolom:

| Indeks | Kolom | Ekspor? |
|---|---|---|
| 0 | Nama Alat | ✅ |
| 1 | Kategori | ✅ |
| 2 | Stok | ✅ |
| 3 | Gambar | ❌ |
| 4 | Aksi | ❌ |

Gunakan `:exportColumns` dengan indeks kolom yang **ingin** diekspor:

```blade
<x-datatables-export::table
    id="tabelAlat"
    :exportColumns="[0, 1, 2]"
>
    <thead>
        <tr>
            <th>Nama Alat</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($alat as $item)
        <tr>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->kategori }}</td>
            <td>{{ $item->stok }}</td>
            <td>
                <img src="{{ asset($item->foto) }}" width="60" alt="{{ $item->nama }}">
            </td>
            <td>
                <a href="{{ route('alat.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('alat.destroy', $item) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</x-datatables-export::table>
```

Kolom **Gambar** dan **Aksi** tetap tampil di layar, tapi tidak masuk ke file CSV/Excel/PDF maupun hasil Copy.

---

### Pilih tombol tertentu saja

```blade
{{-- Hanya Excel dan PDF --}}
<x-datatables-export::table
    id="tabelLaporan"
    :buttons="['excel', 'pdf']"
>
    ...
</x-datatables-export::table>

{{-- Hanya Print --}}
<x-datatables-export::table
    id="tabelCetak"
    :buttons="['print']"
>
    ...
</x-datatables-export::table>
```

---

### Pakai di dalam layout Blade

Kalau project kamu pakai layout dengan `@yield` / `@section`:

```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'App')</title>

    <x-datatables-export::scripts />

    @stack('styles')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
```

```blade
{{-- resources/views/alat/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Alat')

@section('content')
    <h1>Data Alat</h1>

    <x-datatables-export::table id="tabelAlat" :exportColumns="[0, 1, 2]">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alat as $item)
            <tr>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->stok }}</td>
                <td><img src="{{ asset($item->foto) }}" width="50"></td>
                <td><a href="{{ route('alat.edit', $item) }}">Edit</a></td>
            </tr>
            @endforeach
        </tbody>
    </x-datatables-export::table>
@endsection
```

---

## Pemakaian Script DataTable Manual

Kalau kamu tidak pakai Blade component `<x-datatables-export::table />` dan ingin inisialisasi `DataTable` sendiri di JavaScript, cukup muat CDN via `<x-datatables-export::scripts />` lalu tulis script-nya manual.

> **Penting:** Tidak perlu jQuery. DataTables v2 jalan dengan `new DataTable()` vanilla JS langsung.

---

### Inisialisasi dasar

```html
<!-- Muat CDN dulu (taruh di <head>) -->
<x-datatables-export::scripts />

<!-- Tabel HTML biasa -->
<table id="myTable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>Alice</td><td>alice@example.com</td><td>Admin</td></tr>
        <tr><td>Bob</td><td>bob@example.com</td><td>User</td></tr>
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new DataTable('#myTable', {
        layout: {
            topStart: {
                buttons: [
                    'copy',
                    'csv',
                    'excel',
                    'pdf',
                    'print'
                ]
            }
        }
    });
});
</script>
```

---

### Sembunyikan kolom dari ekspor

Gunakan `exportOptions.columns` di tiap button. Contoh: tabel 5 kolom, kolom ke-4 (Gambar, indeks 3) dan ke-5 (Aksi, indeks 4) tidak ikut ekspor.

```js
new DataTable('#myTable', {
    layout: {
        topStart: {
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: { columns: [0, 1, 2] }
                },
                {
                    extend: 'csv',
                    exportOptions: { columns: [0, 1, 2] }
                },
                {
                    extend: 'excel',
                    exportOptions: { columns: [0, 1, 2] }
                },
                {
                    extend: 'pdf',
                    exportOptions: { columns: [0, 1, 2] }
                },
                {
                    extend: 'print',
                    exportOptions: { columns: [0, 1, 2] }
                }
            ]
        }
    }
});
```

> Ini persis yang dilakukan Blade component saat kamu set `:exportColumns="[0, 1, 2]"` — cuma versi manual-nya.

---

### Custom judul file ekspor

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

---

### Tombol di bawah tabel

Pakai `bottomStart` atau `bottomEnd` sebagai pengganti `topStart`:

```js
new DataTable('#myTable', {
    layout: {
        topStart: null,         // hilangkan tombol di atas
        bottomStart: {
            buttons: ['excel', 'pdf', 'print']
        }
    }
});
```

Atau tombol di atas **dan** di bawah sekaligus:

```js
new DataTable('#myTable', {
    layout: {
        topStart: {
            buttons: ['copy', 'csv']
        },
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

File akan muncul di `config/datatables-export.php`.

### Publish views (opsional)

Kalau ingin kustomisasi tampilan komponen:

```bash
php artisan vendor:publish --tag=datatables-export-views
```

Views akan disalin ke `resources/views/vendor/datatables-export/`.

---

### Semua opsi config

```php
// config/datatables-export.php

return [

    // Versi DataTables core
    'datatables_version' => '2.3.4',

    // Versi plugin Buttons
    'buttons_version' => '3.2.5',

    // Versi JSZip (dependency Excel export)
    'jszip_version' => '3.10.1',

    // Versi PDFMake (dependency PDF export)
    'pdfmake_version' => '0.2.7',

    // Tombol default bila prop `buttons` tidak diberikan ke component
    'default_buttons' => ['copy', 'csv', 'excel', 'pdf', 'print'],

    // Template URL CDN.
    // Placeholder {version}, {buttons_version}, {jszip_version}, {pdfmake_version}
    // otomatis diganti sesuai nilai versi di atas.
    // Ganti URL-nya bila ingin self-host atau pakai CDN mirror lain.
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

---

## License

MIT © [kafyx-3](https://github.com/kafyx-3/datatables-push)
