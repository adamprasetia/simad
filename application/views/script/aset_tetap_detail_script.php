<script>
$('#kib').focus();
kib($('#kib').val());
$('#kib').change(function(){
    kib($(this).val());
})
function kib(val){
    console.log(val);
    var kib = ['00','01','02','03','04','05','06']
    kib.forEach(function(v){
        if(val==v){
            $('.kib-'+v).show();
        }else{
            $('.kib-'+v).hide();
        }
    });
}
$('.btn-pilih-barang').click(function(){
    $('#general-modal-title').html('Pilih Barang');
    $('#general-modal-iframe').attr('src', '<?php echo base_url('barang?popup=1') ?>&kib='+$('#kib').val());
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
});

</script>
