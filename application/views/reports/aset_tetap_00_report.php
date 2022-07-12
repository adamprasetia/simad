<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIB Z Report</title>
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
            <th style="font-size:14px;border:0px !important;">Z. ASET TAK BERWUJUD</th>
        </tr>
        <tr>
            <td style="border:0px !important;">No. Kode Lokasi : <?php echo $lokasi ?></td>
        </tr>
    </table>
    <table>
        <thead style="background:#eee">
            <tr>
                <th>No</th>
                <th>Jenis Barang/Nama Barang</th>
                <th>Kode Barang</th>
                <th>No Register</th>
                <th>Tgl,Bln,Thn Perolehan</th>
                <th>Asal-usul Pembiyaan</th>
                <th>Nilai Perolehan (Rp)</th>
                <th>Ket</th>
            </tr>
            <tr>
                <?php for ($i=1; $i <=8 ; $i++) { ?> 
                    <th><?php echo $i ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
                <?php
                    $no=1;
                    $total=0;
                    foreach ($data as $key => $value){
                        $total += $value->nilai;
                        $info_lain = json_decode($value->info_lain);
                ?>
            <tr>
                <td style="text-align:center"><?php echo $no; ?></td>
                <td style="text-align:left"><?php echo $value->nama_barang; ?></td>
                <td><?php echo $value->kode_barang; ?></td>
                <?php foreach ($info_lain as $info_lain_row) { ?>
                    <td><?php echo $info_lain_row; ?></td>    
                <?php } ?>
                <td style="text-align:right"><?php echo number_format($value->nilai); ?></td>
                <td style="text-align:left"><?php echo $value->info; ?></td>
            </tr>
                <?php $no++; } ?>
                <tr>
                    <td colspan="<?php echo $i-3 ?>" style="text-align:right"><strong>Total</strong></td>
                    <td style="text-align:right"><strong><?php echo number_format($total); ?></strong></td>
                    <td></td>
                </tr>
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
