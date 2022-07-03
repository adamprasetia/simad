<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR BARANG PERSEDIAAN</strong></h4>
            </div>
        </div>
        <div class="box-body">
        <table class="table table-bordered">
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
                    <input readonly type="text" id="nama_barang" name="nama_barang" class="form-control" value="<?php echo isset($data->nama_barang)?$data->nama_barang:'' ?>">        
                </td>
            </tr>
            <tr>
                <td><label>Satuan</label></td>
                <td>
                    <input readonly type="text" id="satuan" name="satuan" class="form-control" value="<?php echo isset($data->satuan)?$data->satuan:'' ?>">        
                </td>
            </tr>
            <tr>
                <td><label>Jumlah</label></td>
                <td><input type="text" id="jumlah" name="jumlah" class="input-uang form-control" value="<?php echo isset($data->jumlah)?$data->jumlah:'' ?>"></td>
            </tr>
        </table>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('barang_persediaan/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('barang_persediaan/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>