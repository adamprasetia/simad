<div class="box box-default">
    <?php if(empty($this->input->get('popup'))): ?>
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>DATA BARANG</strong></h4>
            </div>
        </div>
    <?php endif ?>
    <div class="box-header with-border">
        <?php if(empty($this->input->get('popup'))): ?>
            <a href="<?php echo base_url('barang/add') ?>" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Tambah barang</a>
        <?php endif ?>
        <a href="<?php echo now_url() ?>" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
    </div>
    <div class="box-header with-border">
        <div class="pull-left">
            <form id="form-filter" action="<?php echo base_url('barang') ?>" method="get" class="form-inline">
                <input type="hidden" name="popup" value="<?php echo $this->input->get('popup') ?>">
                <div class="form-group">
                    <input name="search" type="text" class="form-control" placeholder="Search..." data-url="<?php echo current_url() ?>" data-query-string="<?php echo get_query_string(array('search','page')) ?>" value="<?php echo $this->input->get('search') ?>">
                </div>
                <div class="form-group">
                    <select name="kib" id="kib" class="form-control">
                        <option value="">- pilih kib -</option>
                        <?php foreach (config_item('kib') as $key => $value) { ?>
                            <option <?php echo $this->input->get('kib')==$key?'selected':'' ?> value="<?php echo $key ?>"><?php echo $value['id'].' | '.$value['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="submit" value="Filter" class="btn btn-primary" onclick="document.getElementById('form-filter').submit()">
            </form>
        </div>
        <div class="pull-right">
            <?php echo isset($paging)?$paging:'' ?>
        </div>
    </div>
    <div class="box-body no-padding">
        <div class="table-responsive no-margin">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>KIB</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                      <?php
                            $no=1+$offset;
                            foreach ($data as $key => $value){
                      ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $value->kode; ?></td>
                        <td><?php echo $value->nama; ?></td>
                        <td><?php echo $value->kib; ?></td>
                        <td>
                            <?php if(!empty($this->input->get('popup'))): ?>
                                <button class="btn btn-primary btn-choose-barang" type="button" name="button" data-id="<?php echo $value->id ?>"><i class="fa fa-use"></i> Pilih</button>
                                <div style="display:none" id="data-<?php echo $value->id ?>"><?php echo json_encode($value) ?></div>
                            <?php else: ?>
                                <a class="btn btn-default" href="<?php echo base_url('barang/edit/'.$value->id).get_query_string(); ?>"><i class="fa fa-edit"></i></a>
                                <button class="btn btn-default" type="button" name="button" data-url="<?php echo base_url('barang/delete/'.$value->id).get_query_string(); ?>" onclick="return deleteData(this)"><i class="fa fa-trash"></i></button>
                            <?php endif ?>
                        </td>
                    </tr>
                      <?php $no++; } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box-footer">
        <label><?php echo isset($total)?$total:'' ?></label>
        <div class="pull-right">
            <?php echo isset($paging)?$paging:'' ?>
        </div>
    </div>
</div>
