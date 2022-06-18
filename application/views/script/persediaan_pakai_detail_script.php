<script>
$('#kib').focus();
$('#kode_barang').select2({
    ajax: {
        url: '<?php echo base_url('barang_persediaan/api') ?>',
        dataType: 'json',
        data: function (params) {
        var query = {
            search: params.term,
            kib:$('#kib').val()
        }

        // Query parameters will be ?search=[term]&type=public
        return query;
        }
    }
});
$('#kode_barang').change(function(){
    $('#nama_barang').val($('#kode_barang option:selected').text().split(' | ')[1]);
})
$('#id_persediaan_detail').select2({
    ajax: {
        url: '<?php echo base_url('persediaan_detail/api') ?>',
        dataType: 'json',
        data: function (params) {
        var query = {
            search: params.term,
            metode:$('#metode').val(),
            kode_barang:$('#kode_barang').val(),
            tahun:$('#tahun').val()
        }

        // Query parameters will be ?search=[term]&type=public
        return query;
        }
    }
});
$('#id_persediaan_detail').change(function(){
    $('#nomor').val($('#id_persediaan_detail option:selected').text().split(' | ')[0]);
    $('#info').val($('#id_persediaan_detail option:selected').text().split(' | ')[1]);
})

</script>
