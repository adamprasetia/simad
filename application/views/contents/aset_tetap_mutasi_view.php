<div class="box box-default">
    <div class="box-header with-border">
        <div class="pull-left">
            <h4><strong>DATA <?php echo strtoupper($this->title) ?></strong></h4>
        </div>
    </div>
    <div class="box-header with-border">
        <a href="<?php echo base_url($this->module.'/add').get_query_string() ?>" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Tambah Detail</a>
        <a href="<?php echo now_url() ?>" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
        <a href="<?php echo base_url($this->module).get_query_string() ?>" class="btn btn-default btn-sm"><i class="fa fa-close"></i> Kembali</a>
        <div class="pull-right">
            <div class="has-feedback">
                <input id="input_search" type="text" class="form-control input-sm" placeholder="Search..." data-url="<?php echo current_url() ?>" data-query-string="<?php echo get_query_string(array('search','page')) ?>" value="<?php echo $this->input->get('search') ?>">
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive no-margin">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Kode Unik</th>
                        <th>KIB</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Nomor Perolehan</th>
                        <th>KIB Baru</th>
                        <th>Kode Barang Baru</th>
                        <th>Nama Barang Baru</th>
                        <th>Nomor Perolehan Baru</th>
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
                        <td><?php echo config_item('kib')[$value->kib]['id']; ?></td>
                        <td><?php echo $value->kode_barang; ?></td>
                        <td><?php echo $value->nama_barang; ?></td>
                        <td><?php echo $value->nomor; ?></td>
                        <td><?php echo config_item('kib')[$value->kib_baru]['id']; ?></td>
                        <td><?php echo $value->kode_barang_baru; ?></td>
                        <td><?php echo $value->nama_barang_baru; ?></td>
                        <td><?php echo $value->nomor_baru; ?></td>
                        <td>
                            <a class="btn btn-default" href="<?php echo base_url($this->module.'/edit/'.$value->id).get_query_string(); ?>"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-default" type="button" name="button" data-url="<?php echo base_url($this->module.'/delete/'.$value->id).get_query_string(); ?>" onclick="return deleteData(this)"><i class="fa fa-trash"></i></button>
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
