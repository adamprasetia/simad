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
</script>
