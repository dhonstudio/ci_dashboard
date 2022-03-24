        
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        
                        <div class="row">
                            <?php 
                                $this->load->view('elements/card', [
                                    'number'    => '543-001',
                                    'name'      => $this->user['fullName'],
                                    'qrcode'    => base_url('home/qrcode/543001')
                                ]);
                            ?>
                            <div class="col-xl-8">
                                <div class="card mb-4 shadow p-3 bg-white rounded">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <img src="
                                                    <?= $this->user['google_picture'] ? $this->user['google_picture'] : ($this->user['fb_picture'] ? $this->user['fb_picture'] : 'https://dhonstudio.com/ci/dashboard/assets/img/no_photo.png') ?>
                                                " width="100px">
                                            </div>
                                            <div class="col-6">
                                                <text class="h4"><?= $this->user['fullName'] ?></text><br>
                                                543-001
                                            </div>
                                            <div class="col">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>