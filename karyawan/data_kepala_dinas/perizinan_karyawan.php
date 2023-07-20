<?php 
    include "../../koneksi.php";

    session_start();
    $id_anggota = $_SESSION['id_anggota'];
    $query = mysqli_query($conn, "SELECT * FROM tb_karyawan WHERE id_anggota = '$id_anggota'");
    $data = mysqli_fetch_array($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Skripsi</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />

</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon rotate-n-0">
                    <img src="../../img/Logo.png" alt="" style="width:30px">
                </div>
                <div class="sidebar-brand-text mx-3">Dinas Sosial</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="view.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Data Pribadi</span></a>
            </li>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-table"></i>
                    <span>perizinan Karyawan</span></a>
            </li>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="../../logout.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Keluar</span></a>
            </li>

            <hr class="sidebar-divider my-0">

        </ul>

        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span <?php 
                    include "../../koneksi.php";
                    $query=mysqli_query($conn, "SELECT * FROM tb_karyawan WHERE id_anggota = $id_anggota");
                    $data=mysqli_fetch_array($query);
                    ?> class="mr-2 d-none d-lg-inline text-gray-800 small"><?php echo $data['nama_karyawan']; ?></span>
                                <img class="img-profile rounded-circle" src="../../img/undraw_profile.svg">
                            </a>
                        </li>

                    </ul>

                </nav>

                <div class="container-fluid">

                    <div class="container-fluid">


                        <h1 class="h3 mb-2 text-gray-800">Data Perizinan</h1>
                        <div class="card shadow mb-4">
                            <!-- <div class="card-header py-3">
                            </div> -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Karyawan</th>
                                                <th>NIP</th>
                                                <th>Jenis Izin</th>
                                                <th>status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
                                        include "../../koneksi.php";
                                        // $sql="SELECT * from perizinan_karyawan order by id_perizinan desc";
                                        $sql="SELECT * FROM perizinan_karyawan
                                        JOIN tb_karyawan ON perizinan_karyawan.id_anggota = tb_karyawan.id_anggota
                                        ORDER BY status";
                                        function status($id)
                                        {

                                            switch ($id) {
                                                case '1':
                                                    return "Menunggu";
                                                case '2':
                                                    return "Diiznkan";
                                                case '3':
                                                    return "Ditolak";
                                                default:
                                                    return "-";
                                            }
                                        }
                                        
                                        $hasil=mysqli_query($conn,$sql);
                                        $no=0;
                                        while ($data = mysqli_fetch_array($hasil)) {
                                        $no++;

                                    ?>

                                            <tr>
                                                <td><?php echo $no;?></td>
                                                <td><?php echo $data['nama_karyawan']; ?></td>
                                                <td><?php echo $data['nip']; ?></td>
                                                <td><?php echo $data['nama_izin']; ?></td>
                                                <td>
                                                    <?php if ($data['status'] == "1") { ?>
                                                    <?= status($data['status']) ?>
                                                    <?php } else if ($data['status'] == "2") { ?>
                                                    <?= status($data['status']) ?>
                                                    <?php } else if ($data['status'] == "3") { ?>
                                                    <?= status($data['status']) ?>
                                                    <?php } else
                                            ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="<?php echo "#data-detail".$data['id_perizinan']; ?>">Lihat
                                                        Detail
                                                    </button>

                                                    <!-- TERIMA IZIN -->

                                                    <a href="fungsi.php?id=<?= $data['id_perizinan']; ?>&terima_data_izin=&id_anggota=<?= $data['id_anggota']; ?>"
                                                        onclick="return confirm('apakah anda yakin ingin menerima izin ini ?');"
                                                        type="submit" name="terima_data_izin">
                                                        <?php if ($data['status'] == "2") { ?>
                                                        <button type='button' class='btn btn-secondary'
                                                            disabled>Terima</button>
                                                        <?php } else if ($data['status'] == "3") { ?>
                                                        <button type='button' class='btn btn-secondary'
                                                            disabled>Terima</button>
                                                        <?php } else if ($data['status'] == "1") { ?>
                                                        <button type='button' class='btn btn-success'>Terima</button>
                                                        <?php } else ?>
                                                    </a>

                                                    <!-- TOLAK -->

                                                    <a href="fungsi.php?id=<?= $data['id_perizinan']; ?>&tolak_data_izin=&id_anggota=<?= $data['id_anggota']; ?>"
                                                        onclick="return confirm('apakah anda yakin ingin menolak izin ini ?');"
                                                        type="submit" name="tolak_data_izin">
                                                        <?php if ($data['status'] == "2") { ?>
                                                        <button type='button' class='btn btn-secondary'
                                                            disabled>Tolak</button>
                                                        <?php } else if ($data['status'] == "3") { ?>
                                                        <button type='button' class='btn btn-secondary'
                                                            disabled>Tolak</button>
                                                        <?php } else if ($data['status'] == "1") { ?>
                                                        <button type='button' class='btn btn-danger'>Tolak</button>
                                                        <?php } else ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                            
                                        }
                                                 
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <?php

        include "../../koneksi.php";

        $sql="SELECT * FROM perizinan_karyawan JOIN tb_karyawan ON perizinan_karyawan.id_anggota = tb_karyawan.id_anggota";
           
        

        $hasil=mysqli_query($conn,$sql);
        while ($data = mysqli_fetch_array($hasil)) {
        
        ?>

            <!-- MODAL DETAIL KARYAWAN -->

            <div id=<?php echo "data-detail".$data['id_perizinan']?> class="modal fade mr-tp-100" role="dialog">
                <div class="modal-dialog modal-lg flipInX animated">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Detail Perizinan Karyawan</h4>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Tutup</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">

                                <label>Nama Karyawan</label>
                                <input type="text" id="nama_karyawan" class="form-control"
                                    value="<?= $data["nama_karyawan"]; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" id="nip" class="form-control" value="<?= $data["nip"]; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Izin</label>
                                <input type="text" id="jk" class="form-control" value="<?= $data["nama_izin"]; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label>Awal Izin</label>
                                <input type="text" id="golongan" class="form-control" value="<?= $data["awal_izin"]; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label>Selesai Izin</label>
                                <input type="text" id="jabatan" class="form-control"
                                    value="<?= $data["selesai_izin"]; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" id="ruangan" class="form-control"
                                    value="<?= $data["keterangan_izin"]; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" id="keterangan" class="form-control"
                                    value="<?= status($data["status"]); ?>" readonly>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info rounded-pill" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
            }
        ?>


        <script src="../../vendor/jquery/jquery.min.js"></script>
        <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../../vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../../js/demo/chart-area-demo.js"></script>
        <script src="../../js/demo/chart-pie-demo.js"></script>

        <!-- Page level plugins -->
        <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../../js/demo/datatables-demo.js"></script>

</body>

</html>