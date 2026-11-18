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
    | Default Export Buttons
    |--------------------------------------------------------------------------
    | Tombol yang ditampilkan secara default bila prop `buttons` tidak
    | diberikan ke component <x-datatables-export::table />.
    | Pilihan: 'copy', 'csv', 'excel', 'pdf', 'print'
    */
    'default_buttons' => ['copy', 'csv', 'excel', 'pdf', 'print'],

    /*
    |--------------------------------------------------------------------------
    | CDN Base URLs
    |--------------------------------------------------------------------------
    | Ganti bila ingin self-host atau pakai mirror lain.
    */
    'cdn' => [
        'datatables_css'    => 'https://cdn.datatables.net/{version}/css/dataTables.dataTables.min.css',
        'buttons_css'       => 'https://cdn.datatables.net/buttons/{buttons_version}/css/buttons.dataTables.min.css',
        'datatables_js'     => 'https://cdn.datatables.net/{version}/js/dataTables.min.js',
        'jszip_js'          => 'https://cdnjs.cloudflare.com/ajax/libs/jszip/{jszip_version}/jszip.min.js',
        'pdfmake_js'        => 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/{pdfmake_version}/pdfmake.min.js',
        'vfs_fonts_js'      => 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/{pdfmake_version}/vfs_fonts.js',
        'buttons_js'        => 'https://cdn.datatables.net/buttons/{buttons_version}/js/dataTables.buttons.min.js',
        'buttons_html5_js'  => 'https://cdn.datatables.net/buttons/{buttons_version}/js/buttons.html5.min.js',
        'buttons_print_js'  => 'https://cdn.datatables.net/buttons/{buttons_version}/js/buttons.print.min.js',
    ],

];
