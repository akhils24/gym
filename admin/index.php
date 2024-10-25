<?php
include('header.php');
?>

<div class="main-panel">
  <div class="main-header">
    <!-- Navbar Header -->
    <nav
      class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
    >
      <div class="container-fluid">
        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex" >
          <div class="input-group">
            <input type="text" placeholder="Search ..." class="form-control"/>
            <div class="input-group-prepend">
              <button type="submit" class="btn btn-search pe-1"> <i class="fa fa-search search-icon"></i> </button>
            </div>
          </div>
        </nav>
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
          <li class="nav-item topbar-user dropdown hidden-caret">
            <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false" >
              <div class="avatar-sm">
                <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
              </div>
              <span class="profile-username">
                <span class="op-7">Hi,</span>
                <?php if($_SESSION['usertype'] == 'AD'):?>
                 <span class="fw-bold">Admin</span>
                <?php elseif($_SESSION['usertype'] == 'ST') :?>
                  <span class="fw-bold">Staff</span>
                  <?php endif;?>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-user animated fadeIn">
              <div class="dropdown-user-scroll scrollbar-outer">
                <li>
                  <div class="user-box">
                    <div class="avatar-lg">
                      <img src="assets/img/profile.jpg" alt="image profile" class="avatar-img rounded" />
                    </div>
                    <div class="u-text">
                      <?php if($_SESSION['usertype'] == 'AD'):?>
                      <h4>ADMIN</h4>
                      <p class="text-muted">admin@example.com</p>
                      <?php elseif($_SESSION['usertype'] == 'ST') :?>
                      <h4>STAFF</h4>
                      <p class="text-muted">staff@example.com</p>
                      <a href="profile.html" class="btn btn-xs btn-secondary btn-sm" >View Profile</a>
                      <?php endif;?>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="logout.php">Logout</a>
                </li>
              </div>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
  </div>

  <div class="container">
    <div class="page-inner">
      <div
        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
      >
        <div>
          <h3 class="fw-bold mb-3">Dashboard</h3>
          <!-- <h6 class="op-7 mb-2">Free Bootstrap 5 Admin Dashboard</h6> -->
        </div>
        <!-- <div class="ms-md-auto py-2 py-md-0">
          <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
          <a href="#" class="btn btn-primary btn-round">Add Customer</a>
        </div> -->
      </div>
      <div class="row">
        <div class="col-sm-6 col-md-3">
          <div class="card card-stats card-round">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div
                    class="icon-big text-center icon-primary bubble-shadow-small"
                  >
                    <i class="fas fa-users"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Visitors</p>
                    <h4 class="card-title">1,294</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="card card-stats card-round">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div
                    class="icon-big text-center icon-info bubble-shadow-small"
                  >
                    <i class="fas fa-user-check"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Subscribers</p>
                    <h4 class="card-title">1303</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="card card-stats card-round">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div
                    class="icon-big text-center icon-success bubble-shadow-small"
                  >
                    <i class="fas fa-luggage-cart"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Sales</p>
                    <h4 class="card-title">$ 1,345</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="card card-stats card-round">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div
                    class="icon-big text-center icon-secondary bubble-shadow-small"
                  >
                    <i class="far fa-check-circle"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Order</p>
                    <h4 class="card-title">576</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <div class="card card-round">
            <div class="card-header">
              <div class="card-head-row">
                <div class="card-title">User Statistics</div>
                <div class="card-tools">
                  <a
                    href="#"
                    class="btn btn-label-success btn-round btn-sm me-2"
                  >
                    <span class="btn-label">
                      <i class="fa fa-pencil"></i>
                    </span>
                    Export
                  </a>
                  <a href="#" class="btn btn-label-info btn-round btn-sm">
                    <span class="btn-label">
                      <i class="fa fa-print"></i>
                    </span>
                    Print
                  </a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="chart-container" style="min-height: 375px">
                <canvas id="statisticsChart"></canvas>
              </div>
              <div id="myChartLegend"></div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-primary card-round">
            <div class="card-header">
              <div class="card-head-row">
                <div class="card-title">Daily Sales</div>
                <div class="card-tools">
                  <div class="dropdown">
                    <button
                      class="btn btn-sm btn-label-light dropdown-toggle"
                      type="button"
                      id="dropdownMenuButton"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      Export
                    </button>
                    <div
                      class="dropdown-menu"
                      aria-labelledby="dropdownMenuButton"
                    >
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#"
                        >Something else here</a
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-category">March 25 - April 02</div>
            </div>
            <div class="card-body pb-0">
              <div class="mb-4 mt-2">
                <h1>$4,578.58</h1>
              </div>
              <div class="pull-in">
                <canvas id="dailySalesChart"></canvas>
              </div>
            </div>
          </div>
          <div class="card card-round">
            <div class="card-body pb-0">
              <div class="h1 fw-bold float-end text-primary">+5%</div>
              <h2 class="mb-2">17</h2>
              <p class="text-muted">Users online</p>
              <div class="pull-in sparkline-fix">
                <div id="lineChart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-round">
            <div class="card-header">
              <div class="card-head-row card-tools-still-right">
                <h4 class="card-title">Users Geolocation</h4>
                <div class="card-tools">
                  <button
                    class="btn btn-icon btn-link btn-primary btn-xs"
                  >
                    <span class="fa fa-angle-down"></span>
                  </button>
                  <button
                    class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card"
                  >
                    <span class="fa fa-sync-alt"></span>
                  </button>
                  <button
                    class="btn btn-icon btn-link btn-primary btn-xs"
                  >
                    <span class="fa fa-times"></span>
                  </button>
                </div>
              </div>
              <p class="card-category">
                Map of the distribution of users around the world
              </p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="table-responsive table-hover table-sales">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>
                            <div class="flag">
                              <img
                                src="assets/img/flags/id.png"
                                alt="indonesia"
                              />
                            </div>
                          </td>
                          <td>Indonesia</td>
                          <td class="text-end">2.320</td>
                          <td class="text-end">42.18%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img
                                src="assets/img/flags/us.png"
                                alt="united states"
                              />
                            </div>
                          </td>
                          <td>USA</td>
                          <td class="text-end">240</td>
                          <td class="text-end">4.36%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img
                                src="assets/img/flags/au.png"
                                alt="australia"
                              />
                            </div>
                          </td>
                          <td>Australia</td>
                          <td class="text-end">119</td>
                          <td class="text-end">2.16%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img
                                src="assets/img/flags/ru.png"
                                alt="russia"
                              />
                            </div>
                          </td>
                          <td>Russia</td>
                          <td class="text-end">1.081</td>
                          <td class="text-end">19.65%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img
                                src="assets/img/flags/cn.png"
                                alt="china"
                              />
                            </div>
                          </td>
                          <td>China</td>
                          <td class="text-end">1.100</td>
                          <td class="text-end">20%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img
                                src="assets/img/flags/br.png"
                                alt="brazil"
                              />
                            </div>
                          </td>
                          <td>Brasil</td>
                          <td class="text-end">640</td>
                          <td class="text-end">11.63%</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mapcontainer">
                    <div
                      id="world-map"
                      class="w-100"
                      style="height: 300px"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="card card-round">
            <div class="card-body">
              <div class="card-head-row card-tools-still-right">
                <div class="card-title">New Customers</div>
                <div class="card-tools">
                  <div class="dropdown">
                    <button
                      class="btn btn-icon btn-clean me-0"
                      type="button"
                      id="dropdownMenuButton"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div
                      class="dropdown-menu"
                      aria-labelledby="dropdownMenuButton"
                    >
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#"
                        >Something else here</a
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-list py-4">
                <div class="item-list">
                  <div class="avatar">
                    <img
                      src="assets/img/jm_denis.jpg"
                      alt="..."
                      class="avatar-img rounded-circle"
                    />
                  </div>
                  <div class="info-user ms-3">
                    <div class="username">Jimmy Denis</div>
                    <div class="status">Graphic Designer</div>
                  </div>
                  <button class="btn btn-icon btn-link op-8 me-1">
                    <i class="far fa-envelope"></i>
                  </button>
                  <button class="btn btn-icon btn-link btn-danger op-8">
                    <i class="fas fa-ban"></i>
                  </button>
                </div>
                <div class="item-list">
                  <div class="avatar">
                    <span
                      class="avatar-title rounded-circle border border-white"
                      >CF</span
                    >
                  </div>
                  <div class="info-user ms-3">
                    <div class="username">Chandra Felix</div>
                    <div class="status">Sales Promotion</div>
                  </div>
                  <button class="btn btn-icon btn-link op-8 me-1">
                    <i class="far fa-envelope"></i>
                  </button>
                  <button class="btn btn-icon btn-link btn-danger op-8">
                    <i class="fas fa-ban"></i>
                  </button>
                </div>
                <div class="item-list">
                  <div class="avatar">
                    <img
                      src="assets/img/talha.jpg"
                      alt="..."
                      class="avatar-img rounded-circle"
                    />
                  </div>
                  <div class="info-user ms-3">
                    <div class="username">Talha</div>
                    <div class="status">Front End Designer</div>
                  </div>
                  <button class="btn btn-icon btn-link op-8 me-1">
                    <i class="far fa-envelope"></i>
                  </button>
                  <button class="btn btn-icon btn-link btn-danger op-8">
                    <i class="fas fa-ban"></i>
                  </button>
                </div>
                <div class="item-list">
                  <div class="avatar">
                    <img
                      src="assets/img/chadengle.jpg"
                      alt="..."
                      class="avatar-img rounded-circle"
                    />
                  </div>
                  <div class="info-user ms-3">
                    <div class="username">Chad</div>
                    <div class="status">CEO Zeleaf</div>
                  </div>
                  <button class="btn btn-icon btn-link op-8 me-1">
                    <i class="far fa-envelope"></i>
                  </button>
                  <button class="btn btn-icon btn-link btn-danger op-8">
                    <i class="fas fa-ban"></i>
                  </button>
                </div>
                <div class="item-list">
                  <div class="avatar">
                    <span
                      class="avatar-title rounded-circle border border-white bg-primary"
                      >H</span
                    >
                  </div>
                  <div class="info-user ms-3">
                    <div class="username">Hizrian</div>
                    <div class="status">Web Designer</div>
                  </div>
                  <button class="btn btn-icon btn-link op-8 me-1">
                    <i class="far fa-envelope"></i>
                  </button>
                  <button class="btn btn-icon btn-link btn-danger op-8">
                    <i class="fas fa-ban"></i>
                  </button>
                </div>
                <div class="item-list">
                  <div class="avatar">
                    <span
                      class="avatar-title rounded-circle border border-white bg-secondary"
                      >F</span
                    >
                  </div>
                  <div class="info-user ms-3">
                    <div class="username">Farrah</div>
                    <div class="status">Marketing</div>
                  </div>
                  <button class="btn btn-icon btn-link op-8 me-1">
                    <i class="far fa-envelope"></i>
                  </button>
                  <button class="btn btn-icon btn-link btn-danger op-8">
                    <i class="fas fa-ban"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card card-round">
            <div class="card-header">
              <div class="card-head-row card-tools-still-right">
                <div class="card-title">Transaction History</div>
                <div class="card-tools">
                  <div class="dropdown">
                    <button
                      class="btn btn-icon btn-clean me-0"
                      type="button"
                      id="dropdownMenuButton"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div
                      class="dropdown-menu"
                      aria-labelledby="dropdownMenuButton"
                    >
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#"
                        >Something else here</a
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center mb-0">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Payment Number</th>
                      <th scope="col" class="text-end">Date & Time</th>
                      <th scope="col" class="text-end">Amount</th>
                      <th scope="col" class="text-end">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">
                        <button
                          class="btn btn-icon btn-round btn-success btn-sm me-2"
                        >
                          <i class="fa fa-check"></i>
                        </button>
                        Payment from #10231
                      </th>
                      <td class="text-end">Mar 19, 2020, 2.45pm</td>
                      <td class="text-end">$250.00</td>
                      <td class="text-end">
                        <span class="badge badge-success">Completed</span>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">
                        <button
                          class="btn btn-icon btn-round btn-success btn-sm me-2"
                        >
                          <i class="fa fa-check"></i>
                        </button>
                        Payment from #10231
                      </th>
                      <td class="text-end">Mar 19, 2020, 2.45pm</td>
                      <td class="text-end">$250.00</td>
                      <td class="text-end">
                        <span class="badge badge-success">Completed</span>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">
                        <button
                          class="btn btn-icon btn-round btn-success btn-sm me-2"
                        >
                          <i class="fa fa-check"></i>
                        </button>
                        Payment from #10231
                      </th>
                      <td class="text-end">Mar 19, 2020, 2.45pm</td>
                      <td class="text-end">$250.00</td>
                      <td class="text-end">
                        <span class="badge badge-success">Completed</span>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">
                        <button
                          class="btn btn-icon btn-round btn-success btn-sm me-2"
                        >
                          <i class="fa fa-check"></i>
                        </button>
                        Payment from #10231
                      </th>
                      <td class="text-end">Mar 19, 2020, 2.45pm</td>
                      <td class="text-end">$250.00</td>
                      <td class="text-end">
                        <span class="badge badge-success">Completed</span>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">
                        <button
                          class="btn btn-icon btn-round btn-success btn-sm me-2"
                        >
                          <i class="fa fa-check"></i>
                        </button>
                        Payment from #10231
                      </th>
                      <td class="text-end">Mar 19, 2020, 2.45pm</td>
                      <td class="text-end">$250.00</td>
                      <td class="text-end">
                        <span class="badge badge-success">Completed</span>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">
                        <button
                          class="btn btn-icon btn-round btn-success btn-sm me-2"
                        >
                          <i class="fa fa-check"></i>
                        </button>
                        Payment from #10231
                      </th>
                      <td class="text-end">Mar 19, 2020, 2.45pm</td>
                      <td class="text-end">$250.00</td>
                      <td class="text-end">
                        <span class="badge badge-success">Completed</span>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">
                        <button
                          class="btn btn-icon btn-round btn-success btn-sm me-2"
                        >
                          <i class="fa fa-check"></i>
                        </button>
                        Payment from #10231
                      </th>
                      <td class="text-end">Mar 19, 2020, 2.45pm</td>
                      <td class="text-end">$250.00</td>
                      <td class="text-end">
                        <span class="badge badge-success">Completed</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <!-- <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script> -->

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>
    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>
  </body>
</html>
