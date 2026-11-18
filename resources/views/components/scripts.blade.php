{{--
    Component: <x-datatables-export::scripts />

    Taruh di dalam <head> layout. CSS dimuat langsung di sini.
    JS dimuat via @pushOnce ke stack 'scripts' — otomatis tidak double-load
    walau ada beberapa tabel di satu halaman.

    Pastikan layout kamu punya @stack('scripts') sebelum </body>:

        @stack('scripts')
    </body>

    Urutan load:
      1. CSS  DataTables core         ← inline di <head>
      2. CSS  Buttons plugin          ← inline di <head>
      3. JS   DataTables core         ← @pushOnce('scripts')
      4. JS   JSZip  (Excel export)   ← @pushOnce('scripts')
      5. JS   PDFMake (PDF export)    ← @pushOnce('scripts')
      6. JS   vfs_fonts (PDF export)  ← @pushOnce('scripts')
      7. JS   Buttons core            ← @pushOnce('scripts')
      8. JS   Buttons HTML5           ← @pushOnce('scripts')
      9. JS   Buttons Print           ← @pushOnce('scripts')
--}}

{{-- CSS — langsung di sini, cocok ditaruh di <head> --}}
<link rel="stylesheet" href="{{ $urls['datatables_css'] }}">
<link rel="stylesheet" href="{{ $urls['buttons_css'] }}">

{{-- JS — di-push ke stack 'scripts', @pushOnce agar tidak double-load --}}
@pushOnce('scripts')
<script src="{{ $urls['jquery_js'] }}"></script>
<script src="{{ $urls['datatables_js'] }}"></script>
<script src="{{ $urls['jszip_js'] }}"></script>
<script src="{{ $urls['pdfmake_js'] }}"></script>
<script src="{{ $urls['vfs_fonts_js'] }}"></script>
<script src="{{ $urls['buttons_js'] }}"></script>
<script src="{{ $urls['buttons_html5_js'] }}"></script>
<script src="{{ $urls['buttons_print_js'] }}"></script>
@endPushOnce
