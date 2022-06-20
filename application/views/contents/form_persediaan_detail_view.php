<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR <?php echo strtoupper($this->title) ?></strong></h4>
            </div>
        </div>
        <div class="box-body">
            <input type="hidden" name="id_<?php echo $this->module_parent ?>" value="<?php echo $this->input->get('id_'.$this->module_parent) ?>">
            <?php $parent = $this->db->where('id', $this->input->get('id_'.$this->module_parent))->get($this->module_parent)->row(); ?>
            <table class="table table-bordered" style="margin-bottom:0px;">
                <tr>
                    <td colspan=2><i>Dokumen</i></td>
                </tr>
                <tr>
                    <td width="50px"><strong>Nomor</strong></td>
                    <td>: <?php echo $parent->nomor ?></td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>: <?php echo format_dmy($parent->tanggal) ?></td>
                </tr>
                <tr>
                    <td><strong>Uraian</strong></td>
                    <td>: <?php echo $parent->uraian ?></td>
                </tr>
            </table>
            <table class="table table-bordered">
                <tr>
                    <td colspan=2><i>Detail Barang</i></td>
                </tr>
                <tr>
                    <td style="width:150px"><label>Metode Pencatatan *</label></td>
                    <td>
                    <select name="metode" id="metode" class="form-control">
                        <?php foreach (config_item('metode') as $key => $value) { ?>
                            <option <?php echo isset($data->metode) && $data->metode==$key?'selected':'' ?> value="<?php echo $key ?>"><?php echo $value['name'] ?></option>
                        <?php } ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Kode Barang *</label></td>
                    <td>
                        <div class="input-group">
                            <input type="text" id="kode_barang" name="kode_barang" class="form-control" value="<?php echo isset($data->kode_barang)?$data->kode_barang:'' ?>">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success btn-flat btn-pilih-barang-persediaan">Pilih</button>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label>Nama Barang</label></td>
                    <td>
                        <input type="text" id="nama_barang" name="nama_barang" class="form-control" value="<?php echo isset($data->nama_barang)?$data->nama_barang:'' ?>">        
                    </td>
                </tr>
                <tr>
                    <td><label>Masa Berlaku</label></td>
                    <td>
                        <input type="text" id="masa_berlaku" name="masa_berlaku" class="form-control datetimepicker" value="<?php echo isset($data->masa_berlaku)?format_dmy($data->masa_berlaku):'' ?>">
                    </td>
                </tr>
                <tr>
                    <td><label>Jumlah</label></td>
                    <td><input type="text" id="jumlah" name="jumlah" class="input-uang form-control" value="<?php echo isset($data->jumlah)?$data->jumlah:'' ?>"></td>
                </tr>
                <tr>
                    <td><label>Satuan</label></td>
                    <td>
                        <input type="text" id="satuan" name="satuan" class="form-control" value="<?php echo isset($data->satuan)?$data->satuan:'' ?>">        
                    </td>
                </tr>
                <tr>
                    <td><label>Nilai</label></td>
                    <td><input type="text" id="nilai" name="nilai" class="input-uang form-control" value="<?php echo isset($data->nilai)?$data->nilai:'' ?>"></td>
                </tr>
            </table>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url($this->module.'/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <?php if($this->uri->segment(2)=='add'): ?>
                <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url($this->module.'/add').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan Lalu Tambah Lagi" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan Lalu Tambah Lagi</button>
            <?php endif ?>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url($this->module.'/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>