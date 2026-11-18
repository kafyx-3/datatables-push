{{--
    Component: <x-datatables-export::table />

    Props:
      id             (string, required)  – ID elemen <table>
      buttons        (array)             – tombol export, e.g. ['copy','csv','excel','pdf','print']
      exportColumns  (array|null)        – indeks kolom (0-based) yang ikut ekspor; null = semua kolom
--}}
@props([
    'id',
    'buttons'       => [],
    'exportColumns' => null,
])

@php
    $resolvedButtons = $buttons ?: config('datatables-export.default_buttons', ['copy','csv','excel','pdf','print']);

    // Bangun konfigurasi button untuk DataTables v2
    // Jika exportColumns diset, bungkus tiap button non-print dengan exportOptions
    $dtButtons = [];
    foreach ($resolvedButtons as $btn) {
        if ($exportColumns !== null && $btn !== 'copy' && $btn !== 'print') {
            $dtButtons[] = [
                'extend'        => $btn,
                'exportOptions' => ['columns' => $exportColumns],
            ];
        } elseif ($exportColumns !== null && $btn === 'copy') {
            $dtButtons[] = [
                'extend'        => 'copy',
                'exportOptions' => ['columns' => $exportColumns],
            ];
        } else {
            $dtButtons[] = $btn;
        }
    }

    $dtButtonsJson = json_encode($dtButtons, JSON_UNESCAPED_UNICODE);
@endphp

<table id="{{ $id }}" class="display" style="width:100%">
    {{ $slot }}
</table>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new DataTable('#{{ $id }}', {
        layout: {
            topStart: {
                buttons: {!! $dtButtonsJson !!}
            }
        }
    });
});
</script>
