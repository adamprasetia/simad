<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR <?php echo strtoupper($this->title) ?></strong></h4>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label>Nomor *</label>
                <input type="text" id="nomor" name="nomor" class="form-control" value="<?php echo isset($data->nomor)?htmlentities($data->nomor):'' ?>">
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" id="tanggal" name="tanggal" class="form-control datetimepicker" value="<?php echo isset($data->tanggal)?format_dmy($data->tanggal):'' ?>">
            </div>
            <div class="form-group">
                <label>Uraian</label>
                <textarea name="uraian" id="uraian" cols="30" rows="2" class="form-control"><?php echo isset($data->uraian)?htmlentities($data->uraian):'' ?></textarea>
            </div>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url($this->module.'/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url($this->module.'/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>