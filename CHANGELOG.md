# Changelog

Semua perubahan notable pada package ini didokumentasikan di file ini.

Format mengikuti [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
versioning mengikuti [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [v1.0.1] — 2026-11-18

### Changed
- Component `<x-datatables-export::table />` tidak lagi auto-inject script inisialisasi DataTable — script ditulis sendiri oleh user di `@push('scripts')` untuk kebebasan konfigurasi penuh
- JS CDN sekarang di-push via `@pushOnce('scripts')` ke `@stack('scripts')` di layout, bukan di-render inline — memastikan JS termuat setelah DOM siap dan tidak double-load
- Prop `buttons` dan `exportColumns` dihapus dari component `table`, digantikan prop `class` (opsional, default `display`)

---

## [v1.0.0] — 2026-11-18

### Added
- Component `<x-datatables-export::scripts />` — muat seluruh CDN DataTables v2 + Buttons + JSZip + PDFMake otomatis. CSS di-render inline di `<head>`, JS di-push ke `@stack('scripts')` via `@pushOnce` sehingga tidak double-load walau ada beberapa tabel di satu halaman
- Component `<x-datatables-export::table />` — render elemen `<table>` HTML murni dengan prop `id` (wajib) dan `class` (opsional, default `display`)
- Config `config/datatables-export.php` — versi CDN dan URL dapat di-publish dan dikustomisasi per project
- Support Laravel 6–12, PHP 7.3+
- Auto-discovery via `extra.laravel.providers` di `composer.json`
- Artisan publish untuk config (`--tag=datatables-export-config`) dan views (`--tag=datatables-export-views`)
