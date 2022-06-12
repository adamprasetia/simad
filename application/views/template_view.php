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

    <?php echo isset($css)?$css:'' ?>

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="skin-green-light fixed sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="<?php echo base_url(); ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>SIMAD</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>SIMAD</b></span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <!-- hidden-xs hides the email on small devices so only the image appears. -->
                                <span><?php echo get_name_user_login() ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <p>
                                        <?php echo get_name_user_login() ?>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo base_url('user/change_password'); ?>"
                                            class="btn btn-default btn-flat">Ganti Password</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('login/logout'); ?>"
                                            class="btn btn-default btn-flat">Keluar</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MENU UTAMA</li>
                    <!-- Optionally, you can add icons to the links -->
                    <?php $s1 = $this->uri->segment(1); $s2 = $this->uri->segment(2); ?>
                    <?php $modules = $this->db->where_in('id', get_module_user_login())->where('parent', 0)->order_by('order asc')->get('module')->result(); ?>
                    <?php foreach ($modules as $module) { ?>
                        <?php $childs = $this->db->where_in('id', get_module_user_login())->where('parent', $module->id)->order_by('order asc')->get('module')->result(); ?>
                        <?php if(!empty($childs)):?>
                            <li class="<?php echo (!empty($s1) && in_array($s1,array_map('map_menu',$childs))?'active treeview menu-open':'treeview') ?>">
                                <a href="#">
                                    <i class="<?php echo !empty($module->icon)?$module->icon:'fa fa-circle-o' ?>"></i> <span><?php echo $module->name ?></span>
                                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php foreach ($childs as $child) { ?>
                                        <?php $childs2 = $this->db->where_in('id', get_module_user_login())->where('parent', $child->id)->order_by('order asc')->get('module')->result(); ?>                      
                                        <?php if(!empty($childs2)):?>
                                            <li class="<?php echo (!empty($s1) && in_array($s1,array_map('map_menu',$childs2))?'active treeview menu-open':'treeview') ?>">
                                                <a href="#">
                                                    <i class="<?php echo !empty($child->icon)?$child->icon:'fa fa-circle-o' ?>"></i> <span><?php echo $child->name ?></span>
                                                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php foreach ($childs2 as $child2) { ?>
                                                        <li class="<?php echo ($s1 == $child2->link ? 'active' : ''); ?>"><a href="<?php echo base_url($child2->link); ?>"><i class="<?php echo !empty($child2->icon)?$child2->icon:'fa fa-circle-o'?>"></i> <?php echo $child2->name ?></a></li>
                                                    <?php } ?>                                            
                                                </ul>
                                            </li>
                                        <?php else:?>
                                            <li class="<?php echo ($s1 == $child->link ? 'active' : ''); ?>"><a href="<?php echo base_url($child->link); ?>"><i class="<?php echo !empty($child->icon)?$child->icon:'fa fa-circle-o'?>"></i> <?php echo $child->name ?></a></li>
                                        <?php endif?>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="<?php echo ($s1==$module->link?'active':''); ?>"><a href="<?php echo base_url($module->link); ?>"><i class="<?php echo !empty($module->icon)?$module->icon:'fa fa-circle-o' ?>"></i> <span><?php echo $module->name ?></span></a></li>
                        <?php endif ?>
                    <?php } ?>
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 449px;">
            <!-- Main content -->
            <section class="content container-fluid">
                <?php echo isset($content)?$content:''; ?>
            </section>
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                #SIMAD
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; <?php echo date('Y'); ?> Developed by <a href="www.adamprasetia.com">Damz Soft</a>
                </strong> All rights reserved.
        </footer>

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

    </div>
    <!-- ./wrapper -->

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

    <!-- custom js general -->
    <?php $this->load->view('script/general_script') ?>
    <?php echo isset($script)?$script:'' ?>
</body>

</html>