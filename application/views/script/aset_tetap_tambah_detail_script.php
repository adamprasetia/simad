<script>
$('#kib').focus();
$('.btn-pilih-barang').click(function(){
    $('#general-modal-title').html('Pilih Barang');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('barang?popup=1') ?>&kib='+$('#kib').val());
    $('#general-modal').modal('show');
})
$('.btn-pilih-aset-tetap-detail').click(function(){
    $('#general-modal-title').html('Pilih Nomor Perolehan');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('aset_tetap_detail?popup=1') ?>&kib='+$('#kib').val()+'&kode_barang='+$('#kode_barang').val()+'&tahun='+$('#tahun').val());
    $('#general-modal').modal('show');
})

$("#general-modal-iframe").on('load',function () {
    $(this).contents().find('.btn-choose-barang').click(function () {
        var id = $(this).attr('data-id');
        var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
        data = JSON.parse(data);
        $('#kode_barang').val(data.kode);
        $('#nama_barang').val(data.nama);
        $('#general-modal').modal('hide');
    });
    $(this).contents().find('.btn-choose-aset-tetap-detail').click(function () {
        var id = $(this).attr('data-id');
        var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
        data = JSON.parse(data);
        $('#id_aset_tetap_detail').val(data.id);
        $('#kode_barang').val(data.kode_barang);
        $('#nama_barang').val(data.nama_barang);
        $('#kode_unik').val(data.kode_unik);
        $('#nomor').val(data.nomor);
        $('#info').val(data.info);
        $('#general-modal').modal('hide');
    });

});

</script>
