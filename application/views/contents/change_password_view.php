<form id="form_data" method="post">
    <div class="box box-default">
        <div class="box-header">
            <h4><strong>Ganti Password</strong></h4>
        </div>
        <div class="box-body">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $this->session_login['id'] ?>">
                <label>Nama Lengkap</label>
                <input autocomplete="off" type="text"
                    class="form-control" value="<?php echo $this->session_login['fullname'] ?>" readonly>
            </div>
            <div class="form-group">
                <label>Password Lama *</label>
                <input type="password" name="oldpass" id="oldpass" class="form-control">
            </div>
            <div class="form-group">
                <label>Password Baru*</label>
                <input type="password" name="newpass" id="newpass" class="form-control">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru *</label>
                <input type="password" name="passconf" id="passconf" class="form-control">
            </div>
        </div>
        <div class="box-footer">
            <button type="button" name="button" class="btn btn-danger btn_action" data-idle="<i class='fa fa-save'></i> Update"
                data-form="#form_data" data-formid="#input_id" data-process="Updating..."
                data-action="<?php echo base_url('user/change_password') ?>"
                data-redirect="<?php echo base_url('user/change_password') ?>"><i class='fa fa-save'></i> Ganti Sekarang</button>
            <button type="button" name="button" class="btn btn-default btn_action"
                data-redirect="<?php echo base_url() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </div>
</form>