<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIB Report</title>
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
            <th style="font-size:14px;border:0px !important;">Rekap KIB</th>
        </tr>
    </table>
    <table>
        <thead style="background:#eee">
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama OPD</th>
                <th>KIB A</th>
                <th>KIB B</th>
                <th>KIB C</th>
                <th>KIB D</th>
                <th>KIB E</th>
                <th>KIB F</th>
                <th>Total KIB</th>
            </tr>
        </thead>
        <tbody>
                <?php
                    $no=1;
                    $total_a=0;
                    $total_b=0;
                    $total_c=0;
                    $total_d=0;
                    $total_e=0;
                    $total_f=0;
                    $total_all=0;
                    foreach ($data as $key => $value){
                        $total_all += $value->total_all;
                        $total_a += $value->total_a;
                        $total_b += $value->total_b;
                        $total_c += $value->total_c;
                        $total_d += $value->total_d;
                        $total_e += $value->total_e;
                        $total_f += $value->total_f;
                ?>
            <tr>
                <td style="text-align:center"><?php echo $no; ?></td>
                <td style="text-align:left"><?php echo $value->kode_skpd; ?></td>
                <td style="text-align:left"><?php echo $value->nama_skpd; ?></td>
                <td style="text-align:right"><a target="_blank" href="<?php echo base_url('aset_tetap_report/show').get_query_string().'&kib=01&kode_skpd='.$value->kode_skpd ?>"><?php echo number_format($value->total_a); ?></a></td>
                <td style="text-align:right"><a target="_blank" href="<?php echo base_url('aset_tetap_report/show').get_query_string().'&kib=02&kode_skpd='.$value->kode_skpd ?>"><?php echo number_format($value->total_b); ?></a></td>
                <td style="text-align:right"><a target="_blank" href="<?php echo base_url('aset_tetap_report/show').get_query_string().'&kib=03&kode_skpd='.$value->kode_skpd ?>"><?php echo number_format($value->total_c); ?></a></td>
                <td style="text-align:right"><a target="_blank" href="<?php echo base_url('aset_tetap_report/show').get_query_string().'&kib=04&kode_skpd='.$value->kode_skpd ?>"><?php echo number_format($value->total_d); ?></a></td>
                <td style="text-align:right"><a target="_blank" href="<?php echo base_url('aset_tetap_report/show').get_query_string().'&kib=05&kode_skpd='.$value->kode_skpd ?>"><?php echo number_format($value->total_e); ?></a></td>
                <td style="text-align:right"><a target="_blank" href="<?php echo base_url('aset_tetap_report/show').get_query_string().'&kib=06&kode_skpd='.$value->kode_skpd ?>"><?php echo number_format($value->total_f); ?></a></td>
                <td style="text-align:right"><strong><?php echo number_format($value->total_all); ?></strong></td>
            </tr>
                <?php $no++; } ?>
                <tr>
                    <td colspan="3" style="text-align:right"><strong>Total</strong></td>
                    <td style="text-align:right"><strong><?php echo number_format($total_a); ?></strong></td>
                    <td style="text-align:right"><strong><?php echo number_format($total_b); ?></strong></td>
                    <td style="text-align:right"><strong><?php echo number_format($total_c); ?></strong></td>
                    <td style="text-align:right"><strong><?php echo number_format($total_d); ?></strong></td>
                    <td style="text-align:right"><strong><?php echo number_format($total_e); ?></strong></td>
                    <td style="text-align:right"><strong><?php echo number_format($total_f); ?></strong></td>
                    <td style="text-align:right"><strong><?php echo number_format($total_all); ?></strong></td>
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
