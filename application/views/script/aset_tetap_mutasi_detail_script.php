<script>
$('#kib').focus();
$('.btn-pilih-barang-baru').click(function(){
    $('#general-modal-title').html('Pilih Barang Baru');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('barang?popup=1') ?>&kib='+$('#kib_baru').val());
    $('#general-modal').modal('show');
})
$('.btn-pilih-barang').click(function(){
    $('#general-modal-title').html('Pilih Barang');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('barang?popup=1') ?>&kib='+$('#kib').val());
    $('#general-modal').modal('show');
})
$('.btn-pilih-kode-unik').click(function(){
    $('#general-modal-title').html('Pilih Kode Unik');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('aset_tetap_detail?popup=1') ?>&kib='+$('#kib').val()+'&kode_barang='+$('#kode_barang').val()+'&tahun='+$('#tahun').val());
    $('#general-modal').modal('show');
})
$('.btn-pilih-skpd').click(function(){
    $('#general-modal-title').html('Pilih SKPD');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('skpd?popup=1') ?>')
    $('#general-modal').modal('show');
})

$("#general-modal-iframe").on('load',function () {
$(this).contents().find('.btn-choose-barang').click(function () {
    var id = $(this).attr('data-id');
    var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
    data = JSON.parse(data);
    if($('#general-modal-title').html() == 'Pilih Barang'){
        $('#kode_barang').val(data.kode);
        $('#nama_barang').val(data.nama);
    }else{
        $('#kode_barang_baru').val(data.kode);
        $('#nama_barang_baru').val(data.nama);
    }
    $('#general-modal').modal('hide');
});
$(this).contents().find('.btn-choose-skpd').click(function () {
    var id = $(this).attr('data-id');
    var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
    data = JSON.parse(data);
    $('#kode_skpd_baru').val(data.kode);
    $('#general-modal').modal('hide');
});
$(this).contents().find('.btn-choose-aset-tetap-detail').click(function () {
    var id = $(this).attr('data-id');
    var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
    data = JSON.parse(data);
    $('#id_aset_tetap_detail').val(data.id);
    $('#kode_unik').val(data.kode_unik);
    $('#nomor').val(data.nomor);
    $('#kode_barang').val(data.kode_barang);
    $('#nama_barang').val(data.nama_barang);
    $('#general-modal').modal('hide');
});
});

</script>
