# kafyx-3/laravel-datatables-export

> CDN DataTables v2 + jQuery + tombol Export (Copy, CSV, Excel, PDF, Print) untuk Laravel — satu tag Blade di layout, langsung jalan.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kafyx-3/laravel-datatables-export.svg?style=flat-square)](https://packagist.org/packages/kafyx-3/laravel-datatables-export)
[![Total Downloads](https://img.shields.io/packagist/dt/kafyx-3/laravel-datatables-export.svg?style=flat-square)](https://packagist.org/packages/kafyx-3/laravel-datatables-export)
[![Laravel](https://img.shields.io/badge/Laravel-6.x–12.x-red?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-%3E%3D7.3-blue?style=flat-square&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

---

## Apa ini?

Package ini membuatmu **tidak perlu copy-paste CDN DataTables** di setiap halaman. Cukup taruh `<x-datatables-export::scripts />` sekali di layout — jQuery, DataTables, JSZip, PDFMake, dan semua plugin Buttons termuat otomatis.

Kamu tetap menulis `$('#id').DataTable(...)` sendiri, bebas konfigurasi apapun.

**Sebelum pakai package ini:**
```html
<!-- Di setiap halaman, copy-paste ini semua -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.5/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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

**1. Di layout, taruh `<x-datatables-export::scripts />` di `<head>` dan tambahkan dua stack sebelum `</body>`:**

```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'App')</title>

    <x-datatables-export::scripts />  {{-- CSS DataTables termuat di sini --}}
</head>
<body>
    @yield('content')

    @stack('datatables-scripts')  {{-- jQuery + DataTables JS muncul di sini --}}
    @stack('scripts')             {{-- script inisialisasi halaman muncul di sini --}}
</body>
</html>
```

> **Penting:** `@stack('datatables-scripts')` harus ada **sebelum** `@stack('scripts')` agar jQuery sudah termuat saat script inisialisasi dijalankan.

**2. Di halaman, buat tabel dan tulis script inisialisasi di `@push('scripts')`:**

```blade
@extends('layouts.app')

@section('content')
    <table id="tabelKu" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#tabelKu').DataTable({
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
- **JS** — di-push ke `@stack('datatables-scripts')` via `@pushOnce`, tidak double-load walau ada beberapa tabel di satu halaman

Urutan load JS yang dijamin oleh package:
1. jQuery 3.7.1
2. DataTables core
3. JSZip (dependency Excel)
4. PDFMake + vfs_fonts (dependency PDF)
5. Buttons core
6. Buttons HTML5 (CSV, Excel, Copy)
7. Buttons Print

`<x-datatables-export::table />` hanya render `<table>` HTML. **Tidak ada script inisialisasi yang otomatis diinjeksi.** Kamu tulis `$('#id').DataTable(...)` sendiri di `@push('scripts')`.

---

## Referensi Props

### `<x-datatables-export::scripts />`

Taruh sekali di `<head>` layout.

| Prop | Tipe | Default | Keterangan |
|---|---|---|---|
| `theme` | `string` | `default` | Tema styling DataTables & Buttons. Pilihan: `default`, `bootstrap5`, `bootstrap4`. Jika tidak diisi, mengikuti `config('datatables-export.theme')`. |

```blade
{{-- Tema default DataTables --}}
<x-datatables-export::scripts />

{{-- Tema Bootstrap 5 (pagination, search, & tombol export otomatis style Bootstrap 5) --}}
<x-datatables-export::scripts theme="bootstrap5" />
```

### `<x-datatables-export::table />`

| Prop | Tipe | Default | Keterangan |
|---|---|---|---|
| `id` | `string` | — *(wajib)* | ID unik elemen `<table>`. Harus unik per halaman. |
| `class` | `string` | `display` | Class CSS pada `<table>`. Bisa dikombinasi dengan Bootstrap, dll. |

> `<x-datatables-export::table>` dan `<table>` biasa hasilnya identik di HTML — bebas pilih mana yang lebih nyaman.

---

## Contoh

### Tabel lengkap dengan Gambar + Aksi tidak ikut ekspor

```blade
@extends('layouts.app')

@section('content')
<div class="container mt-4">
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
                    <a href="{{ route('alat.destroy', $a->id) }}" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </x-datatables-export::table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // Kolom indeks 2 (Gambar) dan 6 (Aksi) tidak ikut ekspor
    $('#tabelAlat').DataTable({
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
$(document).ready(function () {
    $('#myTable').DataTable({
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
});
```

### Tombol berwarna dengan Bootstrap 5

Pastikan layout memuat CSS Bootstrap 5 dan gunakan `theme="bootstrap5"`:

```blade
<x-datatables-export::scripts theme="bootstrap5" />
```

Lalu di script inisialisasi, reset `dom.button.className` ke `'btn'` (agar `btn-secondary` bawaan DataTables tidak menimpa warna tombol kamu):

```js
$(document).ready(function () {
    $('#tabelAlat').DataTable({
        layout: {
            topStart: {
                buttons: {
                    dom: {
                        button: {
                            className: 'btn btn-sm'
                        }
                    },
                    buttons: [
                        { extend: 'copy',  text: 'Copy',  className: 'btn-secondary' },
                        { extend: 'csv',   text: 'CSV',   className: 'btn-primary' },
                        { extend: 'excel', text: 'Excel', className: 'btn-success' },
                        { extend: 'pdf',   text: 'PDF',   className: 'btn-danger' },
                        { extend: 'print', text: 'Print', className: 'btn-info text-white' }
                    ]
                }
            }
        }
    });
});
```

### Tombol di bawah tabel

```js
$(document).ready(function () {
    $('#myTable').DataTable({
        layout: {
            topStart: null,
            bottomStart: {
                buttons: ['excel', 'pdf', 'print']
            }
        }
    });
});
```
### Tambah Button 
```js
$(document).ready(function () {
      $('#tabelAlat').DataTable({
          layout: {
              topStart: {
                  buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
              }
          }
      });
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

```bash
php artisan vendor:publish --tag=datatables-export-views
```

Views disalin ke `resources/views/vendor/datatables-export/`.

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

### v1.2.0
- Tambah dukungan tema `bootstrap5` dan `bootstrap4` lewat `<x-datatables-export::scripts theme="bootstrap5" />` atau config `'theme' => 'bootstrap5'`
- Otomatis memuat CSS & adapter JS Bootstrap untuk pagination, search box, dan tombol export

### v1.1.1
- Fix urutan load JS: CDN sekarang di-push ke stack `datatables-scripts` terpisah dari `scripts`, agar jQuery + DataTables selalu termuat sebelum script inisialisasi halaman

### v1.1.0
- jQuery 3.7.1 otomatis dimuat via CDN — tidak perlu taruh script jQuery manual di layout
- Key `jquery_js` ditambahkan ke config `cdn` untuk kustomisasi versi/URL jQuery

### v1.0.1
- Component `<x-datatables-export::table />` tidak lagi auto-inject script inisialisasi — script ditulis sendiri oleh user untuk kebebasan konfigurasi penuh
- JS CDN sekarang di-push via `@pushOnce` ke stack terpisah di layout, bukan di-render inline
- Prop `buttons` dan `exportColumns` dihapus dari component `table`, digantikan prop `class`

### v1.0.0
- Rilis pertama
- Component `<x-datatables-export::scripts />`: muat CDN DataTables v2 + Buttons + JSZip + PDFMake otomatis
- Component `<x-datatables-export::table />`: render `<table>` HTML murni dengan prop `id` dan `class`
- Konfigurasi CDN versi dan URL dapat di-publish dan dikustomisasi via `config/datatables-export.php`
- Support Laravel 6–12, PHP 7.3+

---

## License

MIT © [kafyx-3](https://github.com/kafyx-3/datatables-push)
