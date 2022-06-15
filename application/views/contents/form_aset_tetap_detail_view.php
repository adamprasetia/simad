<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR PEROLEHAN ASET TETAP DETAIL</strong></h4>
            </div>
            <?php $aset_tetap = $this->db->where('id', $this->input->get('id_aset_tetap'))->get('aset_tetap')->row(); ?>
            <table class="table table-bordered" style="margin-bottom:0px;">
                <tr>
                    <td colspan=2><i>Dokumen</i></td>
                </tr>
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
            <input type="hidden" name="id_aset_tetap" value="<?php echo $this->input->get('id_aset_tetap') ?>">
            <div class="row">
                <div class="col-md-6">
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
                            <td><label>Nama Barang</label></td>
                            <td>
                                <input type="text" id="nama_barang" name="nama_barang" class="form-control" value="<?php echo isset($data->nama_barang)?$data->nama_barang:'' ?>">        
                            </td>
                        </tr>
                        <tr>
                            <td><label>Umur Aset</label></td>
                            <td>
                                <div class="input-group">
                                    <input type="text" id="umur" name="umur" class="input-uang form-control" value="<?php echo isset($data->umur)?$data->umur:'' ?>">
                                    <span class="input-group-addon">Tahun</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Jumlah</label></td>
                            <td><input type="text" id="jumlah" name="jumlah" class="input-uang form-control" value="<?php echo isset($data->jumlah)?$data->jumlah:'' ?>"></td>
                        </tr>
                        <tr>
                            <td><label>Nilai</label></td>
                            <td><input type="text" id="nilai" name="nilai" class="input-uang form-control" value="<?php echo isset($data->nilai)?$data->nilai:'' ?>"></td>
                        </tr>
                        <tr>
                            <td><label>Info</label></td>
                            <td><textarea name="info" id="info" cols="30" rows="2" class="form-control"><?php echo isset($data->info)?htmlentities($data->info):'' ?></textarea></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td colspan=2><i>Info Lainnya</i></td>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $kib_info = $this->db->select('a.*, b.nomor')->order_by('urutan asc')->join('kib b','a.id_kib=b.id','left')->get('kib_info a')->result(); ?>
                            <?php foreach ($kib_info as $row) { ?>                                
                                <tr class="kib-<?php echo $row->nomor ?>">
                                    <td style="width:150px"><label><?php echo $row->nama ?></label></td>
                                    <td>
                                        <?php if(!empty($row->awalan) || !empty($row->akhiran)): ?>
                                            <div class="input-group">
                                        <?php endif ?>
                                            <?php if(!empty($row->awalan)): ?>
                                                <span class="input-group-addon"><?php echo $row->awalan ?></span>
                                            <?php endif ?>

                                            <?php if($row->tipe=='keterangan'):?>
                                                <textarea name="<?php echo $row->kode ?>" id="<?php echo $row->kode ?>" cols="30" rows="2" class="form-control"><?php echo isset($data->info_lain->{$row->kode})?$data->info_lain->{$row->kode}:'' ?></textarea>
                                            <?php elseif($row->tipe=='pilihan'):?>
                                                <?php $pilihans = explode(',', $row->pilihan) ?>                                                
                                                <select name="<?php echo $row->kode ?>" id="<?php echo $row->kode ?>" class="form-control">
                                                    <?php foreach ($pilihans as $pilihan) { ?>
                                                        <option <?php echo isset($data->info_lain->{$row->kode}) && $data->info_lain->{$row->kode}==$pilihan?'selected':'' ?> value="<?php echo $pilihan ?>"><?php echo $pilihan ?></option>
                                                    <?php } ?>
                                                </select>
                                            <?php else: ?>
                                                <input type="<?php echo $row->tipe=='angka'?'number':'text'?>" id="<?php echo $row->kode ?>" name="<?php echo $row->kode ?>" class="form-control <?php echo $row->tipe=='tanggal'?'datetimepicker':''?> <?php echo $row->tipe=='uang'?'input-uang':''?>" value="<?php echo isset($data->info_lain->{$row->kode})?$data->info_lain->{$row->kode}:'' ?>">
                                            <?php endif ?>

                                            <?php if(!empty($row->akhiran)): ?>
                                                <span class="input-group-addon"><?php echo $row->akhiran ?></span>
                                            <?php endif ?>
                                        <?php if(!empty($row->awalan)|| !empty($row->akhiran)): ?>
                                            </div>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php } ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('aset_tetap_detail/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <?php if($this->uri->segment(2)=='add'): ?>
                <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('aset_tetap_detail/add').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan Lalu Tambah Lagi</button>
            <?php endif ?>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('aset_tetap_detail/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>