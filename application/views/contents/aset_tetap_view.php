<div class="box box-default">
    <?php if(empty($this->input->get('popup'))): ?>
    <div class="box-header with-border">
        <div class="pull-left">
            <h4><strong>DATA <?php echo strtoupper($this->title) ?></strong></h4>
        </div>
    </div>
    <?php endif ?>
    <?php if(empty($this->input->get('popup'))): ?>
    <div class="box-header with-border">
        <a href="<?php echo base_url($this->module.'/add').get_query_string() ?>" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Tambah Detail</a>
        <a href="<?php echo base_url($this->module) ?>" class="btn btn-default btn-sm"><i class="fa fa-close"></i> Kembali</a>
        <a href="<?php echo now_url() ?>" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
    </div>
    <?php endif ?>
    <div class="box-header with-border">
        <div class="pull-left">
            <form id="form-filter" action="<?php echo base_url($this->module).get_query_string() ?>" method="get" class="form-inline">
                <input type="hidden" name="popup" value="<?php echo $this->input->get('popup') ?>">
                <input type="hidden" name="id_aset_tetap_oleh" value="<?php echo $this->input->get('id_aset_tetap_oleh') ?>">
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
    <div class="box-body">
        <div class="table-responsive no-margin">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Kode Unik</th>
                        <th>Tanggal</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>KIB</th>
                        <th>Nilai</th>
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
                        <td><?php echo $value->kode_unik; ?></td>
                        <td><?php echo format_dmy($value->tanggal); ?></td>
                        <td><?php echo $value->kode_barang; ?></td>
                        <td><?php echo $value->nama_barang; ?></td>
                        <td><?php echo config_item('kib')[$value->kib]['id']; ?></td>
                        <td><?php echo number_format($value->nilai); ?></td>
                        <td>
                            <?php if(!empty($this->input->get('popup'))): ?>
                                <button class="btn btn-primary btn-choose-aset-tetap" type="button" name="button" data-id="<?php echo $value->id ?>"><i class="fa fa-use"></i> Pilih</button>
                                <div style="display:none" id="data-<?php echo $value->id ?>"><?php $value->kib = config_item('kib')[$value->kib]['id'];$value->nilai = number_format($value->nilai);echo json_encode($value) ?></div>
                            <?php else: ?>                                
                                <a class="btn btn-default" href="<?php echo base_url($this->module.'/edit/'.$value->id).get_query_string(); ?>"><i class="fa fa-edit"></i></a>
                                <button class="btn btn-default" type="button" name="button" data-url="<?php echo base_url($this->module.'/delete/'.$value->id).get_query_string(); ?>" onclick="return deleteData(this)"><i class="fa fa-trash"></i></button>
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
