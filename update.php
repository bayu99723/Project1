<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$judul_buku = $pengarang = $tahun_terbit = $jlh_halaman = $harga = $penerbit = $deskripsi_err = "";
$judul_buku_err = $pengarang_err = $tahun_terbit_err = $jlh_halaman_err = $harga_err = $penerbit_err = $deskripsi_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate Judul Buku
    $input_judul_buku = trim($_POST["judul_buku"]);
    if(empty($input_judul_buku)){
        $judul_buku_err = "Please enter a name.";
    } elseif(!filter_var($input_judul_buku, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $judul_buku_err = "Please enter a valid name.";
    } else{
        $judul_buku = $input_judul_buku;
    }
    
    // Validate Pengarang
    $input_pengarang = trim($_POST["pengarang"]);
    if(empty($input_pengarang)){
        $pengarang_err = "Please enter an pengarang.";
    } else{
        $pengarang = $input_pengarang;
    }
    
    // Validate Tahun Terbit
    $input_tahun_terbit = trim($_POST["tahun_terbit"]);
    if(empty($input_tahun_terbit)){
        $tahun_terbit_err = "Please enter the tahun terbit amount.";
    } elseif(!ctype_digit($input_tahun_terbit)){
        $tahun_terbit_err = "Please enter a positive integer value.";
    } else{
        $tahun_terbit = $input_tahun_terbit;
    }

    // Validate Jlh Halaman
    $input_jlh_halaman = trim($_POST["jlh_halaman"]);
    if(empty($input_jlh_halaman)){
        $jlh_halaman_err = "Please enter an jlh halaman.";
    } elseif(!ctype_digit($input_jlh_halaman)){
        $jlh_halaman_err = "Please enter a positive integer value.";
    } else{
        $jlh_halaman = $input_jlh_halaman;
    }

    // Validate Harga
    $input_harga = trim($_POST["harga"]);
    if(empty($input_harga)){
        $harga_err = "Please enter an harga.";
    } elseif(!ctype_digit($input_harga)){
        $harga_err = "Please enter a positive integer value.";
    } else{
        $harga = $input_harga;
    }

    // Validate penerbit
    $input_penerbit = trim($_POST["penerbit"]);
    if(empty($input_penerbit)){
        $penerbit_err = "Please enter an penerbit.";
    } else{
        $penerbit = $input_penerbit;
    }

    // Validate Deskripsi
    $input_deskripsi = trim($_POST["deskripsi"]);
    if(empty($input_deskripsi)){
        $deskripsi_err = "Please enter an deskripsi.";
    } else{
        $deskripsi = $input_deskripsi;
    }
    
    // Check input errors before inserting in database
    if(empty($judul_buku_err) && empty($pengarang_err) && empty($tahun_terbit_err) && empty($jlh_halaman_err) && empty($harga_err) && empty($penerbit_err && empty($deskripsi_err))){
        // Prepare an update statement
        $sql = "UPDATE data_buku SET judul_buku=?, pengarang=?, tahun_terbit=?, jlh_halaman=?, harga=?, penerbit=?, deskripsi=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "sssssssi", $param_judul_buku, $param_pengarang, $param_tahun_terbit, $param_jlh_halaman, $param_harga, $param_penerbit, $deskripsi, $param_id);
            
            // Set parameters
            $param_judul_buku = $judul_buku;
            $param_pengarang = $pengarang;
            $param_tahun_terbit = $tahun_terbit;
            $param_jlh_halaman = $jlh_halaman;
            $param_harga = $harga;
            $param_penerbit = $penerbit;
            $param_deskripsi = $deskripsi;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM data_buku WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $judul_buku = $row["judul_buku"];
                    $pengarang = $row["pengarang"];
                    $tahun_terbit = $row["tahun_terbit"];
                    $jlh_halaman = $row["jlh_halaman"];
                    $harga = $row["harga"];
                    $penerbit = $row["penerbit"];
                    $deskripsi = $row["deskripsi"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="page-header">
                        <h2>Perbarui Record</h2>
                    </div>
                    <p>Mohon edit data untuk di perbarui.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" style="margin-bottom: 20px;">
                        <div class="form-group <?php echo (!empty($judul_buku_err)) ? 'has-error' : ''; ?>">
                            <label>Judul Buku</label>
                            <input type="text" name="judul_buku" class="form-control" value="<?php echo $judul_buku; ?>">
                            <span class="help-block"><?php echo $judul_buku_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pengarang_err)) ? 'has-error' : ''; ?>">
                            <label>Pengarang</label>
                            <textarea name="pengarang" class="form-control"><?php echo $pengarang; ?></textarea>
                            <span class="help-block"><?php echo $pengarang_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tahun_terbit_err)) ? 'has-error' : ''; ?>">
                            <label>Tahun Terbit</label>
                            <input type="text" name="tahun_terbit" class="form-control" value="<?php echo $tahun_terbit; ?>">
                            <span class="help-block"><?php echo $tahun_terbit_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($jlh_halaman_err)) ? 'has-error' : ''; ?>">
                            <label>Jumlah Halaman</label>
                            <input type="text" name="jlh_halaman" class="form-control" value="<?php echo $jlh_halaman; ?>">
                            <span class="help-block"><?php echo $jlh_halaman_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($harga_err)) ? 'has-error' : ''; ?>">
                            <label>Harga</label>
                            <input type="text" name="harga" class="form-control" value="<?php echo $harga; ?>">
                            <span class="help-block"><?php echo $harga_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($penerbit_err)) ? 'has-error' : ''; ?>">
                            <label>Nama Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" value="<?php echo $penerbit; ?>">
                            <span class="help-block"><?php echo $penerbit_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($deskripsi_err)) ? 'has-error' : ''; ?>">
                            <label>deskripsi</label>
                            <input type="text" name="deskripsi" class="form-control" value="<?php echo $deskripsi; ?>">
                            <span class="help-block"><?php echo $deskripsi_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="home.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>