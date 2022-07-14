<script>
$('#kib').focus();
$('.btn-pilih-skpd').click(function(){
    $('#general-modal-title').html('Pilih SKPD');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('skpd?popup=1') ?>')
    $('#general-modal').modal('show');
})
$('.btn-pilih-pengguna').click(function(){
    $('#general-modal-title').html('Pilih Pengguna Barang');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('user?popup=1') ?>')
    $('#general-modal').modal('show');
})
$('.btn-pilih-pengurus').click(function(){
    $('#general-modal-title').html('Pilih Pengurus Barang');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('user?popup=1') ?>')
    $('#general-modal').modal('show');
})
$("#general-modal-iframe").on('load',function () {
$(this).contents().find('.btn-choose-skpd').click(function () {
    var id = $(this).attr('data-id');
    var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
    data = JSON.parse(data);
    $('#kode_skpd').val(data.kode);
    $('#nama_skpd').val(data.nama);
    $('#general-modal').modal('hide');
});

$(this).contents().find('.btn-choose-user').click(function () {
    var id = $(this).attr('data-id');
    var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
    data = JSON.parse(data);
    if($('#general-modal-title').html() == 'Pilih Pengguna Barang'){
        $('#pengguna_barang').val(data.fullname);
    }else{
        $('#pengurus_barang').val(data.fullname);
    }
    $('#general-modal').modal('hide');
});
});

</script>
