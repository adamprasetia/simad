<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR HAK AKSES</strong></h4>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group">
                <input type="hidden" id="id" name="id" value="<?php echo isset($data->id)?$data->id:'' ?>">
                <label>Nama Hak Akses *</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($data->name)?htmlentities($data->name):'' ?>">
            </div>
            <div class="form-group">
                <label>Modul *</label>
                <?php $modules = $this->db->where('parent', 0)->order_by('order asc')->get('module')->result(); ?>
                <?php foreach ($modules as $module) { ?>
                    <div class="checkbox"><label><input type="checkbox" <?php echo (!empty($data_module) && in_array($module->id, $data_module)?'checked':'')?> name="module[]" value="<?php echo $module->id ?>"> <?php echo $module->name ?></label></div>
                    <?php $childs = $this->db->where('parent', $module->id)->order_by('order asc')->get('module')->result(); ?>                      
                    <?php foreach ($childs as $child) { ?>
                        <div style="margin-left:20px" class="checkbox"><label><input type="checkbox" <?php echo (!empty($data_module) && in_array($child->id, $data_module)?'checked':'')?> name="module[]" value="<?php echo $child->id ?>"> <?php echo $child->name ?></label></div>
                        <?php $childs2 = $this->db->where('parent', $child->id)->order_by('order asc')->get('module')->result(); ?>                      
                        <?php foreach ($childs2 as $child2) { ?>
                            <div style="margin-left:40px" class="checkbox"><label><input type="checkbox" <?php echo (!empty($data_module) && in_array($child2->id, $data_module)?'checked':'')?> name="module[]" value="<?php echo $child2->id ?>"> <?php echo $child2->name ?></label></div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('role/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('role/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>