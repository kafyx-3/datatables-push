{{--
    Component: <x-datatables-export::scripts />

    Muat semua CSS + JS CDN DataTables v2 dengan urutan yang benar.
    Taruh di dalam <head> atau di akhir <body> sebelum </body>.

    Urutan load:
      1. CSS  DataTables core
      2. CSS  Buttons plugin
      3. JS   DataTables core
      4. JS   JSZip  (dependency Excel export)
      5. JS   PDFMake (dependency PDF export)
      6. JS   vfs_fonts (dependency PDF export)
      7. JS   Buttons core
      8. JS   Buttons HTML5 (Excel + CSV + Copy)
      9. JS   Buttons Print
--}}

{{-- CSS --}}
<link rel="stylesheet" href="{{ $urls['datatables_css'] }}">
<link rel="stylesheet" href="{{ $urls['buttons_css'] }}">

{{-- JS --}}
<script src="{{ $urls['datatables_js'] }}"></script>
<script src="{{ $urls['jszip_js'] }}"></script>
<script src="{{ $urls['pdfmake_js'] }}"></script>
<script src="{{ $urls['vfs_fonts_js'] }}"></script>
<script src="{{ $urls['buttons_js'] }}"></script>
<script src="{{ $urls['buttons_html5_js'] }}"></script>
<script src="{{ $urls['buttons_print_js'] }}"></script>
