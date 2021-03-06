<div class="box box-default">
    <?php if(empty($this->input->get('popup'))): ?>
    <div class="box-header with-border">
        <div class="pull-left">
            <h4><strong>DATA SKPD</strong></h4>
        </div>
    </div>
    <?php endif ?>
    <div class="box-header with-border">
        <?php if(empty($this->input->get('popup'))): ?>
            <a href="<?php echo base_url('skpd/add') ?>" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Tambah SKPD</a>
        <?php endif ?>
        <a href="<?php echo now_url() ?>" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
        <div class="pull-right">
            <div class="has-feedback">
                <input id="input_search" type="text" class="form-control input-sm" placeholder="Search..." data-url="<?php echo current_url() ?>" data-query-string="<?php echo get_query_string(array('search','page')) ?>" value="<?php echo $this->input->get('search') ?>">
            </div>
        </div>
    </div>
    <div class="box-body no-padding">
        <div class="table-responsive no-margin">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Kode</th>
                        <th>Nama SKPD</th>
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
                        <td>
                            <?php if(!empty($this->input->get('popup'))): ?>
                                <button class="btn btn-primary btn-choose-skpd" type="button" name="button" data-id="<?php echo $value->id ?>"><i class="fa fa-use"></i> Pilih</button>
                                <div style="display:none" id="data-<?php echo $value->id ?>"><?php echo json_encode($value) ?></div>
                            <?php else: ?>                            
                                <a class="btn btn-default" href="<?php echo base_url('skpd/edit/'.$value->id); ?>"><i class="fa fa-edit"></i></a>
                                <button class="btn btn-default" type="button" name="button" data-url="<?php echo base_url('skpd/delete/'.$value->id); ?>" onclick="return deleteData(this)"><i class="fa fa-trash"></i></button>
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
