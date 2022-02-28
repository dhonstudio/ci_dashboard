        
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
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($devices as $key => $d) :?>
                          <tr>
                            <td><?= get_device_name($d['id_device']) ?></td>
                            <td>
                              <?= date('d F Y, H:i:s', $d['last_login']) ?><br>
                              <?= get_location($d['id_address']) ?>
                            </td>
                          </tr>
                        <?php endforeach?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </main>