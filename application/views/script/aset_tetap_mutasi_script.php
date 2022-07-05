<script>
$('#kib').focus();
$('.btn-pilih-barang-baru').click(function(){
    $('#general-modal-title').html('Pilih Barang Baru');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('barang?popup=1') ?>');
    $('#general-modal').modal('show');
})
$('.btn-pilih-aset-tetap').click(function(){
    $('#general-modal-title').html('Pilih Barang');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('aset_tetap?popup=1') ?>&kode_skpd='+$('#kode_skpd_lama').val());
    $('#general-modal').modal('show');
})
$('.btn-pilih-skpd-lama').click(function(){
    $('#general-modal-title').html('Pilih SKPD Lama');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('skpd?popup=1') ?>')
    $('#general-modal').modal('show');
})
$('.btn-pilih-skpd-baru').click(function(){
    $('#general-modal-title').html('Pilih SKPD Baru');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('skpd?popup=1') ?>')
    $('#general-modal').modal('show');
})

$("#general-modal-iframe").on('load',function () {
$(this).contents().find('.btn-choose-barang').click(function () {
    var id = $(this).attr('data-id');
    var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
    data = JSON.parse(data);
    $('#kode_barang_baru').val(data.kode);
    $('#nama_barang_baru').val(data.nama);
    $('#kib_baru').val(data.kib);
    $('#general-modal').modal('hide');
});
$(this).contents().find('.btn-choose-skpd').click(function () {
    var id = $(this).attr('data-id');
    var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
    data = JSON.parse(data);
    if($('#general-modal-title').html() == 'Pilih SKPD Lama'){
        $('#kode_skpd_lama').val(data.kode);
        $('#nama_skpd_lama').val(data.nama);
        $('#kode_barang_lama').val('');
        $('#nama_barang_lama').val('');
        $('#kode_nomor').val('');
        $('#kib_lama').val('');
    }else{
        $('#kode_skpd_baru').val(data.kode);
        $('#nama_skpd_baru').val(data.nama);
    }
    $('#general-modal').modal('hide');
});
$(this).contents().find('.btn-choose-aset-tetap').click(function () {
    var id = $(this).attr('data-id');
    var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
    data = JSON.parse(data);
    $('#id_aset_tetap').val(data.id);
    $('#kode_skpd_lama').val(data.kode_skpd);
    $('#kode_unik').val(data.kode_unik);
    $('#nomor').val(data.nomor);
    $('#kode_barang_lama').val(data.kode_barang);
    $('#nama_barang_lama').val(data.nama_barang);
    $('#kode_barang_baru').val(data.kode_barang);
    $('#nama_barang_baru').val(data.nama_barang);
    $('#kib_lama').val(data.kib);
    $('#kib_baru').val(data.kib);
    $('#general-modal').modal('hide');
});
});

</script>
