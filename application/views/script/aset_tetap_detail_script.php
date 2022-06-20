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
</script>
