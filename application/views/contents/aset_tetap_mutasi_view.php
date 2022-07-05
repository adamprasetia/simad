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
                        <th style="text-align:center;vertical-align:middle" width="50" rowspan=2>No</th>
                        <th style="text-align:center;vertical-align:middle" rowspan=2>Kode Unik</th>
                        <th style="text-align:center" colspan="3">Lama</th>
                        <th style="text-align:center" colspan="3">Baru</th>
                        <th style="text-align:center;vertical-align:middle" rowspan=2 width="100">Aksi</th>
                    </tr>
                    <tr>
                        <th>SKPD</th>
                        <th>Barang</th>
                        <th>KIB</th>
                        <th>SKPD</th>
                        <th>Barang</th>
                        <th>KIB</th>
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
                        <td><?php echo $value->kode_skpd_lama.'<br>'.$value->nama_skpd_lama; ?></td>
                        <td><?php echo $value->kode_barang_lama.'<br>'.$value->nama_barang_lama; ?></td>
                        <td><?php echo config_item('kib')[$value->kib_lama]['id']; ?></td>
                        <td><?php echo $value->kode_skpd_baru.'<br>'.$value->nama_skpd_baru; ?></td>
                        <td><?php echo $value->kode_barang_baru.'<br>'.$value->nama_barang_baru; ?></td>
                        <td><?php echo config_item('kib')[$value->kib_baru]['id']; ?></td>
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
