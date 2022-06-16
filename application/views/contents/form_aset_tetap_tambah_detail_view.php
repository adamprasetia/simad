<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR PENAMBAHAN ASET TETAP DETAIL</strong></h4>
            </div>
        </div>
        <div class="box-body">
            <input type="hidden" name="id_aset_tetap_tambah" value="<?php echo $this->input->get('id_aset_tetap_tambah') ?>">
            <?php $aset_tetap_tambah = $this->db->where('id', $this->input->get('id_aset_tetap_tambah'))->get('aset_tetap_tambah')->row(); ?>
            <table class="table table-bordered" style="margin-bottom:0px;">
                <tr>
                    <td colspan=2><i>Dokumen</i></td>
                </tr>
                <tr>
                    <td width="50px"><strong>Nomor</strong></td>
                    <td>: <?php echo $aset_tetap_tambah->nomor ?></td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>: <?php echo format_dmy($aset_tetap_tambah->tanggal) ?></td>
                </tr>
                <tr>
                    <td><strong>Uraian</strong></td>
                    <td>: <?php echo $aset_tetap_tambah->uraian ?></td>
                </tr>
            </table>
            <table class="table table-bordered">
                <tr>
                    <td colspan=2><i>Detail Barang</i></td>
                </tr>
                <tr>
                    <td style="width:150px"><label>KIB *</label></td>
                    <td>
                    <select name="kib" id="kib" class="form-control">
                        <?php foreach (config_item('kib') as $key => $value) { ?>
                            <option <?php echo isset($data->kib) && $data->kib==$key?'selected':'' ?> value="<?php echo $key ?>"><?php echo $value['id'].' | '.$value['name'] ?></option>
                        <?php } ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Kode Barang *</label></td>
                    <td>
                    <select name="kode_barang" id="kode_barang" class="form-control" style="width: 100%">
                        <?php if(!empty($data->kode_barang)){ ?>
                            <option value="<?php echo $data->kode_barang ?>"><?php echo $data->kode_barang.' | '.$data->nama_barang ?></option>
                        <?php } ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Nama Barang *</label></td>
                    <td>
                        <input type="text" id="nama_barang" name="nama_barang" class="form-control" value="<?php echo isset($data->nama_barang)?$data->nama_barang:'' ?>">        
                    </td>
                </tr>
                <tr>
                    <td><label>Tahun Perolehan *</label></td>
                    <td>
                        <select name="tahun" id="tahun" class="form-control">
                        <?php for ($i=date('Y'); $i >= date('Y')-5; $i--) { ?>
                            <option <?php echo (isset($data->tahun) && $data->tahun==$i?'selected':'')?> value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Nomor Perolehan *</label></td>
                    <td>
                        <select name="id_aset_tetap_detail" id="id_aset_tetap_detail" class="form-control" style="width: 100%">
                        <?php if(!empty($data->id_aset_tetap_detail)){ ?>
                            <option value="<?php echo $data->id_aset_tetap_detail ?>"><?php echo $data->nomor ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" id="nomor" name="nomor" class="form-control" value="<?php echo isset($data->nomor)?$data->nomor:'' ?>">        
                    </td>
                </tr>
                <tr>
                    <td><label>Info</label></td>
                    <td><textarea name="info" id="info" cols="30" rows="2" class="form-control"><?php echo isset($data->info)?htmlentities($data->info):'' ?></textarea></td>
                </tr>
                <tr>
                    <td><label>Umur Bertambah *</label></td>
                    <td>
                        <div class="input-group">
                            <input type="text" id="umur" name="umur" class="input-uang form-control" value="<?php echo isset($data->umur)?$data->umur:'' ?>">
                            <span class="input-group-addon">Tahun</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label>Nilai Bertambah *</label></td>
                    <td><input type="text" id="nilai" name="nilai" class="input-uang form-control" value="<?php echo isset($data->nilai)?$data->nilai:'' ?>"></td>
                </tr>
            </table>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('aset_tetap_tambah_detail/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <?php if($this->uri->segment(2)=='add'): ?>
                <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('aset_tetap_tambah_detail/add').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan Lalu Tambah Lagi" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan Lalu Tambah Lagi</button>
            <?php endif ?>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('aset_tetap_tambah_detail/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>