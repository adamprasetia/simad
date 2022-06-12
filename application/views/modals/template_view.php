<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard - Kompas Gramedia CMS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo config_item('assets_editor').'css/bootstrap.min.css'; ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="<?php echo config_item('assets_editor').'css/font-awesome/css/font-awesome.min.css?v=2'; ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo config_item('assets_editor').'css/Ionicons/css/ionicons.min.css'; ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo config_item('assets_editor').'css/select2.min.css'?>">
    <link rel="stylesheet" href="<?php echo config_item('assets_editor').'css/AdminLTE.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo config_item('assets_editor').'css/skins/skin-blue.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo config_item('assets_editor').'plugins/sweetalert/css/sweetalert.css'; ?>">
    <?php echo isset($css)?$css:'' ?>
    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <?php echo isset($content)?$content:'' ?>
    <script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
    var base_domain = "<?php echo config_item('base_domain') ?>";
    </script>
    <!-- jQuery 3 -->
    <script src="<?php echo config_item('assets_editor').'js/jquery.min.js';?>"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo config_item('assets_editor').'js/bootstrap.min.js';?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo config_item('assets_editor').'js/adminlte.min.js';?>"></script>
    <!-- SweetAlert -->
    <script src="<?php echo config_item('assets_editor').'plugins/sweetalert/js/sweetalert.min.js';?>"></script>
    <script src="<?php echo config_item('assets_editor').'js/select2.min.js';?>"></script>
    <!-- custom js general -->
    <script src="<?php echo config_item('assets_editor').'script/general.js?v=2';?>"></script>
    <!-- custom js general -->
    <?php echo isset($script)?$script:'' ?>

    <!-- Modal -->
    <div class="modal fade" id="general-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 id="general-modal-title" class="modal-title">Default Modal</h4>
                </div>
                <div class="modal-body">
                    <iframe id="general-modal-iframe" frameBorder="0" width="100%" height="480px"></iframe>
                </div>
            </div>
        </div>
    </div>

</body>

</html>