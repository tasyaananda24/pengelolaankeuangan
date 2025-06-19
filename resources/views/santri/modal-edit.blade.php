<div class="modal fade" id="editSantriModal" tabindex="-1" role="dialog" aria-labelledby="editSantriLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formEditSantri" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Santri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" id="edit_nama" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" id="edit_tempat_lahir" name="tempat_lahir" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea id="edit_alamat" name="alamat" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nama Orang Tua</label>
                        <input type="text" id="edit_nama_ortu" name="nama_ortu" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>No. HP</label>
                        <input type="text" id="edit_no_hp" name="no_hp" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="edit_status" name="status" class="form-control" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
