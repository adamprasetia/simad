<script>
// Method or Function
function updateButton(t, status) {
  if (!status) {
    $(t).html($(t).attr('data-idle'));
    $(t).prop('disabled', false);
    $('.overlay').remove();
  } else {
    $(t).html($(t).attr('data-process'));
    $(t).prop('disabled', true);
    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
  }
}

function htmlEntities(str) {
  return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
// Event Listener
$('form').submit(function (e) {
  e.preventDefault();
});

$(document).on('click', '.btn_action', function () {
  var form = $(this).attr('data-form');
  var action = $(this).attr('data-action');
  var redirect = $(this).attr('data-redirect');
  var t = $(this);
  if (action) {

    $.ajax({
      url: action,
      method: 'post',
      data: new FormData($(form)[0]),
      processData: false,
      contentType: false,
      // dataType: 'json',
      beforeSend: function () {
        updateButton(t, true);
      },
      success: function (str) {
        var obj = jQuery.parseJSON(str);

        var tipe = 'success';
        var title = 'Success!';
        var message = 'Data berhasil disimpan';

        if (obj.tipe != undefined) {
            tipe = obj.tipe;
        }

        if (obj.title != undefined) {
            title = obj.title;
        }

        if (obj.message != undefined) {
            message = obj.message;
        }

        if (obj.redirect != undefined) {
            redirect = obj.redirect;
        }

        swal({
            title: title,
            type: tipe,
            text: message,
            timer: 2000,
            showConfirmButton: false
        });

        if (obj.tipe == undefined && obj.tipe != 'error') {

          if (redirect) {
            setTimeout(function () {
              window.location = redirect;
            }, 2000);
          }

        }

        updateButton(t, false);
      },
      error: function (xhr, textStatus, errorThrown) {
        sweetAlert("Oops...", "Terjadi Kesalahan!", "error");
        updateButton(t, false);
      }
    });

  } else {
    if (redirect) {
      window.location = redirect;
    }
  }
});

function deleteData(t) {
  swal({
    title: "Kamu yakin ?",
    text: "Kamu mungkin tidak bisa mengembalikan data yang sudah dihapus!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Hapus sekarang!",
    closeOnConfirm: false
  },
    function () {
      $.ajax({
        url: $(t).attr("data-url"),
        type: 'POST',
        dataType: 'json',
        success: function (data) {
          swal({
              title: 'Deleted!',
              type: 'success',
              text: 'Data berhasil dihapus',
              timer: 2000,
              showConfirmButton: false
          });

          setTimeout(function () {
            location.reload();
          }, 2000);
        },
        error: function (xhr, textStatus, errorThrown) {
          sweetAlert("Oops...", "Terjadi Kesalahan!", "error");
          // setTimeout(function() {
          //   location.reload();
          // }, 2000);
        }
      });
    });
};

function restoreData(t) {
  swal({
    title: "Are you sure?",
    text: "You can recover this data!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, restore it!",
    closeOnConfirm: false
  },
    function () {
      $.ajax({
        url: $(t).attr("data-url"),
        type: 'POST',
        dataType: 'json',
        success: function (data) {
          swal("Restored!", "Your data has been restored.", "success");
          setTimeout(function () {
            location.reload();
          }, 2000);
        },
        error: function (xhr, textStatus, errorThrown) {
          sweetAlert("Oops...", "Something went wrong!", "error");
          // setTimeout(function() {
          //   location.reload();
          // }, 2000);
        }
      });
    });
};

$('body').on('click', '.btn-dialog', function () {
  var title = $(this).attr('data-title');
  var src = $(this).attr('data-url');
  $('#general-modal-title').html(title);
  $('#general-modal-iframe').attr('src', src);
  $('#general-modal').modal('show');
});

$(document).on('keypress', '#input_search', function (e) {
  if (e.which == 13) {
    var url = $(this).attr('data-url');
    var queryString = $(this).attr('data-query-string');
    if (queryString) {
      url += queryString + '&search=' + $(this).val();
    } else {
      url += '?search=' + $(this).val();
    }
    window.location = url;
    return false;
  }
});

$(document).on('click', '.btn_close', function () {
  var t = $(this);
  var redirect = $(t).attr('data-redirect');

  swal({
    title: "Kamu yakin ?",
    text: "Kamu mungkin memiliki perubahan yang belum disimpan yang akan hilang!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Tidak masalah!",
    closeOnConfirm: false
  }, function () {
    window.location = redirect;
  });
});

function changeStatus(t) {
  var st = $(t).attr('data-status') == 2 ? 'PUBLISH' : 'DRAFT';
  swal({
    title: 'Change to ' + st + '?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes',
    closeOnConfirm: false
  },
    function () {
      $.ajax({
        url: $(t).attr('data-url'),
        type: 'POST',
        dataType: 'json',
        success: function (data) {
          swal('Success!', '', 'success');
          location.reload();
        },
        error: function (xhr, textStatus, errorThrown) {
          sweetAlert('Oops...', 'Something went wrong!', 'error');
        }
      });
    });
};

$('.datetimepicker').datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true
  });

  $('.input-uang').priceFormat({
		prefix: '',
		thousandsSeparator: ',',
		centsLimit: 0
	});
//   $('.btn-pilih-barang').click(function(){
//     $('#general-modal-title').html('Pilih Barang');
//     $('#general-modal-iframe').attr('src', '<?php echo base_url('barang?popup=1') ?>&kib='+$('#kib').val());
//     $('#general-modal').modal('show');
//   })
//   $('.btn-pilih-barang-persediaan').click(function(){
//     $('#general-modal-title').html('Pilih Barang');
//     $('#general-modal-iframe').attr('src', '<?php echo base_url('barang_persediaan?popup=1') ?>');
//     $('#general-modal').modal('show');
//   })
//   $('.btn-pilih-nomor').click(function(){
//       $('#general-modal-title').html('Pilih Nomor Perolehan');
//       $('#general-modal-iframe').attr('src', '<?php echo base_url('aset_tetap_detail?popup=1') ?>&kib='+$('#kib').val()+'&kode_barang='+$('#kode_barang').val()+'&tahun='+$('#tahun').val());
//       $('#general-modal').modal('show');
//   })
//   $('.btn-pilih-nomor-persediaan').click(function(){
//       $('#general-modal-title').html('Pilih Nomor Perolehan');
//       $('#general-modal-iframe').attr('src', '<?php echo base_url('persediaan_detail?popup=1') ?>&metode='+$('#metode').val()+'&kode_barang='+$('#kode_barang').val()+'&tahun='+$('#tahun').val());
//       $('#general-modal').modal('show');
//   })

//   $("#general-modal-iframe").on('load',function () {
//     $(this).contents().find('.btn-choose-barang').click(function () {
//         var id = $(this).attr('data-id');
//         var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
//         data = JSON.parse(data);
//         $('#kode_barang').val(data.kode);
//         $('#nama_barang').val(data.nama);
//         $('#general-modal').modal('hide');
//     });
//     $(this).contents().find('.btn-choose-barang-persediaan').click(function () {
//         var id = $(this).attr('data-id');
//         var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
//         data = JSON.parse(data);
//         $('#kode_barang').val(data.kode);
//         $('#nama_barang').val(data.nama);
//         $('#general-modal').modal('hide');
//     });
//     $(this).contents().find('.btn-choose-nomor').click(function () {
//         var id = $(this).attr('data-id');
//         var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
//         data = JSON.parse(data);
//         $('#id_aset_tetap_detail').val(data.id);
//         $('#kode_unik').val(data.kode_unik);
//         $('#nomor').val(data.nomor);
//         $('#info').val(data.info);
//         $('#general-modal').modal('hide');
//     });
//     $(this).contents().find('.btn-choose-nomor-persediaan').click(function () {
//         var id = $(this).attr('data-id');
//         var data = $("#general-modal-iframe").contents().find('#data-'+id).html();
//         data = JSON.parse(data);
//         $('#id_persediaan_detail').val(data.id);
//         $('#nomor').val(data.nomor);
//         $('#info').val(data.info);
//         $('#general-modal').modal('hide');
//     });
// });

</script>