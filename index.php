<?php
$koneksi    =mysqli_connect('localhost','root','','koala');
if (!$koneksi) {
    die("tidak dapat terkoneksi ke database");  
}

$nim      ="";
$nama     ="";
$jurusan  ="";
$sukses   ="";
$error    ="";


if(isset ($_GET['op'])){//untuk read data
    $op = $_GET['op'];
}else{
    $op = "";
}
if ($op == 'delete'){//untuk delete data
    $id     =$_GET['id'];
    $sql1   ="DELETE FROM siswa WHERE id = '$id'";
    $q1     =mysqli_query($koneksi,$sql1);
    if ($q1){
        $sukses ='Berhasil menghapus data';

    }else {
        $error ='Gagal menghapus data';
    }
}

if($op == 'edit'){//untuk edit data

    $id = $_GET['id'];
    $sql1 = "SELECT * FROM siswa WHERE id = '$id'";
    $q1             =mysqli_query($koneksi,$sql1);
    $r1             =mysqli_fetch_array($q1);   
    $nim          =$r1['nim'];
    $nama         =$r1['nama'];
    $jurusan      =$r1['jurusan'];

    if ($nim =='') {
        $error = 'data tidak ditemukan';
    }
}
if(isset ($_POST['simpan'])){ //untuk create
    $nim        =$_POST['nim'];
    $nama       =$_POST['nama'];
    $jurusan    =$_POST['jurusan'];
    if($nim && $nama && $jurusan){
        $q1 = mysqli_query($koneksi,"INSERT INTO siswa(nim,nama,jurusan) VALUES ('$nim','$nama', '$jurusan')");
        if ($q1){
            $sukses ="Berhasil memasukkan data baru";
        }else{
            $error  ="gagal memasukkan data";
        }
    }else{
        $error="Silahkan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        .mx-auto{
            width: 800px;
        }
        .card{
            margin-top:10px;
        }

    </style>
</head>
<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                create / edit data
            </div>
            
            <div class="card-body">
                <?php
                if($error){
                    ?>
                    <div class="alert alert-danger" role="alert">
                <?php echo $error ?>
            </div>
                        <?php
                }
                ?>
                <?php
                if($sukses){
                    ?>
                    <div class="alert alert-success" role="alert">
                <?php echo $sukses ?>
            </div>
                        <?php
                }
                ?>
                <form action="" method="POST">
                
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">Nim</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nim" id="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                        <div class="col-sm-10">
                           <select class="form-control" name="jurusan" id="jurusan">
                            <option value="">-Pilih jurusan</option>
                            <option value="Rpl" <?php if ($jurusan == "Rpl") echo "selected"?>>Rpl</option>
                            <option value="Bdp" <?php if ($jurusan == "Bdp") echo "selected"?>>Bdp</option>
                            <option value="Otkp"<?php if ($jurusan == "Otkp") echo "selected"?>>Otkp</option>
                            <option value="Upw"<?php if ($jurusan == "Upw") echo "selected"?>>Upw</option>
                           </select>
                        </div>
                    </div>
                    <div class="col-12"><input type="submit" name="simpan" value="kirim data" class="btn btn-primary"></div>
                </form>
            </div>
        </div>
        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Siswa
            </div> 
            
            
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nim</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        <tbody>
                            <?php
                            $q2     =mysqli_query($koneksi,"SELECT * FROM siswa");
                            $urut   =1;
                            while($r2 = mysqli_fetch_array($q2)){
                                $id          =$r2['id'];
                                $nim         =$r2['nim'];
                                $nama        =$r2['nama'];
                                $jurusan     =$r2['jurusan'];
                                ?>
                                <tr>
                                    <th scope='row'><?php echo $urut++?></th>
                                    <td scope='row'><?php echo $nim?></td>
                                    <td scope='row'><?php echo $nama?></td>
                                    <td scope='row'><?php echo $jurusan?></td>
                                    <td scope='row'><?php echo $nim?></td>
                                    <td scope='row'>
                                        <a href="index.php?op=edit&id= <?php echo $id?>"><button type="button" class="btn btn-outline-warning">Edit</button></a>
                                        <a href="index.php?op=delete&id=<?php echo $id?>" onclick ="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-outline-danger">Delete</button></a>
                                    
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
