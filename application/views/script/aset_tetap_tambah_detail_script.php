<script>
$('#kib').focus();
$('#kode_barang').select2({
    ajax: {
        url: '<?php echo base_url('barang/api') ?>',
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
$('#id_aset_tetap_detail').select2({
    ajax: {
        url: '<?php echo base_url('aset_tetap_detail/api') ?>',
        dataType: 'json',
        data: function (params) {
        var query = {
            search: params.term,
            kib:$('#kib').val(),
            kode_barang:$('#kode_barang').val(),
            tahun:$('#tahun').val()
        }

        // Query parameters will be ?search=[term]&type=public
        return query;
        }
    }
});
$('#id_aset_tetap_detail').change(function(){
    $('#nomor').val($('#id_aset_tetap_detail option:selected').text().split(' | ')[0]);
})

</script>
