<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMBAD</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url('assets/').'css/bootstrap.min.css'; ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="<?php echo base_url('assets/').'css/font-awesome/css/font-awesome.min.css?v=2'; ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/').'css/Ionicons/css/ionicons.min.css'; ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/').'css/select2.min.css'?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/').'css/AdminLTE.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/').'css/skins/skin-green-light.min.css'; ?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/').'plugins/sweetalert/css/sweetalert.css'; ?>">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/').'css/jquery-ui-timepicker-addon.min.css'?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/').'css/general.css'?>">

    <?php echo isset($css)?$css:'' ?>

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="skin-green-light fixed sidebar-mini">
    <?php echo isset($content)?$content:''; ?>

    <script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
    var base_domain = "<?php echo config_item('base_domain') ?>";
    </script>
    <!-- jQuery 3 -->
    <script src="<?php echo base_url('assets/').'js/jquery.min.js';?>"></script>
    <script src="<?php echo base_url('assets/').'js/jquery.slimscroll.min.js';?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/jquery-ui.min.js"></script>
    <script type="text/javascript"
        src="<?php echo base_url('assets/'); ?>js/jquery-ui-timepicker-addon.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url('assets/').'js/bootstrap.min.js';?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('assets/').'js/adminlte.min.js';?>"></script>
    <!-- SweetAlert -->
    <script src="<?php echo base_url('assets/').'plugins/sweetalert/js/sweetalert.min.js';?>"></script>

    <script src="<?php echo base_url('assets/').'js/select2.min.js';?>"></script>
    <script src="<?php echo base_url('assets/').'js/price_format.js';?>"></script>

    <!-- custom js general -->
    <?php $this->load->view('script/general_script') ?>
    <?php echo isset($script)?$script:'' ?>
</body>

</html>