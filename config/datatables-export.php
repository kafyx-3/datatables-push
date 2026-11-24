<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DataTables CDN Version
    |--------------------------------------------------------------------------
    | Versi DataTables core yang digunakan untuk URL CDN.
    */
    'datatables_version' => '2.3.4',

    /*
    |--------------------------------------------------------------------------
    | DataTables Buttons CDN Version
    |--------------------------------------------------------------------------
    | Versi plugin Buttons DataTables.
    */
    'buttons_version' => '3.2.5',

    /*
    |--------------------------------------------------------------------------
    | JSZip CDN Version
    |--------------------------------------------------------------------------
    */
    'jszip_version' => '3.10.1',

    /*
    |--------------------------------------------------------------------------
    | PDFMake CDN Version
    |--------------------------------------------------------------------------
    */
    'pdfmake_version' => '0.2.7',

    /*
    |--------------------------------------------------------------------------
    | Styling Theme
    |--------------------------------------------------------------------------
    | Tema tampilan DataTables & Buttons yang dimuat via CDN.
    | Pilihan: 'default', 'bootstrap5', 'bootstrap4'
    |
    | Bisa juga di-override langsung di Blade component:
    |   <x-datatables-export::scripts theme="bootstrap5" />
    */
    'theme' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Bootstrap Pagination Color
    |--------------------------------------------------------------------------
    | Warna pagination (Next/Prev/angka) saat memakai tema 'bootstrap5' atau
    | 'bootstrap4'. Pilihan: 'primary', 'secondary', 'success', 'danger',
    | 'warning', 'info', 'dark'.
    |
    | Bisa juga di-override langsung di Blade component:
    |   <x-datatables-export::scripts theme="bootstrap5" color="success" />
    */
    'color' => 'primary',

    /*
    |--------------------------------------------------------------------------
    | Default Export Buttons
    |--------------------------------------------------------------------------
    | Tombol yang ditampilkan secara default bila prop `buttons` tidak
    | diberikan ke component <x-datatables-export::table />.
    | Pilihan: 'copy', 'csv', 'excel', 'pdf', 'print'
    */
    'default_buttons' => ['copy', 'csv', 'excel', 'pdf', 'print'],

    /*
    |--------------------------------------------------------------------------
    | Theme CDN URLs
    |--------------------------------------------------------------------------
    | CSS & adapter JS untuk masing-masing tema.
    */
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

    /*
    |--------------------------------------------------------------------------
    | CDN Base URLs
    |--------------------------------------------------------------------------
    | Ganti bila ingin self-host atau pakai mirror lain.
    */
    'cdn' => [
        'datatables_css'    => 'https://cdn.datatables.net/{version}/css/dataTables.dataTables.min.css',
        'buttons_css'       => 'https://cdn.datatables.net/buttons/{buttons_version}/css/buttons.dataTables.min.css',
        'jquery_js'         => 'https://code.jquery.com/jquery-3.7.1.min.js',
        'datatables_js'     => 'https://cdn.datatables.net/{version}/js/dataTables.min.js',
        'jszip_js'          => 'https://cdnjs.cloudflare.com/ajax/libs/jszip/{jszip_version}/jszip.min.js',
        'pdfmake_js'        => 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/{pdfmake_version}/pdfmake.min.js',
        'vfs_fonts_js'      => 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/{pdfmake_version}/vfs_fonts.js',
        'buttons_js'        => 'https://cdn.datatables.net/buttons/{buttons_version}/js/dataTables.buttons.min.js',
        'buttons_html5_js'  => 'https://cdn.datatables.net/buttons/{buttons_version}/js/buttons.html5.min.js',
        'buttons_print_js'  => 'https://cdn.datatables.net/buttons/{buttons_version}/js/buttons.print.min.js',
    ],

];
