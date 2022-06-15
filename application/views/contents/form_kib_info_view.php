<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR KIB INFO</strong></h4>
            </div>
            <?php $kib = $this->db->where('id', $this->input->get('id_kib'))->get('kib')->row(); ?>
            <table class="table table-bordered" style="margin-bottom:0px;">
                <tr>
                    <td colspan=2><i>KIB</i></td>
                </tr>
                <tr>
                    <td width="50px"><strong>Nomor</strong></td>
                    <td>: <?php echo $kib->nomor ?></td>
                </tr>
                <tr>
                    <td width="50px"><strong>Kode</strong></td>
                    <td>: <?php echo $kib->kode ?></td>
                </tr>
                <tr>
                    <td width="50px"><strong>Nama</strong></td>
                    <td>: <?php echo $kib->nama ?></td>
                </tr>
            </table>
        </div>
        <div class="box-body">
            <input type="hidden" name="id_kib" value="<?php echo $this->input->get('id_kib') ?>">
            <table class="table table-bordered">
                <tr>
                    <td colspan=2><i>Detail Info</i></td>
                </tr>
                <tr>
                    <td><label>Kode *</label></td>
                    <td>
                        <input type="text" id="kode" name="kode" class="form-control" value="<?php echo isset($data->kode)?$data->kode:'' ?>">        
                    </td>
                </tr>
                <tr>
                    <td><label>Nama *</label></td>
                    <td>
                        <input type="text" id="nama" name="nama" class="form-control" value="<?php echo isset($data->nama)?$data->nama:'' ?>">        
                    </td>
                </tr>

                <tr>
                    <td style="width:150px"><label>Tipe *</label></td>
                    <td>
                    <select name="tipe" id="tipe" class="form-control">
                        <?php foreach (config_item('kib_info_tipe') as $row) { ?>
                            <option <?php echo isset($data->tipe) && $data->tipe==$row?'selected':'' ?> value="<?php echo $row ?>"><?php echo $row ?></option>
                        <?php } ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Awalan</label></td>
                    <td>
                        <input type="text" id="awalan" name="awalan" class="form-control" value="<?php echo isset($data->awalan)?$data->awalan:'' ?>">        
                    </td>
                </tr>
                <tr>
                    <td><label>Akhiran</label></td>
                    <td>
                        <input type="text" id="akhiran" name="akhiran" class="form-control" value="<?php echo isset($data->akhiran)?$data->akhiran:'' ?>">        
                    </td>
                </tr>
                <tr>
                    <td><label>Urutan</label></td>
                    <td>
                        <input type="number" id="urutan" name="urutan" class="form-control" value="<?php echo isset($data->urutan)?$data->urutan:'' ?>">        
                    </td>
                </tr>
                <tr>
                    <td><label>Pilihan</label></td>
                    <td>
                        <textarea name="pilihan" id="pilihan" cols="30" rows="2" class="form-control"><?php echo isset($data->pilihan)?htmlentities($data->pilihan):'' ?></textarea>
                        * pisah dengan koma (,)
                    </td>
                </tr>

            </table>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('kib_info/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <?php if($this->uri->segment(2)=='add'): ?>
                <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('kib_info/add').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan Lalu Tambah Lagi</button>
            <?php endif ?>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('kib_info/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>