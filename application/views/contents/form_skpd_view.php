<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR SKPD</strong></h4>
            </div>
        </div>
        <div class="box-body">
            <input type="hidden" id="id" name="id" value="<?php echo isset($data->id)?$data->id:'' ?>">
            <div class="form-group">
                <label>Kode SKPD *</label>
                <input type="text" id="kode" name="kode" class="form-control" value="<?php echo isset($data->kode)?htmlentities($data->kode):'' ?>">
            </div>
            <div class="form-group">
                <label>Nama SKPD *</label>
                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo isset($data->nama)?htmlentities($data->nama):'' ?>">
            </div>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('skpd/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('skpd/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>