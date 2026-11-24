{{--
    Component: <x-datatables-export::scripts />

    Taruh di dalam <head> layout. CSS dimuat langsung di sini.
    JS dimuat via @pushOnce ke stack 'datatables-scripts' — otomatis tidak
    double-load walau ada beberapa tabel di satu halaman.

    Props:
      theme (string, opsional) – 'default', 'bootstrap5', 'bootstrap4'.
                                 Default mengikuti config('datatables-export.theme').

    Contoh:
      <x-datatables-export::scripts />
      <x-datatables-export::scripts theme="bootstrap5" />

    Pastikan layout kamu punya @stack('datatables-scripts') sebelum @stack('scripts'):

        @stack('datatables-scripts')
        @stack('scripts')
    </body>
--}}

{{-- CSS — langsung di sini, cocok ditaruh di <head> --}}
<link rel="stylesheet" href="{{ $urls['datatables_css'] }}">
<link rel="stylesheet" href="{{ $urls['buttons_css'] }}">

{{-- JS — di-push ke stack 'datatables-scripts', @pushOnce agar tidak double-load --}}
@pushOnce('datatables-scripts')
<script src="{{ $urls['jquery_js'] }}"></script>
<script src="{{ $urls['datatables_js'] }}"></script>
@if (!empty($urls['datatables_theme_js']))
<script src="{{ $urls['datatables_theme_js'] }}"></script>
@endif
<script src="{{ $urls['jszip_js'] }}"></script>
<script src="{{ $urls['pdfmake_js'] }}"></script>
<script src="{{ $urls['vfs_fonts_js'] }}"></script>
<script src="{{ $urls['buttons_js'] }}"></script>
@if (!empty($urls['buttons_theme_js']))
<script src="{{ $urls['buttons_theme_js'] }}"></script>
@endif
<script src="{{ $urls['buttons_html5_js'] }}"></script>
<script src="{{ $urls['buttons_print_js'] }}"></script>
@endPushOnce
