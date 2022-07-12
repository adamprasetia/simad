<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIB F Report</title>
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
            <th style="font-size:14px;border:0px !important;">F. KONSTRUKSI DALAM PENGERJAAN</th>
        </tr>
        <tr>
            <td style="border:0px !important;">No. Kode Lokasi : <?php echo $lokasi ?></td>
        </tr>
    </table>
    <table>
        <thead style="background:#eee">
            <tr>
                <th rowspan=2>No</th>
                <th rowspan=2>Jenis Barang/Nama Barang</th>
                <th colspan=2>Dokumen</th>
                <th rowspan=2>Bangunan (P,S,M,D)</th>
                <th colspan=2>Konstruksi Bangunan</th>
                <th rowspan=2>Luas (M2)</th>
                <th rowspan=2>Letak/Lokasi Alamat</th>
                <th rowspan=2>Tgl,Bln,Thn Mulai</th>
                <th rowspan=2>Status Tanah</th>
                <th rowspan=2>Nomor Kode Tanah</th>
                <th rowspan=2>Asal-usul Pembiyaan</th>
                <th rowspan=2>Nilai Kontrak (Ribuan Rp)</th>
                <th rowspan=2>Ket</th>
            </tr>
            <tr>
                <th>Kode Barang</th>
                <th>Register</th>
                <th>Bertingkat/Tidak</th>
                <th>Beton/Tidak</th>
            </tr>
            <tr>
                <?php for ($i=1; $i <=15 ; $i++) { ?> 
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
