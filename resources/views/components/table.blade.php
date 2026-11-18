{{--
    Component: <x-datatables-export::table />

    Render elemen <table> saja. Inisialisasi DataTable ditulis sendiri oleh user
    di dalam <script> di halaman masing-masing.

    Props:
      id     (string, required) – ID unik elemen <table>. Harus unik per halaman.
      class  (string)           – Class CSS tambahan. Default: 'display'

    Contoh:
      <x-datatables-export::table id="tabelAlat" class="table table-bordered table-striped">
          ...
      </x-datatables-export::table>

      <script>
      document.addEventListener('DOMContentLoaded', function () {
          new DataTable('#tabelAlat', {
              layout: {
                  topStart: {
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                  }
              }
          });
      });
      </script>
--}}
@props([
    'id',
    'class' => 'display',
])

<table id="{{ $id }}" class="{{ $class }}" style="width:100%">
    {{ $slot }}
</table>
