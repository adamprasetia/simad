<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR MODUL</strong></h4>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group">
                <input type="hidden" id="id" name="id" value="<?php echo isset($data->id)?$data->id:'' ?>">
                <label>Nama Modul *</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($data->name)?htmlentities($data->name):'' ?>">
            </div>
            <div class="form-group">
                <label>Parent</label>
                <select class="form-control" name="parent" id="parent">
                    <option value="0">- Parent -</option>
                    <?php $modules = $this->db->where('parent', 0)->order_by('order asc')->get('module')->result(); ?>
                    <?php foreach ($modules as $module) { ?>
                        <option <?php echo isset($data->parent) && $data->parent==$module->id?'selected':''?> value="<?php echo $module->id ?>"><?php echo $module->name ?></option>  
                        <?php $childs = $this->db->where('parent', $module->id)->order_by('order asc')->get('module')->result(); ?>                      
                        <?php foreach ($childs as $child) { ?>
                            <option <?php echo isset($data->parent) && $data->parent==$child->id?'selected':''?> value="<?php echo $child->id ?>">--<?php echo $child->name ?></option>  
                            <?php $childs2 = $this->db->where('parent', $child->id)->order_by('order asc')->get('module')->result(); ?>                      
                            <?php foreach ($childs2 as $child2) { ?>
                                <option <?php echo isset($data->parent) && $data->parent==$child2->id?'selected':''?> value="<?php echo $child2->id ?>">----<?php echo $child2->name ?></option>  
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Link</label>
                <input type="text" id="link" name="link" class="form-control" value="<?php echo isset($data->link)?htmlentities($data->link):'' ?>">
            </div>
            <div class="form-group">
                <label>Icon</label>
                <input type="text" id="icon" name="icon" class="form-control" value="<?php echo isset($data->icon)?htmlentities($data->icon):'' ?>">
            </div>
            <div class="form-group">
                <label>Order</label>
                <input type="number" id="order" name="order" class="form-control" value="<?php echo isset($data->order)?htmlentities($data->order):'' ?>">
            </div>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('module/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('module/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>