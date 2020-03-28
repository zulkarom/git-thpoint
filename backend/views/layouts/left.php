<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->fullname?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
					
					['label' => 'Main Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/site']],
					
					['label' => 'Campaigns', 'icon' => 'microphone', 'url' => ['/campaign/index']],
					
					//['label' => 'Campaign Participant', 'icon' => 'user', 'url' => ['/campaign-participant/index']],
					
					['label' => 'Customers', 'icon' => 'users', 'url' => ['/customer/index']],
					
					['label' => 'Customer Points', 'icon' => 'check', 'url' => ['/customer-point/index']],
					
					['label' => 'Customer Rewards', 'icon' => 'gift', 'url' => ['/customer-reward/index']],
					
					['label' => 'Products', 'icon' => 'truck', 'url' => ['/product/index']],
					

					
					
					[
                        'label' => 'Users',
                        'icon' => 'user',
                        'url' => '#',
                        'items' => [
						
							['label' => 'User List', 'icon' => 'user', 'url' => ['/user/index'],],
						
							
							
							['label' => 'User Assignment', 'icon' => 'user', 'url' => ['/admin'],],
						
                            ['label' => 'User Role List', 'icon' => 'user', 'url' => ['/admin/role'],],
							
							['label' => 'Route List', 'icon' => 'user', 'url' => ['/admin/route'],],
							
	
							

                        ],
                    ],
					
					
					
					['label' => 'Change Password', 'icon' => 'lock', 'url' => ['/user/change-password']],
					
					['label' => 'Log Out', 'icon' => 'arrow-left', 'url' => ['/site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>']
					
            
                  
                ],
            ]
        ) ?>

    </section>

</aside>
