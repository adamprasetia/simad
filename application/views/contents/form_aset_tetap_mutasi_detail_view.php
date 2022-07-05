<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR <?php echo strtoupper($this->title) ?></strong></h4>
            </div>
        </div>
        <div class="box-body">
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
                    <input type="hidden" name="tanggal" value="<?php echo $parent->tanggal ?>">
                </tr>
                <tr>
                    <td><strong>Uraian</strong></td>
                    <td>: <?php echo $parent->uraian ?></td>
                </tr>
            </table>
            <input type="hidden" name="id_<?php echo $this->module_parent ?>" value="<?php echo $this->input->get('id_'.$this->module_parent) ?>">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan=2><i>Detail Lama</i></td>
                        </tr>
                        <tr>
                            <td><label>Kode SKPD *</label></td>
                            <td>
                                <div class="input-group">
                                    <input type="text" id="kode_skpd_lama" name="kode_skpd_lama" class="form-control" value="<?php echo isset($data->kode_skpd_lama)?$data->kode_skpd_lama:'' ?>">
                                    <span class="input-group-btn">
                                        <button type="button" data-title="Pilih Kode SKPD" class="btn btn-success btn-flat btn-pilih-skpd-lama">Pilih</button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Kode Unik *</label></td>
                            <td>
                                <div class="input-group">
                                    <input type="text" id="kode_unik" name="kode_unik" class="form-control" value="<?php echo isset($data->kode_unik)?$data->kode_unik:'' ?>">
                                    <input type="hidden" id="id_aset_tetap" name="id_aset_tetap" value="<?php echo isset($data->id_aset_tetap)?$data->id_aset_tetap:'' ?>">
                                    <span class="input-group-btn">
                                        <button type="button" data-title="Pilih Nomor Perolehan" class="btn btn-success btn-flat btn-pilih-aset-tetap">Pilih</button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Nomor Perolehan</label></td>
                            <td>
                                <input readonly type="text" id="nomor" name="nomor" class="form-control" value="<?php echo isset($data->nomor)?$data->nomor:'' ?>">        
                            </td>
                        </tr>
                        <tr>
                            <td><label>Kode Barang</label></td>
                            <td>
                                <input readonly type="text" id="kode_barang_lama" name="kode_barang_lama" class="form-control" value="<?php echo isset($data->kode_barang_lama)?$data->kode_barang_lama:'' ?>">        
                            </td>
                        </tr>
                        <tr>
                            <td><label>Nama Barang</label></td>
                            <td>
                                <input readonly type="text" id="nama_barang_lama" name="nama_barang_lama" class="form-control" value="<?php echo isset($data->nama_barang_lama)?$data->nama_barang_lama:'' ?>">        
                            </td>
                        </tr>
                        <tr>
                            <td><label>KIB</label></td>
                            <td>
                                <input readonly type="text" id="kib_lama" name="kib_lama" class="form-control" value="<?php echo isset($data->kib_lama)?$data->kib_lama:'' ?>">        
                            </td>
                        </tr>
     
                    </table>                    
                </div>
                <div class="col-md-6">
                <table class="table table-bordered">
                        <tr>
                            <td colspan=2><i>Detail Baru</i></td>
                        </tr>
                        <tr>
                            <td><label>Kode SKPD *</label></td>
                            <td>
                                <div class="input-group">
                                    <input type="text" id="kode_skpd_baru" name="kode_skpd_baru" class="form-control" value="<?php echo isset($data->kode_skpd_baru)?$data->kode_skpd_baru:'' ?>">
                                    <span class="input-group-btn">
                                        <button type="button" data-title="Pilih Kode SKPD" class="btn btn-success btn-flat btn-pilih-skpd-baru">Pilih</button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Kode Barang *</label></td>
                            <td>
                                <div class="input-group">
                                    <input type="text" id="kode_barang_baru" name="kode_barang_baru" class="form-control" value="<?php echo isset($data->kode_barang_baru)?$data->kode_barang_baru:'' ?>">
                                    <span class="input-group-btn">
                                        <button type="button" data-title="Pilih Kode Barang" class="btn btn-success btn-flat btn-pilih-barang-baru">Pilih</button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Nama Barang *</label></td>
                            <td>
                                <input readonly type="text" id="nama_barang_baru" name="nama_barang_baru" class="form-control" value="<?php echo isset($data->nama_barang_baru)?$data->nama_barang_baru:'' ?>">        
                            </td>
                        </tr>
                        <tr>
                            <td><label>KIB *</label></td>
                            <td>
                                <input readonly type="text" id="kib_baru" name="kib_baru" class="form-control" value="<?php echo isset($data->kib_baru)?$data->kib_baru:'' ?>">        
                            </td>
                        </tr>
                    </table>                    
                </div>
            </div>
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