<script>
$('#kib').focus();
$('.btn-pilih-persediaan').click(function(){
    $('#general-modal-title').html('Pilih Barang');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('persediaan?popup=1') ?>');
    $('#general-modal').modal('show');
})
$("#general-modal-iframe").on('load',function () {
    $(this).contents().find('.btn-choose-persediaan').click(function () {
        var id = $(this).attr('data-id');
        var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
        data = JSON.parse(data);
        console.log(data)
        $('#kode_barang').val(data.kode_barang);
        $('#nama_barang').val(data.nama_barang);
        $('#satuan').val(data.satuan);
        $('#jumlah_tersedia').val(data.stok);
        $('#general-modal').modal('hide');
    });
});
$("#jumlah, #jumlah_tersedia").on('change keyup',function () {
    var jumlah_tersedia = parseInt($('#jumlah_tersedia').val().replace(/,/g, ''))
    var jumlah_dipakai = parseInt($(this).val().replace(/,/g, ''))
    if(jumlah_dipakai > jumlah_tersedia){
        $(this).val(jumlah_tersedia)
        $('.input-uang').priceFormat({
            prefix: '',
            thousandsSeparator: ',',
            centsLimit: 0
        });
    }
})
</script>
