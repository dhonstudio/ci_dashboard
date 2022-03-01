<?php
    $pages = [
        [
            'heading'       => '',
            'subheading'    => [
                [
                    'title' => 'Dashboard',
                    'url'   => '',
                    'icon'  => 'fas fa-tachometer-alt'
                ],
            ],
        ],
        [
            'heading'       => 'Addons',
            'subheading'    => [
                [
                    'title'     => 'Charts',
                    'url'       => 'home/dashboard_charts',
                    'icon'      => 'fas fa-chart-area',
                ],
                [
                    'title'     => 'Tables',
                    'url'       => 'tables.html',
                    'icon'      => 'fas fa-table',
                ],
            ],
        ],
        [
            'heading'       => 'Interface',
            'subheading'    => [
                [
                    'title'     => 'Layouts',
                    'url'       => '#',
                    'icon'      => 'fas fa-columns',
                    'subtitle'  => [
                        [
                            'title' => 'Static Navigation',
                            'url'   => 'layout-static.html'
                        ],
                        [
                            'title' => 'Light Sidenav',
                            'url'   => 'layout-sidenav-light.html'
                        ],
                    ]
                ],
                [
                    'title'     => 'Pages',
                    'url'       => '#',
                    'icon'      => 'fas fa-book-open',
                    'subtitle'  => [
                        [
                            'title'     => 'Authentication',
                            'url'       => '#',
                            'subpage'   => [
                                [
                                    'title' => 'Login',
                                    'url'   => 'login.html'
                                ],
                                [
                                    'title' => 'Register',
                                    'url'   => 'register.html'
                                ],
                                [
                                    'title' => 'Forgot Password',
                                    'url'   => 'password.html'
                                ],
                            ]
                        ],
                        [
                            'title'     => 'Error',
                            'url'       => '#',
                            'subpage'   => [
                                [
                                    'title' => '401 Page',
                                    'url'   => '401.html'
                                ],
                                [
                                    'title' => '404 Page',
                                    'url'   => '404.html'
                                ],
                                [
                                    'title' => '500 Page',
                                    'url'   => '500.html'
                                ],
                            ]
                        ],
                    ]
                ],
            ],
        ],
        
    ]
?>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <?php foreach ($pages as $kp => $p) :?>
                                <div class="sb-sidenav-menu-heading"><?= $p['heading'] ?></div>
                                <?php foreach ($p['subheading'] as $kps => $ps) :?>
                                    <a class="nav-link 
                                    <?= isset($ps['subtitle']) ? 'collapsed' : (isset($page) && $page == $ps['title'] ? 'active' : '') ?>" href="<?= base_url($ps['url']) ?>" 
                                    <?= isset($ps['subtitle']) ? 'data-bs-toggle="collapse" data-bs-target="#collapse'.$ps['title'].'" aria-expanded="false" aria-controls="collapse'.$ps['title'].'"' : '' ?>>
                                        <div class="sb-nav-link-icon"><i class="<?= $ps['icon']?>"></i></div>
                                        <?= $ps['title'] ?>
                                        <?= isset($ps['subtitle']) ? '<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>' : ''?>
                                    </a>
                                    <?php if (isset($ps['subtitle'])):?>
                                        <div class="collapse" id="collapse<?= $ps['title'] ?>" aria-labelledby="heading<?= $kps ?>" data-bs-parent="#sidenavAccordion">
                                            <nav class="sb-sidenav-menu-nested nav">
                                                <?php foreach ($ps['subtitle'] as $kst => $st) :?>
                                                    <a class="nav-link 
                                                    <?= isset($st['subpage']) ? 'collapsed' : ''?>" href="<?= $st['url'] ?>"
                                                    <?= isset($st['subpage']) ? 'data-bs-toggle="collapse" data-bs-target="#'.$ps['title'] .'Collapse'.$st['title'].'" aria-expanded="false" aria-controls="'.$ps['title'] .'Collapse'.$st['title'].'"' : ''?>>
                                                        <?= $st['title'] ?>
                                                        <?= isset($st['subpage']) ? '<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>' : ''?>
                                                    </a>
                                                    <?php if (isset($st['subpage'])):?>
                                                        <div class="collapse" id="<?= $ps['title'] .'Collapse'.$st['title'] ?>" aria-labelledby="heading<?= $kst ?>" data-bs-parent="#sidenavAccordion<?= $ps['title']?>">
                                                            <nav class="sb-sidenav-menu-nested nav">
                                                                <?php foreach ($st['subpage'] as $ksp => $sp) :?>
                                                                    <a class="nav-link" href="<?= $sp['url'] ?>"><?= $sp['title'] ?></a>
                                                                <?php endforeach?>
                                                            </nav>
                                                        </div>
                                                    <?php endif?>
                                                <?php endforeach?>
                                            </nav>
                                        </div>
                                    <?php endif?>
                                <?php endforeach?>
                            <?php endforeach?>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?= $this->user['fullName'] ?>
                    </div>
                </nav>
            </div>