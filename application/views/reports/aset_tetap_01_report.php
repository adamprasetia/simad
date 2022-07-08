<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIB A Report</title>
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
            <th style="border:0px !important;">KARTU INVENTARIS BARANG</th>
        </tr>
        <tr>
            <th style="border:0px !important;">A.TANAH</th>
        </tr>
        <tr>
            <td style="border:0px !important;">No. Kode Lokasi : <?php echo $lokasi ?></td>
        </tr>
    </table>
    <table>
        <thead style="background:#eee">
            <tr>
                <th rowspan=3>No</th>
                <th rowspan=3>Jenis Barang/Nama Barang</th>
                <th colspan=2>Nomor</th>
                <th rowspan=3>Luas</th>
                <th rowspan=3>Tahun Pengadaan</th>
                <th rowspan=3>Letak/Alamat</th>
                <th colspan=3>Status Tanah</th>
                <th rowspan=3>Penggunaan</th>
                <th rowspan=3>Asal Usul</th>
                <th rowspan=3>Harga (Ribuan Rp)</th>
                <th rowspan=3>Keterangan</th>
            </tr>
            <tr>
                <th rowspan=2>Kode Barang</th>
                <th rowspan=2>Register</th>
                <th rowspan=2>Hak</th>
                <th colspan=2>Sertifikat</th>
            </tr>
            <tr>
                <th>Tanggal</th>
                <th>Nomor</th>
            </tr>
            <tr>
                <?php for ($i=1; $i <=14 ; $i++) { ?> 
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
                <td style="text-align:left"><?php echo $value->nama_barang; ?></td>
                <td><?php echo $value->kode_barang; ?></td>
                <td><?php echo $info_lain->noreg_01; ?></td>
                <td><?php echo $info_lain->luas_01; ?> m2</td>
                <td><?php echo $value->tahun; ?></td>
                <td style="text-align:left"><?php echo $info_lain->alamat_01; ?></td>
                <td><?php echo $info_lain->hak_01; ?></td>
                <td><?php echo $info_lain->tglser_01; ?></td>
                <td><?php echo $info_lain->noser_01; ?></td>
                <td style="text-align:left"><?php echo $info_lain->penggu_01; ?></td>
                <td style="text-align:left"><?php echo $info_lain->asal_01; ?></td>
                <td style="text-align:right"><?php echo number_format($value->nilai); ?></td>
                <td style="text-align:left"><?php echo $value->info; ?></td>
            </tr>
                <?php $no++; } ?>
        </tbody>
    </table>
</body>
</html>
