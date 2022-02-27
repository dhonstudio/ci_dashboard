<div id="layoutSidenav_content">
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Change Your Password</h3></div>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('home/change_password') ?>">
                                <div class="form-floating mb-3">
                                    <input name="old_password" value="<?= set_value('old_password');?>" class="form-control" id="inputCurrentPassword" type="password" placeholder="Current Password" />
                                    <label for="inputCurrentPassword">Current Password</label>
                                    <?= form_error('old_password', '<small class="text-danger pl-3">', '</small>');?>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="password" value="<?= set_value('password');?>" class="form-control" id="inputNewPassword" type="password" placeholder="New Password" />
                                    <label for="inputNewPassword">New Password</label>
                                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>');?>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="repeat_password" class="form-control" id="inputRepeatPassword" type="password" placeholder="Repeat New Password" />
                                    <label for="inputRepeatNewPassword">Repeat New Password</label>
                                    <?= form_error('repeat_password', '<small class="text-danger pl-3">', '</small>');?>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <div></div>
                                    <button type="submit" class="btn btn-primary" href="login.html">Create Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>