<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyusutan Report</title>
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
            <th style="font-size:14px;border:0px !important;">Rekapitulasi Penyusutan</th>
        </tr>
        <tr>
            <th style="font-size:14px;border:0px !important;"><?php echo config_item('kib')[$kib]['name'] ?></th>
        </tr>
        <tr>
            <td style="border:0px !important;">No. Kode Lokasi : <?php echo $lokasi ?></td>
        </tr>
    </table>
    <table>
        <thead style="background:#eee">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Tahun Perolehan</th>
                <th>Nilai Perolehan</th>
                <th>Umur (Tahun)</th>
                <th>Akm Penyusutan Lalu</th>
                <th>Penyusutan Ini</th>
                <th>Akm Penyusutan Ini</th>
                <th>Nilai Buku</th>
            </tr>
        </thead>
        <tbody>
                <?php
                    $no=1;
                    foreach ($data as $key => $value){
                        $selisih = (date('Y')-$value->tahun);
                        $penyusutan = $value->umur!=0?$value->nilai/$value->umur:$value->nilai;
                        $akm_penyusutan_lalu = $penyusutan*$selisih;
                        $penyusutan_ini = $value->umur!=0?$penyusutan:0;
                        $akm_penyusutan_ini = $akm_penyusutan_lalu+$penyusutan_ini;
                        $nilai_buku = $value->nilai-$akm_penyusutan_ini;
                ?>
            <tr>
                <td style="text-align:center"><?php echo $no; ?></td>
                <td style="text-align:left"><?php echo $value->kode_barang; ?></td>
                <td style="text-align:left"><?php echo $value->nama_barang; ?></td>
                <td><?php echo $value->tahun; ?></td>
                <td style="text-align:right"><?php echo number_format($value->nilai); ?></td>
                <td style="text-align:right"><?php echo number_format($value->umur); ?></td>
                <td style="text-align:right"><?php echo number_format($akm_penyusutan_lalu); ?></td>
                <td style="text-align:right"><?php echo number_format($penyusutan_ini); ?></td>
                <td style="text-align:right"><?php echo number_format($akm_penyusutan_ini); ?></td>
                <td style="text-align:right"><?php echo number_format($nilai_buku); ?></td>
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
