<?php
session_start();
include('connection.php');
?>
<style>
  .inline-me {
    width: max-content;
    display: inline-block;
  }

  .hide-me {
    opacity: 0;
  }
</style>
<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>PT Ayam</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
        collapse-btn"> <i data-feather="align-justify"></i></a>


        
        <?php
        $hargaHariIni = mysqli_query($conn, "SELECT a.harga as harga, k.nama, a.tanggal FROM tbl_harga as a, 
                            (SELECT harga, kelas_kategori_id, MAX(tanggal) as tanggal FROM tbl_harga group by kelas_kategori_id) as b,
                            tbl_kategori as k
                            where a.tanggal=b.tanggal and a.kelas_kategori_id=b.kelas_kategori_id and k.id=a.kelas_kategori_id  ");

        if (mysqli_num_rows($hargaHariIni) > 0) {
          while ($row = mysqli_fetch_assoc($hargaHariIni)) {
        ?>
            <a href="?page=harga_telur" class="btn btn-success">Harga Telur Hari Ini : Rp.<?php echo  number_format($row['harga']); ?></a>
          <?php
          }
        }

        $belumBayar = mysqli_query($conn, "SELECT count(dibayar) as belumBayar from tbl_penjualan where dibayar=0 ");
        if (mysqli_num_rows($belumBayar) > 0) {
          while ($row = mysqli_fetch_assoc($belumBayar)) {
            if ($row['belumBayar'] == 0)
              break;
          ?>
            <a href="?page=table_penjualan&filterTable=belumBayar" class="btn btn-danger"><?php echo $row['belumBayar'] ?> Penjualan Belum Dibayar</a>
        <?php
          }
        }
        $hasilTelurHariIni = mysqli_query($conn, "
        SELECT date(tanggal) as tanggal, sum(super)+sum(standar)+sum(mk)+sum(bakso) as total
        FROM tbl_hasil 
        Where  CURRENT_DATE = date(tanggal)
        group by date(tanggal)
        ORDER BY tanggal DESC");
        $hasilTelur = 0;
        if (mysqli_num_rows($hasilTelurHariIni) > 0) {
          // output data of each row
          while ($row = mysqli_fetch_assoc($hasilTelurHariIni)) {
            $hasilTelur = $row['total'];
          }
        }
        ?>
        <a href="#" class="btn hide-me ">Hasil Telur Hari Ini : <?php echo $hasilTelur; ?></a>

        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li></li>

            <!-- <li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li> -->
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
              <span class="badge headerBadge1">
                6 </span> </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar
											text-white"> <img alt="image" src="assets/img/users/user-1.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">John
                      Deo</span>
                    <span class="time messege-text">Please check your mail !!</span>
                    <span class="time">2 Min Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-2.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                      Smith</span> <span class="time messege-text">Request for leave
                      application</span>
                    <span class="time">5 Min Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-5.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">Jacob
                      Ryan</span> <span class="time messege-text">Your payment invoice is
                      generated.</span> <span class="time">12 Min Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-4.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">Lina
                      Smith</span> <span class="time messege-text">hii John, I have upload
                      doc
                      related to task.</span> <span class="time">30
                      Min Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-3.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">Jalpa
                      Joshi</span> <span class="time messege-text">Please do as specify.
                      Let me
                      know if you have any query.</span> <span class="time">1
                      Days Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-2.png" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                      Smith</span> <span class="time messege-text">Client Requirements</span>
                    <span class="time">2 Days Ago</span>
                  </span>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Notifications
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                <a href="#" class="dropdown-item dropdown-item-unread"> <span class="dropdown-item-icon bg-primary text-white"> <i class="fas
												fa-code"></i>
                  </span> <span class="dropdown-item-desc"> Template update is
                    available now! <span class="time">2 Min
                      Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-info text-white"> <i class="far
												fa-user"></i>
                  </span> <span class="dropdown-item-desc"> <b>You</b> and <b>Dedik
                      Sugiharto</b> are now friends <span class="time">10 Hours
                      Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-success text-white"> <i class="fas
												fa-check"></i>
                  </span> <span class="dropdown-item-desc"> <b>Kusnaedi</b> has
                    moved task <b>Fix bug header</b> to <b>Done</b> <span class="time">12
                      Hours
                      Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-danger text-white"> <i class="fas fa-exclamation-triangle"></i>
                  </span> <span class="dropdown-item-desc"> Low disk space. Let's
                    clean it! <span class="time">17 Hours Ago</span>
                  </span>
                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-icon bg-info text-white"> <i class="fas
												fa-bell"></i>
                  </span> <span class="dropdown-item-desc"> Welcome to PT Ayam
                    template! <span class="time">Yesterday</span>
                  </span>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="assets/img/user.png" class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello Sarah Smith</div>
              <a href="profile.html" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a> <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                Activities
              </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="auth-login.html" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
          </li> -->
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#"> <img alt="image" src="assets/img/logo.png" class="header-logo" /> <span class="logo-name">PT Ayam</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown ">
              <a href="?page=hasil_telur" class="nav-link"><i data-feather="monitor"></i><span>Hasil Telur Perhari</span></a>
            </li>
            <li class="dropdown ">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="briefcase"></i><span>Pemasukan</span></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="?page=form_penambahan_modal" class="nav-link"><i data-feather="monitor"></i><span>Penambahan Modal</span></a>
                </li>
                <li>
                  <a href="?page=form_penjualan" class="nav-link"><i data-feather="monitor"></i><span>Input Penjualan</span></a>
                </li>
                <li>
                  <a href="?page=table_penjualan" class="nav-link"><i data-feather="monitor"></i><span>Data Penjualan</span></a>
                </li>
              </ul>
            </li>
            <li class="dropdown ">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="briefcase"></i><span>LAPORAN</span></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="?page=table_kas_umum" class="nav-link"><i data-feather="monitor"></i><span>BUKU KAS UMUM</span></a>
                </li>
                <li>
                  <a href="?page=table_laba_rugi" class="nav-link"><i data-feather="monitor"></i><span>LABA RUGI</span></a>
                </li>
                <!-- <li>
                  <a href="?page=table_perubahan_modal" class="nav-link"><i data-feather="monitor"></i><span>PERUBAHAN MODAL</span></a>
                </li> -->
                <li>
                  <a href="?page=table_neraca" class="nav-link"><i data-feather="monitor"></i><span>NERACA</span></a>
                </li>
                <!-- <li>
                  <a href="?page=table_arus_kas" class="nav-link"><i data-feather="monitor"></i><span>ARUS KAS</span></a>
                </li> -->
              </ul>
            </li>
            <!-- <li class="dropdown ">
              <a href="?page=harga_telur" class="nav-link"><i data-feather="monitor"></i><span>Update Harga Telur</span></a>
            </li> -->
            <li class="dropdown ">
              <a href="?page=pengeluaran" class="nav-link"><i data-feather="monitor"></i><span>Pengeluaran</span></a>
            </li>
          </ul>
        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <?php
            if (isset($_GET['page'])) {
              if (($_GET['page']) == 'hasil_telur') {
                include('hasil_telur.php');
              } else if (($_GET['page']) == 'harga_telur') {
                include('harga_telur.php');
              } else if (($_GET['page']) == 'form_penjualan') {
                include('Forms/form_penjualan.php');
              } else if (($_GET['page']) == 'table_penjualan') {
                include('Tables/table_penjualan.php');
              } else if (($_GET['page']) == 'pengeluaran') {
                include('pengeluaran.php');
              } else if (($_GET['page']) == 'table_kas_umum') {
                include('Tables/table_kas_umum.php');
              } else if (($_GET['page']) == 'table_laba_rugi') {
                include('Tables/table_laba_rugi.php');
              } else if (($_GET['page']) == 'table_perubahan_modal') {
                include('Tables/table_perubahan_modal.php');
              } else if (($_GET['page']) == 'table_neraca') {
                include('Tables/table_neraca.php');
              } else if (($_GET['page']) == 'table_arus_kas') {
                include('Tables/table_arus_kas.php');
              } else if (($_GET['page']) == 'form_penambahan_modal') {
                include('Forms/form_penambahan_modal.php');
              }
            } else
              include('hasil_telur.php');

            ?>

          </div>
        </section>

        <!-- Vertically Center -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form method="post" name="form_penjualan" enctype="multipart/form-data" action="actionForm/update_penjualan.php">
                <div class="modal-body">
                  <label id="proccedPaymentData"> Pembelian XXXX</label>
                  <input hidden type="text" id="proccedPaymentId" name="proccedPaymentId" class="form-control">
                </div>
                <div class="modal-footer bg-whitesmoke br">
                  <button class="btn btn-primary" type="submit" name="save" value="Simpan">Lunas</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Vertically Center -->
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="templateshub.net">Templateshub</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script> baru
  <script src="assets/bundles/apexcharts/apexcharts.min.js"></script>
  <script src="assets/bundles/datatables/datatables.min.js"></script>
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/datatables.js"></script>
  <script src="assets/js/page/index.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>


  <script type="text/javascript">
    function customCurrency(item) {
      var currentValue = item.value.replaceAll(",", "").replace(/([a-zA-Z ])/g, "");
      console.log(currentValue);
      document.getElementById(item.id).value = currentValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return;
    }

  </script>

</body>
<?php
mysqli_close($conn);
?>

</html>