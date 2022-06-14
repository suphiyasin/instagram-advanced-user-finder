   <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Zexen</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Suphi</h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
					 <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Toplama</a>
						     <div class="dropdown-menu bg-transparent border-0">
<?php
include("sis.php");
$so = mysqli_query($mysqli, "select * from menu where MenuCat='0'");
while($es=mysqli_fetch_object($so)){  
?>       
		 <a href="<?php echo $es->MenuLink ?>" class="dropdown-item""><i class="fa fa-th me-2"></i><?php echo $es->MenuAdi ?></a>
		 <?php
}
?>
						   </div>
						   </div>
						   
						   		 <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Tarama</a>
						     <div class="dropdown-menu bg-transparent border-0">
<?php
include("sis.php");
$so = mysqli_query($mysqli, "select * from menu where MenuCat='1'");
while($es=mysqli_fetch_object($so)){  
?>       
		 <a href="<?php echo $es->MenuLink ?>" class="dropdown-item""><i class="fa fa-th me-2"></i><?php echo $es->MenuAdi ?></a>
		 <?php
}
?>
						   </div>
						   </div>
						   
						   	   		 <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Basma</a>
						     <div class="dropdown-menu bg-transparent border-0">
<?php
include("sis.php");
$so = mysqli_query($mysqli, "select * from menu where MenuCat='2'");
while($es=mysqli_fetch_object($so)){  
?>       
		 <a href="<?php echo $es->MenuLink ?>" class="dropdown-item""><i class="fa fa-th me-2"></i><?php echo $es->MenuAdi ?></a>
		 <?php
}
?>
						   </div>
						   </div>
						   
						    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Domain İşlemleri</a>
						     <div class="dropdown-menu bg-transparent border-0">
<?php
include("sis.php");
$so = mysqli_query($mysqli, "select * from menu where MenuCat='3'");
while($es=mysqli_fetch_object($so)){  
?>       
		 <a href="<?php echo $es->MenuLink ?>" class="dropdown-item""><i class="fa fa-th me-2"></i><?php echo $es->MenuAdi ?></a>
		 <?php
}
?>
						   </div>
						   </div>
						   
						   
						   
						   
						<?php
include("sis.php");
$so = mysqli_query($mysqli, "select * from menu where MenuCat='x'");
while($es=mysqli_fetch_object($so)){  
?>       
		 <a href="<?php echo $es->MenuLink ?>" class="nav-item nav-link""><i class="fa fa-th me-2"></i><?php echo $es->MenuAdi ?></a>
		 <?php
}
?>
                  
                </div>
            </nav>
        </div>