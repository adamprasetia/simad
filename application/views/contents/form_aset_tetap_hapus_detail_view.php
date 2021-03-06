<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR PELEPASAN ASET TETAP DETAIL</strong></h4>
            </div>
        </div>
        <div class="box-body">
            <input type="hidden" name="id_aset_tetap_hapus" value="<?php echo $this->input->get('id_aset_tetap_hapus') ?>">
            <?php $aset_tetap_hapus = $this->db->where('id', $this->input->get('id_aset_tetap_hapus'))->get('aset_tetap_hapus')->row(); ?>
            <table class="table table-bordered" style="margin-bottom:0px;">
                <tr>
                    <td colspan=2><i>Dokumen</i></td>
                </tr>
                <tr>
                    <td width="50px"><strong>Nomor</strong></td>
                    <td>: <?php echo $aset_tetap_hapus->nomor ?></td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>: <?php echo format_dmy($aset_tetap_hapus->tanggal) ?></td>
                </tr>
                <tr>
                    <td><strong>Uraian</strong></td>
                    <td>: <?php echo $aset_tetap_hapus->uraian ?></td>
                </tr>
            </table>
            <table class="table table-bordered">
                <tr>
                    <td colspan=2><i>Detail Barang</i></td>
                </tr>
                <tr>
                    <td><label>Kode Unik *</label></td>
                    <td>
                        <div class="input-group">
                            <input type="text" id="kode_unik" name="kode_unik" class="form-control" value="<?php echo isset($data->kode_unik)?$data->kode_unik:'' ?>">
                            <input type="hidden" id="id_aset_tetap" name="id_aset_tetap" value="<?php echo isset($data->id_aset_tetap)?$data->id_aset_tetap:'' ?>">
                            <span class="input-group-btn">
                                <button type="button" data-title="Pilih Nomor Perolehan" class="btn btn-success btn-flat btn-pilih-aset-tetap-detail">Pilih</button>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label>Kode Barang</label></td>
                    <td>
                        <input readonly type="text" id="kode_barang" name="kode_barang" class="form-control" value="<?php echo isset($data->kode_barang)?$data->kode_barang:'' ?>">        
                    </td>
                </tr>
                <tr>
                    <td><label>Nama Barang</label></td>
                    <td>
                        <input readonly type="text" id="nama_barang" name="nama_barang" class="form-control" value="<?php echo isset($data->nama_barang)?$data->nama_barang:'' ?>">        
                    </td>
                </tr>
                <tr>
                    <td><label>KIB</label></td>
                    <td>
                        <input readonly type="text" id="kib" name="kib" class="form-control" value="<?php echo isset($data->kib)?$data->kib:'' ?>">        
                    </td>
                </tr>
                <tr>
                    <td><label>Keterangan</label></td>
                    <td><textarea name="info" id="info" cols="30" rows="2" class="form-control"><?php echo isset($data->info)?htmlentities($data->info):'' ?></textarea></td>
                </tr>
                <tr>
                    <td><label>Nilai</label></td>
                    <td><input type="text" id="nilai" name="nilai" class="input-uang form-control" value="<?php echo isset($data->nilai)?$data->nilai:'' ?>"></td>
                </tr>
            </table>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('aset_tetap_hapus_detail/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <?php if($this->uri->segment(2)=='add'): ?>
                <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('aset_tetap_hapus_detail/add').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan Lalu Tambah Lagi" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan Lalu Tambah Lagi</button>
            <?php endif ?>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('aset_tetap_hapus_detail/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>