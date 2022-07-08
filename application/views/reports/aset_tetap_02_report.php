<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIB B Report</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/').'css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/').'css/AdminLTE.min.css'; ?>">
    <style>
        table {
            font-size : 12px;
            width:100%;
        }
        table th, table td {
            padding:3px;
            border:1px solid black;
            text-align: center; 
            vertical-align: middle !important;
        }
    </style>
</head>
<body>
    <table style="border:0px !important;">
        <tr>
            <th style="font-size:14px;border:0px !important;">KARTU INVENTARIS BARANG</th>
        </tr>
        <tr>
            <th style="font-size:14px;border:0px !important;">B. PERALATAN & MESIN</th>
        </tr>
        <tr>
            <td style="border:0px !important;">No. Kode Lokasi : <?php echo $lokasi ?></td>
        </tr>
    </table>
    <table>
        <thead style="background:#eee">
            <tr>
                <th rowspan=2>No</th>
                <th rowspan=2>Kode Barang</th>
                <th rowspan=2>Jenis Barang/Nama Barang</th>
                <th rowspan=2>Nomor Register</th>
                <th rowspan=2>Merk/Type</th>
                <th rowspan=2>Ukuran/CC</th>
                <th rowspan=2>Bahan</th>
                <th rowspan=2>Tahun Pembelian</th>
                <th colspan=5>Nomor</th>
                <th rowspan=2>Asal Usul Perolehan</th>
                <th rowspan=2>Harga (Rp)</th>
                <th rowspan=2>Keterangan</th>
            </tr>
            <tr>
                <th>Pabrik</th>
                <th>Rangka</th>
                <th>Mesin</th>
                <th>Polisi</th>
                <th>BPKB</th>
            </tr>
            <tr>
                <?php for ($i=1; $i <=16 ; $i++) { ?> 
                    <th><?php echo $i ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
                <?php
                    $no=1;
                    foreach ($data as $key => $value){
                        $info_lain = json_decode($value->info_lain);
                ?>
            <tr>
                <td style="text-align:center"><?php echo $no; ?></td>
                <td><?php echo $value->kode_barang; ?></td>
                <td style="text-align:left"><?php echo $value->nama_barang; ?></td>
                <td><?php echo $info_lain->noreg_02; ?></td>
                <td><?php echo $info_lain->merk_02; ?></td>
                <td><?php echo $info_lain->ukuran_02; ?></td>
                <td><?php echo $info_lain->bahan_02; ?></td>
                <td><?php echo $value->tahun; ?></td>
                <td><?php echo $info_lain->nopab_02; ?></td>
                <td><?php echo $info_lain->norang_02; ?></td>
                <td><?php echo $info_lain->nomes_02; ?></td>
                <td><?php echo $info_lain->nopol_02; ?></td>
                <td><?php echo $info_lain->nobpkb_02; ?></td>
                <td style="text-align:left"><?php echo $info_lain->asal_02; ?></td>
                <td style="text-align:right"><?php echo number_format($value->nilai); ?></td>
                <td style="text-align:left"><?php echo $value->info; ?></td>
            </tr>
                <?php $no++; } ?>
        </tbody>
    </table>
    <table style="margin-top:10px;border:0px !important;">
        <tr>
            <td colspan="3" style="border:0px !important;"><?php echo $this->input->get('tanggal') ?></td>
        </tr>
        <tr>
            <td style="text-align:left;border:0px !important;"></td>
            <td style="border:0px !important;">Pengguna Barang</td>
            <td style="border:0px !important;">Pengurus Barang</td>
        </tr>
        <tr>
            <td style="padding-top:100px;text-align:left;border:0px !important;"></td>
            <td style="border:0px !important;"><strong>(<?php echo $this->input->get('pengguna_barang') ?>)</strong></td>
            <td style="border:0px !important;"><strong>(<?php echo $this->input->get('pengurus_barang') ?>)</strong></td>
        </tr>
    </table>

</body>
</html>
