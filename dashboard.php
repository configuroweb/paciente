<?php
include './config/connection.php';
include './common_service/common_functions.php';

$date = date('Y-m-d');

$year =  date('Y');
$month =  date('m');

$queryToday = "SELECT count(*) as `today` 
  from `patient_visits` 
  where `visit_date` = '$date';";

$queryWeek = "SELECT count(*) as `week` 
  from `patient_visits` 
  where YEARWEEK(`visit_date`) = YEARWEEK('$date');";

$queryYear = "SELECT count(*) as `year` 
  from `patient_visits` 
  where YEAR(`visit_date`) = YEAR('$date');";

$queryMonth = "SELECT count(*) as `month` 
  from `patient_visits` 
  where YEAR(`visit_date`) = $year and 
  MONTH(`visit_date`) = $month;";

$todaysCount = 0;
$currentWeekCount = 0;
$currentMonthCount = 0;
$currentYearCount = 0;


try {

  $stmtToday = $con->prepare($queryToday);
  $stmtToday->execute();
  $r = $stmtToday->fetch(PDO::FETCH_ASSOC);
  $todaysCount = $r['today'];

  $stmtWeek = $con->prepare($queryWeek);
  $stmtWeek->execute();
  $r = $stmtWeek->fetch(PDO::FETCH_ASSOC);
  $currentWeekCount = $r['week'];

  $stmtYear = $con->prepare($queryYear);
  $stmtYear->execute();
  $r = $stmtYear->fetch(PDO::FETCH_ASSOC);
  $currentYearCount = $r['year'];

  $stmtMonth = $con->prepare($queryMonth);
  $stmtMonth->execute();
  $r = $stmtMonth->fetch(PDO::FETCH_ASSOC);
  $currentMonthCount = $r['month'];
} catch (PDOException $ex) {
  echo $ex->getMessage();
  echo $ex->getTraceAsString();
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include './config/site_css_links.php'; ?>
  <title>Sistema de Gestión de Pacientes</title>
  <style>
    .dark-mode .bg-fuchsia,
    .dark-mode .bg-maroon {
      color: #fff !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->

    <?php

    include './config/header.php';
    include './config/sidebar.php';
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Pacientes</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-maroon">
                <div class="inner">
                  <h3><?php echo $todaysCount; ?></h3>

                  <p>Hoy</p>
                </div>
                <div class="icon">
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-maroon">
                <div class="inner">
                  <h3><?php echo $currentWeekCount; ?></h3>

                  <p>Esta Semana</p>
                </div>
                <div class="icon">
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-maroon text-reset">
                <div class="inner">
                  <h3><?php echo $currentMonthCount; ?></h3>

                  <p>Este Mes</p>
                </div>
                <div class="icon">
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-maroon text-reset">
                <div class="inner">
                  <h3><?php echo $currentYearCount; ?></h3>

                  <p>Este Año</p>
                </div>
                <div class="icon">
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->

    <?php include './config/footer.php'; ?>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <?php include './config/site_js_links.php'; ?>
  <script>
    $(function() {
      showMenuSelected("#mnu_dashboard", "");
    })
  </script>



</body>

</html>