<script>
$('#kode_unik').focus();
$('.btn-pilih-aset-tetap-detail').click(function(){
    $('#general-modal-title').html('Pilih Barang');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('aset_tetap?popup=1') ?>');
    $('#general-modal').modal('show');
})

$("#general-modal-iframe").on('load',function () {
    $(this).contents().find('.btn-choose-aset-tetap').click(function () {
        var id = $(this).attr('data-id');
        var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
        data = JSON.parse(data);
        $('#id_aset_tetap').val(data.id);
        $('#kode_unik').val(data.kode_unik);
        $('#nomor').val(data.nomor);
        $('#kode_barang').val(data.kode_barang);
        $('#nama_barang').val(data.nama_barang);
        $('#kib').val(data.kib);
        $('#info').val(data.info);
        $('#general-modal').modal('hide');
    });

});

</script>
