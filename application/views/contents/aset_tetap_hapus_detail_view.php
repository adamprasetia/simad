<div class="box box-default">
    <div class="box-header with-border">
        <div class="pull-left">
            <h4><strong>DATA PELEPASAN ASET TETAP DETAIL</strong></h4>
        </div>
        <?php $aset_tetap_hapus = $this->db->where('id', $this->input->get('id_aset_tetap_hapus'))->get('aset_tetap_hapus')->row(); ?>
        <table class="table table-bordered" style="margin-bottom:0px;">
            <tr>
                <td width="50px"><strong>Nomor</strong></td>
                <td>: <?php echo $aset_tetap_hapus->nomor ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td>: <?php echo format_dmy($aset_tetap_hapus->tanggal) ?></td>
            </tr>
            <tr>
                <td><strong>Uraian</strong></td>
                <td>: <?php echo $aset_tetap_hapus->uraian ?></td>
            </tr>
        </table>
    </div>
    <div class="box-header with-border">
        <a href="<?php echo base_url('aset_tetap_hapus_detail/add').get_query_string() ?>" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Tambah Detail</a>
        <a href="<?php echo now_url() ?>" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
        <a href="<?php echo base_url('aset_tetap_hapus').get_query_string() ?>" class="btn btn-default btn-sm"><i class="fa fa-close"></i> Kembali</a>
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
                        <th>KIB</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Nomor Perolehan</th>
                        <th>Info</th>
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
                        <td><?php echo config_item('kib')[$value->kib]['id']; ?></td>
                        <td><?php echo $value->kode_barang; ?></td>
                        <td><?php echo $value->nama_barang; ?></td>
                        <td><?php echo $value->nomor; ?></td>
                        <td><?php echo $value->info; ?></td>
                        <td><?php echo number_format($value->nilai); ?></td>
                        <td>
                            <a class="btn btn-default" href="<?php echo base_url('aset_tetap_hapus_detail/edit/'.$value->id).get_query_string(); ?>"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-default" type="button" name="button" data-url="<?php echo base_url('aset_tetap_hapus_detail/delete/'.$value->id).get_query_string(); ?>" onclick="return deleteData(this)"><i class="fa fa-trash"></i></button>
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
