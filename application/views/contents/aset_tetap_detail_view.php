<div class="box box-default">
    <div class="box-header with-border">
        <?php if(empty($this->input->get('popup'))): ?>
        <div class="pull-left">
            <h4><strong>DATA <?php echo strtoupper($this->title) ?></strong></h4>
        </div>
        <?php endif ?>
        <?php if(!empty($this->input->get('id_'.$this->module_parent))): ?>
        <?php $parent = $this->db->where('id', $this->input->get('id_'.$this->module_parent))->get($this->module_parent)->row(); ?>
        <table class="table table-bordered" style="margin-bottom:0px;">
            <tr>
                <td width="50px"><strong>Nomor</strong></td>
                <td>: <?php echo $parent->nomor ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td>: <?php echo format_dmy($parent->tanggal) ?></td>
            </tr>
            <tr>
                <td><strong>Uraian</strong></td>
                <td>: <?php echo $parent->uraian ?></td>
            </tr>
        </table>
        <?php endif ?>
    </div>
    <div class="box-header with-border">
        <?php if(empty($this->input->get('popup'))): ?>
            <a href="<?php echo base_url($this->module.'/add').get_query_string() ?>" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Tambah Detail</a>
            <a href="<?php echo base_url($this->module_parent).get_query_string() ?>" class="btn btn-default btn-sm"><i class="fa fa-close"></i> Kembali</a>
        <?php endif ?>
        <a href="<?php echo now_url() ?>" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
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
                        <?php if(!empty($this->input->get('popup'))): ?>
                            <th>Nomor</th>
                        <?php endif ?>
                        <th>Kode Unik</th>
                        <th>KIB</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
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
                        <?php if(!empty($this->input->get('popup'))): ?>
                            <td><?php echo $value->nomor; ?></td>
                        <?php endif ?>
                        <td><?php echo $value->kode_unik; ?></td>
                        <td><?php echo config_item('kib')[$value->kib]['id']; ?></td>
                        <td><?php echo $value->kode_barang; ?></td>
                        <td><?php echo $value->nama_barang; ?></td>
                        <td><?php echo number_format($value->nilai); ?></td>
                        <td>
                            <?php if(!empty($this->input->get('popup'))): ?>
                                <button class="btn btn-primary btn-choose-nomor" type="button" name="button" data-id="<?php echo $value->id ?>"><i class="fa fa-use"></i> Pilih</button>
                                <div style="display:none" id="data-<?php echo $value->id ?>"><?php echo json_encode($value) ?></div>
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
