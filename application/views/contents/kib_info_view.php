<div class="box box-default">
    <div class="box-header with-border">
        <div class="pull-left">
            <h4><strong>DATA KIB INFO</strong></h4>
        </div>
        <?php $kib = $this->db->where('id', $this->input->get('id_kib'))->get('kib')->row(); ?>
        <table class="table table-bordered" style="margin-bottom:0px;">
            <tr>
                <td width="50px"><strong>Nomor</strong></td>
                <td>: <?php echo $kib->nomor ?></td>
            </tr>
            <tr>
                <td width="50px"><strong>Kode</strong></td>
                <td>: <?php echo $kib->kode ?></td>
            </tr>
            <tr>
                <td width="50px"><strong>Nama</strong></td>
                <td>: <?php echo $kib->nama ?></td>
            </tr>
        </table>
    </div>
    <div class="box-header with-border">
        <a href="<?php echo base_url('kib_info/add').get_query_string() ?>" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Tambah Info</a>
        <a href="<?php echo now_url() ?>" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
        <a href="<?php echo base_url('kib').get_query_string() ?>" class="btn btn-default btn-sm"><i class="fa fa-close"></i> Kembali</a>
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
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Awalan</th>
                        <th>Akhiran</th>
                        <th>Urutan</th>
                        <th>Pilihan</th>
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
                        <td><?php echo $value->tipe; ?></td>
                        <td><?php echo $value->awalan; ?></td>
                        <td><?php echo $value->akhiran; ?></td>
                        <td><?php echo $value->urutan; ?></td>
                        <td><?php echo $value->pilihan; ?></td>
                        <td>
                            <a class="btn btn-default" href="<?php echo base_url('kib_info/edit/'.$value->id).get_query_string(); ?>"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-default" type="button" name="button" data-url="<?php echo base_url('kib_info/delete/'.$value->id).get_query_string(); ?>" onclick="return deleteData(this)"><i class="fa fa-trash"></i></button>
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
