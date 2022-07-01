<script>
$('#kib').focus();
$('.btn-pilih-barang-persediaan').click(function(){
    $('#general-modal-title').html('Pilih Barang');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('barang_persediaan?popup=1') ?>');
    $('#general-modal').modal('show');
})
$('.btn-pilih-persediaan-detail').click(function(){
    $('#general-modal-title').html('Pilih Persediaan');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('persediaan_detail?popup=1') ?>&metode='+$('#metode').val()+'&kode_barang='+$('#kode_barang').val()+'&tahun='+$('#tahun').val());
    $('#general-modal').modal('show');
})

$("#general-modal-iframe").on('load',function () {
    $(this).contents().find('.btn-choose-barang-persediaan').click(function () {
        var id = $(this).attr('data-id');
        var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
        data = JSON.parse(data);
        $('#kode_barang').val(data.kode);
        $('#nama_barang').val(data.nama);
        $('#general-modal').modal('hide');
    });
    $(this).contents().find('.btn-choose-persediaan-detail').click(function () {
        var id = $(this).attr('data-id');
        var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
        data = JSON.parse(data);
        console.log(data);
        $('#id_persediaan_detail').val(data.id);
        $('#kode_unik').val(data.kode_unik);
        $('#jumlah_tersedia').val(data.jumlah);
        $('#nomor').val(data.nomor);
        $('#info').val(data.info);
        $('#general-modal').modal('hide');
    });
});

</script>
