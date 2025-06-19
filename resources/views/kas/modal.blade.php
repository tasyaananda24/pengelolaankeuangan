<!-- Modal Tambah Kredit -->
<div class="modal fade" id="tambahKreditModal" ... > ... </div>

<!-- Modal Tambah Debit -->
<div class="modal fade" id="tambahDebitModal" ... > ... </div>

<!-- Modal Edit -->
@foreach ($transaksi as $item)
<div class="modal fade" id="editModal{{ $item->id }}" ... > ... </div>
@endforeach
