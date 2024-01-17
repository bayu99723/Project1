<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="bootstrap-5.1.3-dist\css\bootstrap.css">
    <link rel="stylesheet" href="fontawesome-free-6.0.0-web\css\all.min.css">
    <style type="text/css">
        .nav-bar {
            background-color: #333;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 8px;
        }

        .logo-label {
            color: green;
            font-size: 30px;
            margin-right: 780px;
        }

        .nav-bar ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-bar ul li {
            list-style: none;
            display: inline-block;
            padding: 10px 12px;
            position: relative;
            padding-right: 30px;
        }

        .nav-bar ul li a {
            color: green;
            text-decoration: none;
            font-size: 25px;
            border-bottom: 2px solid transparent; /* Menambahkan border bawah yang transparan */
            padding: 2px 0; /* Menambahkan sedikit padding di bawah teks */
        }

        .nav-bar ul li::after{
            content: '';
            width: 0%;
            height: 2px;
            background: grey;
            display: block;
            margin: auto;
            transition: 0.5s;
        }
        .nav-bar ul li:hover::after{
            width: 100%;
        }

        .nav-bar a {
            text-decoration: none;
            color: white;
        }
        .wrapper{
            width: 650px;
            margin: 0 auto;
            margin-top: 40px;
        }
        .page-header h2{
            margin-top: 0;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <div>
        <nav class="nav-bar">
        <span class="logo-label">WebKu</span>
        <ul>
            <li><a href="home.php">Menu</a></li>
            <li><a href="biodata.html">Biodata</a></li>
        </ul>
    </nav>
    </div>
    <div class="wrapper">
        <div class="container-responsive">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Data Buku</h2>
                        <a href="create.php" class="btn btn-success pull-right" style="margin-bottom: 30px; margin-left: 382px;">Tambah Baru</a><br><br>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM data_buku";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-responsive table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>No</th>";
                                        echo "<th>Judul Buku</th>";
                                        echo "<th>Pengarang</th>";
                                        echo "<th>Tahun Terbit</th>";
                                        echo "<th>Jumlah Halaman</th>";
                                        echo "<th>Harga</th>";
                                        echo "<th>Penerbit</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['judul_buku'] . "</td>";
                                        echo "<td>" . $row['pengarang'] . "</td>";
                                        echo "<td>" . $row['tahun_terbit'] . "</td>";
                                        echo "<td>" . $row['jlh_halaman'] . "</td>";
                                        echo "<td>" . $row['harga'] . "</td>";
                                        echo "<td>" . $row['penerbit'] . "</td>";
                                        
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><i class='fas fa-eye'></i></a>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><i class='fas fa-pencil-alt'></i></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><i class='fas fa-trash-alt'></i></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

