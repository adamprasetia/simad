<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR PEROLEHAN ASET TETAP DETAIL</strong></h4>
            </div>
            <?php $aset_tetap = $this->db->where('id', $this->input->get('aset_tetap_id'))->get('aset_tetap')->row(); ?>
            <table class="table table-bordered" style="margin-bottom:0px;">
                <tr>
                    <td width="50px"><strong>Nomor</strong></td>
                    <td>: <?php echo $aset_tetap->nomor ?></td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>: <?php echo format_dmy($aset_tetap->tanggal) ?></td>
                </tr>
                <tr>
                    <td><strong>Uraian</strong></td>
                    <td>: <?php echo $aset_tetap->uraian ?></td>
                </tr>
            </table>
        </div>
        <div class="box-body">
            <input type="hidden" name="aset_tetap_id" value="<?php echo $this->input->get('aset_tetap_id') ?>">
            <div class="form-group">
                <label>KIB *</label>
                <select name="kib" id="kib" class="form-control">
                <?php foreach (config_item('kib') as $key => $value) { ?>
                    <option <?php echo isset($data->kib) && $data->kib==$key?'selected':'' ?> value="<?php echo $key ?>"><?php echo $value['id'].' | '.$value['name'] ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Kode Barang *</label>
                <select name="kode_barang" id="kode_barang" class="form-control">
                    <?php if(!empty($data->kode_barang)){ ?>
                        <option value="<?php echo $data->kode_barang ?>"><?php echo $data->kode_barang.' | '.$data->nama_barang ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" class="form-control" value="<?php echo isset($data->nama_barang)?$data->nama_barang:'' ?>">
            </div>
            <div class="form-group">
                <label>Umur</label>
                <input type="text" id="umur" name="umur" class="input-uang form-control" value="<?php echo isset($data->umur)?$data->umur:'' ?>">
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="text" id="jumlah" name="jumlah" class="input-uang form-control" value="<?php echo isset($data->jumlah)?$data->jumlah:'' ?>">
            </div>
            <div class="form-group">
                <label>Nilai</label>
                <input type="text" id="nilai" name="nilai" class="input-uang form-control" value="<?php echo isset($data->nilai)?$data->nilai:'' ?>">
            </div>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('aset_tetap_detail/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('aset_tetap_detail/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>