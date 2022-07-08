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