<div id="layoutSidenav_content">
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Password</h3></div>
                        <div class="card-body">
                            <div class="small mb-3 text-muted">Please create your password first to secure account.</div>
                            <form method="post" action="<?= base_url('home/create_password') ?>">
                                <div class="form-floating mb-3">
                                    <input name="password" value="<?= set_value('password');?>" class="form-control" id="inputPassword" type="password" placeholder="Password" />
                                    <label for="inputPassword">Password</label>
                                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>');?>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="repeat_password" class="form-control" id="inputRepeatPassword" type="password" placeholder="Repeat Password" />
                                    <label for="inputRepeatPassword">Repeat Password</label>
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