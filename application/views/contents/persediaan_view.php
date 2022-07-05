<div class="box box-default">
    <?php if(empty($this->input->get('popup'))): ?>    
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>DATA PERSEDIAAN</strong></h4>
            </div>
        </div>
    <?php endif ?>    
    <div class="box-header with-border">
        <a href="<?php echo base_url('persediaan/add').get_query_string() ?>" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Tambah Persediaan</a>
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
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Jumlah Tersedia</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                      <?php
                            $no=1+$offset;
                            foreach ($data as $key => $value){
                      ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $value->kode_barang; ?></td>
                        <td><?php echo $value->nama_barang; ?></td>
                        <td><?php echo $value->satuan; ?></td>
                        <td><?php echo number_format($value->stok); ?></td>
                        <td style="width:200px">
                            <?php if(!empty($this->input->get('popup'))): ?>
                                <button class="btn btn-primary btn-choose-persediaan" type="button" name="button" data-id="<?php echo $value->id ?>">Pilih</button>
                                <div style="display:none" id="data-<?php echo $value->id ?>"><?php $value->stok = number_format($value->stok);echo json_encode($value) ?></div>
                            <?php else:  ?>
                                <a class="btn btn-default" href="<?php echo base_url('persediaan/edit/'.$value->id).get_query_string(); ?>"><i class="fa fa-edit"></i></a>
                                <button class="btn btn-default" type="button" name="button" data-url="<?php echo base_url('persediaan/delete/'.$value->id).get_query_string(); ?>" onclick="return deleteData(this)"><i class="fa fa-trash"></i></button>
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
