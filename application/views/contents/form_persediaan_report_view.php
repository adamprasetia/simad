<div class="box box-default">
    <form id="form_data" target="_blank" method="get" action="<?php echo $action ?>">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong><?php echo strtoupper($this->title) ?></strong></h4>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <td colspan=2><i>Detail Laporan</i></td>
                </tr>
                <tr>
                    <td><label>Tanggal Cetak</label></td>
                    <td>
                        <input type="text" id="tanggal" name="tanggal" class="form-control" value="<?php echo isset($data->tanggal)?format_dmy($data->tanggal):'' ?>">
                    </td>
                </tr>
                <tr>
                    <td><label>Pengguna Barang</label></td>
                    <td>
                        <div class="input-group">
                            <input type="text" id="pengguna_barang" name="pengguna_barang" class="form-control" value="<?php echo isset($data->pengguna_barang)?$data->pengguna_barang:'' ?>">
                            <span class="input-group-btn">
                                <button type="button" data-title="Pilih Kode SKPD" class="btn btn-success btn-flat btn-pilih-pengguna">Pilih</button>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label>Pengurus Barang</label></td>
                    <td>
                        <div class="input-group">
                            <input type="text" id="pengurus_barang" name="pengurus_barang" class="form-control" value="<?php echo isset($data->pengurus_barang)?$data->pengurus_barang:'' ?>">
                            <span class="input-group-btn">
                                <button type="button" data-title="Pilih Kode SKPD" class="btn btn-success btn-flat btn-pilih-pengurus">Pilih</button>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label>Format</label></td>
                    <td>
                        <select name="format" id="format" class="form-control">
                            <option value="html">HTML</option>
                            <option value="excel">EXCEL</option>
                            <option value="doc">DOC</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box-footer">
            <button type="submit" onclick="submit()" class="btn btn-primary"><i class='fa fa-print'></i> Cetak</button>
        </div>
    </form>
</div>