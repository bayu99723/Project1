<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$judul_buku = $pengarang = $tahun_terbit = $jlh_halaman = $harga = $penerbit = $deskripsi  = "";
$judul_buku_err = $pengarang_err = $tahun_terbit_err = $jlh_halaman_err = $harga_err = $penerbit_err = $deskripsi_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate judul_buku
    $input_judul_buku = trim($_POST["judul_buku"]);
    if(empty($input_judul_buku)){
        $judul_buku_err = "Silahkan Isi Judul Buku.";
    } elseif(!filter_var($input_judul_buku, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $judul_buku_err = "Silahkan Isi Judul Buku dengan yang lain.";
    } else{
        $judul_buku = $input_judul_buku;
    }

    // Validate pengarang
    $input_pengarang = trim($_POST["pengarang"]);
    if(empty($input_pengarang)){
        $pengarang_err = "Silahkan isi Nama Pengarang.";
    } else{
        $pengarang = $input_pengarang;
    }

    // Validate tahun_terbit
    $input_tahun_terbit = trim($_POST["tahun_terbit"]);
    if(empty($input_tahun_terbit)){
        $tahun_terbit_err = "Silahkan isi Tahun Terbit buku.";
    } elseif(!ctype_digit($input_tahun_terbit)){
        $tahun_terbit_err = "Silahkan ganti isi Tahun Terbit Buku.";
    } else{
        $tahun_terbit = $input_tahun_terbit;
    }

    // Validate jlh halaman
    $input_jlh_halaman = trim($_POST["jlh_halaman"]);
    if(empty($input_jlh_halaman)){
        $jlh_halaman_err = "Silahkan isi Jumlah Halaman buku.";
    } elseif(!ctype_digit($input_jlh_halaman)){
        $jlh_halaman_err = "Silahkan ganti isi Jumlah Halaman Buku.";
    } else{
        $jlh_halaman = $input_jlh_halaman;
    }

    // Validate jlh halaman
    $input_harga = trim($_POST["harga"]);
    if(empty($input_harga)){
        $harga_err = "Silahkan isi Harga buku";
    } elseif(!ctype_digit($input_harga)){
        $harga_err = "Silahkan ganti isi Harga Buku.";
    } else{
        $harga = $input_harga;
    }

    // Validate penerbit
    $input_penerbit = trim($_POST["penerbit"]);
    if(empty($input_penerbit)){
        $penerbit_err = "Silahkan isi Nama Penerbit.";
    } else{
        $penerbit = $input_penerbit;
    }

    // Validate penerbit
    $input_deskripsi = trim($_POST["deskripsi"]);
    if(empty($input_penerbit)){
        $deskripsi_err = "Silahkan isi Deskripsi singkat Buku";
    } else{
        $deskripsi = $input_deskripsi;
    }

    // Check input errors before inserting in database
    if(empty($judul_buku_err) && empty($pengarang_err) && empty($tahun_terbit_err) && empty($jlh_halaman_err) && empty($harga_err) && empty($pengarang_err && empty($deskripsi_err))){
        // Prepare an insert statement
        $sql = "INSERT INTO data_buku (judul_buku, pengarang, tahun_terbit, jlh_halaman, harga, penerbit, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_judul_buku, $param_pengarang, $param_tahun_terbit, $param_jlh_halaman, $param_harga, $param_penerbit, $param_deskripsi);

            // Set parameters
            $param_judul_buku = $judul_buku;
            $param_pengarang = $pengarang;
            $param_tahun_terbit = $tahun_terbit;
            $param_jlh_halaman = $jlh_halaman;
            $param_harga = $harga;
            $param_penerbit = $penerbit;
            $param_deskripsi = $deskripsi;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: home.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="bootstrap-5.1.3-dist\css\bootstrap.css">
    <link rel="stylesheet" href="fontawesome-free-6.0.0-web\css\all.min.css">
    
	<style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
            margin-bottom: 25px;

        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-14">
                    <div class="page-header"><br><br>
                        <h2>Tambahkan Tema Buku</h2>
                    </div>
                    <p>Silahkan isi data data berikut.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($judul_buku_err)) ? 'has-error' : ''; ?>">
                            <label style="margin-bottom: 10px;">Judul Buku</label>
                            <input type="text" name="judul_buku" class="form-control" value="<?php echo $judul_buku; ?>">
                            <span class="help-block"><?php echo $judul_buku_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pengarang_err)) ? 'has-error' : ''; ?>">
                            <label style="margin-bottom: 10px;">Pengarang</label>
                            <input type="text" name="pengarang" class="form-control"><?php echo $pengarang; ?></input>
                            <span class="help-block"><?php echo $pengarang_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tahun_terbit_err)) ? 'has-error' : ''; ?>">
                            <label style="margin-bottom: 10px;">tahun terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control" value="<?php echo $tahun_terbit; ?>">
                            <span class="help-block"><?php echo $tahun_terbit_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($jlh_halaman_err)) ? 'has-error' : ''; ?>">
                            <label style="margin-bottom: 10px;">Jlh Halaman</label>
                            <input type="number" name="jlh_halaman" class="form-control" value="<?php echo $jlh_halaman; ?>">
                            <span class="help-block"><?php echo $jlh_halaman_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($harga_err)) ? 'has-error' : ''; ?>">
                            <label style="margin-bottom: 10px;">Harga</label>
                            <input type="number" name="harga" class="form-control" value="<?php echo $harga; ?>">
                            <span class="help-block"><?php echo $harga_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($penerbit_err)) ? 'has-error' : ''; ?>">
                            <label style="margin-bottom: 10px;">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" value="<?php echo $penerbit; ?>">
                            <span class="help-block"><?php echo $penerbit_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($deskripsi_err)) ? 'has-error' : ''; ?>">
                            <label style="margin-bottom: 10px;">Deskripsi</label>
                            <textarea cols="30" width="100%" type="text" name="deskripsi" class="form-control" value="<?php echo $deskripsi; ?>"></textarea>
                            <span class="help-block"><?php echo $deskripsi_err;?></span>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="home.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

