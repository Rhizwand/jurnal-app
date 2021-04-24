    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <?php
      // Query ke menu
      $role_id = $this->session->userdata('role_id');
      $queryMenu = "SELECT `user_menu`.`id`, menu FROM user_menu JOIN user_access_menu ON `user_menu`.`id`= `user_access_menu`.`menu_id` WHERE `user_access_menu`.`role_id` = $role_id ORDER BY `user_access_menu`.`id` ASC";
      $menus = $this->db->query($queryMenu)->result_array();
      foreach ($menus as $menu) :
      ?>
        <!-- Heading -->
        <div class="sidebar-heading mt-3">
          <?= $menu['menu'] ?>
        </div>
        <?php
        // query ke sub menu
        $subMenus = $this->db->get_where('user_sub_menu', ['menu_id' => $menu['id']])->result_array();
        foreach ($subMenus as $subMenu) :
        ?>
          <!-- Nav Item - Dashboard -->
          <?php if ($subMenu['title'] == $title) : ?>
            <li class="nav-item active">
            <?php else : ?>
            <li class="nav-item ">
            <?php endif; ?>
            <a class="nav-link pb-0 " href="<?= base_url($subMenu['url']) ?>">
              <i class="<?= $subMenu['icon'] ?>"></i>
              <span><?= $subMenu['title'] ?></span></a>
            </li>
          <?php endforeach ?>

          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block mt-3">

        <?php endforeach ?>
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->