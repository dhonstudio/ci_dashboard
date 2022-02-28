        
            <div id="layoutSidenav_content">
              <main>
                <div class="container-fluid px-4">
                  <h1 class="mt-4 mb-4">Device Activity</h1>
                    
                  <div class="row">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Device Name</th>
                          <th scope="col">Last Login</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($devices as $key => $d) :?>
                          <tr>
                            <td><?= get_device_name($d['id_device'])['name'] ?></td>
                            <td>
                              <?= date('d F Y, H:i:s', $d['last_login']) ?><br>
                              <?= get_location($d['id_address']) ?>
                            </td>
                            <td>
                              <?php if (get_device_name($d['id_device'])['current'] == ''):?>
                                <a href="<?= base_url('home/device_activity/'.encrypt_url($d['id'])) ?>" onclick="return confirm('Deleted device will be log out')" class="btn btn-danger mb-2">
                                  <i class="fas fa-trash fa-fw"></i>
                                </a>
                              <?php endif?>
                            </td>
                          </tr>
                        <?php endforeach?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </main>