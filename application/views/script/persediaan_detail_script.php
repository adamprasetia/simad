<script>
$('#kib').focus();

$('.btn-pilih-barang-persediaan').click(function(){
    $('#general-modal-title').html('Pilih Barang');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('barang_persediaan?popup=1') ?>');
    $('#general-modal').modal('show');
})

$("#general-modal-iframe").on('load',function () {
    $(this).contents().find('.btn-choose-barang-persediaan').click(function () {
        var id = $(this).attr('data-id');
        var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
        data = JSON.parse(data);
        $('#kode_barang').val(data.kode);
        $('#nama_barang').val(data.nama);
        $('#satuan').val(data.satuan);
        $('#nilai').val(data.nilai);
        $('#general-modal').modal('hide');
    });
});
total();
$('#jumlah, #nilai').on('change keyup', function(){
    total();
})
function total(){
    var jumlah = parseInt($('#jumlah').val().replace(/,/g, ''));
    var nilai = parseFloat($('#nilai').val().replace(/,/g, ''));
    $('#total').val(jumlah*nilai);
    $('.input-uang').priceFormat({
        prefix: '',
        thousandsSeparator: ',',
        centsLimit: 0
    });
}

</script>
