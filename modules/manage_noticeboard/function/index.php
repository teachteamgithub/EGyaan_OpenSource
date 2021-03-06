<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
    
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Noticeboard.php");
require_once("../../manage_branch/classes/Branch.php");
require_once("../../manage_course/classes/Course.php");
    
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$user_id=$id;
// $email="badalkotak@gmail.com";
//$role_id=7;
//student

//select branch_id from egn_batch where id in (select batch_id from egn_student where email="badalkotak@gmail.com")
?>
    
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>Noticeboard</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <h2 class="page-header">Notice</h2>
<!--------------------------------------------------------------------------------------------------------------------------->
            <?php
            if($role_id==Constants::ROLE_STUDENT_ID)
            {
                $noticeboard = new Noticeboard($dbConnect->getInstance());
                $selectData=$noticeboard->getNested2("egn_batch","egn_student","branch_id",1,1,1,1,"id","batch_id",1,1,"email",$email);
                if($selectData!=null)
                {
            ?>
<!--------------------------------------------------------------------------------------------------------------------------->
            <div class="row"><!--start of row1-->
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Branch Student</h3>
                        </div>
                        <div class="box-body">
                            <div class="box-group" id="accordion">
<!--------------------------------------------------------------------------------------------------------------------------->
                    <?php
                    while($row=$selectData->fetch_assoc())
                    {
                        $student_branch=$row['branch_id'];
                        $var1="type";
                        $var2=1;
                        $var3=1;
                        $urgent=1;
                        $id=1;
                        $selData=$noticeboard->getNoticeboard($var1,$student_branch,$var2,$urgent,$var3,$id);
                        if($selData!=null)
                        {
                            while($row=$selData->fetch_assoc())
                            {
                                $title=$row['title'];
                                $notice=$row['notice'];
                                $id=$row['id'];
                                $file=$row['file'];
                                $urgent=$row['urgent_notice'];
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->
                                <div class="panel box box-primary">
                                    <div class="box-header with-border">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Title :
<!--------------------------------------------------------------------------------------------------------------------------->         
                                <?php
                                echo $title;
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->
                                                </h4>
                                            </div>    
<!--------------------------------------------------------------------------------------------------------------------------->           
                                <?php
                                //echo '<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id>read more..</button> </a>';
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->
                                            <div class="col-md-6">
<!--------------------------------------------------------------------------------------------------------------------------->   
                                <?php
                                echo "<a data-toggle='collapse' data-parent='#accordion' href='#notice".$id."'><button type='button' class='btn btn-default btn-sm'>Read More <span class='fa fa-ellipsis-h'></span></button></a>&nbsp;";
                                if($file!=null)
                                {
                                    echo "<a href=".$file." class='btn btn-default btn-sm'>
                                    <i class='fa fa-paperclip'></i> Attached Notice</a>&nbsp;";
                                }
                                if($urgent=="u")
                                {
                                    echo '<h4 class="alert-message"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';
                                }
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->           
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="notice<?php echo $id ?>" class="panel-collapse collapse out">
                                                <div class="box-body">
<!--------------------------------------------------------------------------------------------------------------------------->           
                                    <?php
                                    echo'<h4>Description :</h4><p class="text-justify">'.$notice.'</p>';
                                    ?>
<!--------------------------------------------------------------------------------------------------------------------------->           
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--------------------------------------------------------------------------------------------------------------------------->           
                            <?php
                            }	
                        }
                        else
                        {
							echo '<h5>No Branch Notice!</h5>';
                        }	  
                    }
                    ?>
<!--------------------------------------------------------------------------------------------------------------------------->           
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end of row1-->
<!--000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000-->
            <?php
                }
                else
                {
                    $student_branch="";
				}
			}
			else if($role_id==Constants::ROLE_TEACHER_ID)
            {
                //select branch_id from egn_batch where id in (select batch_id from egn_course WHERE id in (select course_id from egn_teacher_course where user_id=3))
                //$sql="Select * from $table1 where $var1=$value1 and $var2=$value2 and  $var3 in ( select $value3 from $table 2 where $var4=$value4 and $var5=$value5 and $var6 in (select $value6 from $table3 where $var7=$value7 and $var8=$value8 ))"
                $course = new Course($dbConnect->getInstance());
                $branchData=$course->getCourse("yes", $user_id, 'no',0, 0,null,0);
				if($branchData!=null)
				{
            ?>
<!--------------------------------------------------------------------------------------------------------------------------->			
            <h2 class="page-header">Teacher Branch</h2>
<!--------------------------------------------------------------------------------------------------------------------------->
                    <?php
                    while($row=$branchData->fetch_assoc())
					{
						$teacher_branch=$row['branchId'];
						$teacher_branch_name=$row['branchName'];
                        ?>
<!--------------------------------------------------------------------------------------------------------------------------->            
            <div class="row"><!--start of row4-->
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
<!--------------------------------------------------------------------------------------------------------------------------->                                                      <?php
								echo"<h3 class='box-title'>".$teacher_branch_name."</h3>";
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->                     
                        </div>
                        <div class="box-body">
                            <div class="box-group" id="accordion">
<!--------------------------------------------------------------------------------------------------------------------------->                                             <?php
						$var1="type";
						$var2=1;
						$var3=1;
						$urgent=1;
						$id=1;
						$noticeboard = new Noticeboard($dbConnect->getInstance());
						$selectData=$noticeboard->getNoticeboard($var1,$teacher_branch,$var2,$urgent,$var3,$id);
						if($selectData)
						{
							while($row=$selectData->fetch_assoc())
							{
								$title=$row['title'];
								$notice=$row['notice'];
								$id=$row['id'];
								$file=$row['file'];
								$urgent=$row['urgent_notice'];
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->           
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Title :
<!--------------------------------------------------------------------------------------------------------------------------->           
                                <?php
                                echo $title.$id;
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->			
                                                    </h4>
                                                </div>
                                                <div class="col-md-6">
<!--------------------------------------------------------------------------------------------------------------------------->		
                            <?php
                                //echo '<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read     more..</button> </a>';
                                echo "<a data-toggle='collapse' data-parent='#accordion' href='#notice".$id."'><button type='button' class='btn btn-default btn-box-tool' data-widget='collapse'>Read 
                                more <span class='fa fa-ellipsis-h'></span>
                                </button></a>&nbsp;";
                                if($file!=null)
                                {
                                    echo "<a href=".$file." class='btn btn-default btn-box-tool'>
                                    <i class='fa fa-paperclip'></i> Attached Notice</a>";
                                }
                                if($urgent=="u")
                                {
                                    echo '<h4 class="alert-message pull-right"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';
                                }
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->                     
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="notice<?php echo $id ?>" class="panel-collapse collapse out">
                                                <div class="box-body">
<!--------------------------------------------------------------------------------------------------------------------------->                                                     <?php
                                echo'<h4>Description :</h4><p class="text-justify">'.$notice.'</p>';
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->                     
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--------------------------------------------------------------------------------------------------------------------------->                                                  <?php
                            }  
                        }
								else
                                {
									echo "<h5>No Branch Notice!</h5>";
								}
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end of row3-->
<!--------------------------------------------------------------------------------------------------------------------------->                                                  <?php
							}
						}
						else{
							$teacher_branch="";
						}
					}
					else if($role_id==Constants::ROLE_ADMIN_ID)
                    {
						$branch = new Branch($dbConnect->getInstance());
						$branchData=$branch->getBranch(0);
						if($branchData!=null)
						{
            ?>
<!--000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000-->					
            <h2 class="page-header">Admin Branch</h2>
<!--------------------------------------------------------------------------------------------------------------------------->
            <?php
							while($row=$branchData->fetch_assoc())
							{	
								$teacher_branch=$row['id'];
								$teacher_branch_name=$row['name'];
                                ?>
<!---------------------------------------------------------------------------------------------------------------------------> 
            <div class="row"><!--start of row4-->
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                                <?php
								echo"<h3 class='box-title'>".$teacher_branch_name."</h3>";
                                ?>
                        </div>
                        <div class="box-body">
                            <div class="box-group" id="accordion">
<!--------------------------------------------------------------------------------------------------------------------------->                                <?php
								$var1="type";
								$var2=1;
								$var3=1;
								$urgent=1;
								$id=1;
								$noticeboard = new Noticeboard($dbConnect->getInstance());
								$selectData=$noticeboard->getNoticeboard($var1,$teacher_branch,$var2,$urgent,$var3,$id);
								if($selectData)
								{
									while($row=$selectData->fetch_assoc())
									{
										$title=$row['title'];
										$notice=$row['notice'];
										$id=$row['id'];
										$file=$row['file'];
										$urgent=$row['urgent_notice'];
			?>
<!--------------------------------------------------------------------------------------------------------------------------->
                                <div class="panel box box-primary">
                                    <div class="box-header with-border">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Title :
<!--------------------------------------------------------------------------------------------------------------------------->			<?php
												echo $title;
			?>
<!--------------------------------------------------------------------------------------------------------------------------->					
                                                </h4>
                                            </div>
                                            <div class="col-md-6">
<!--------------------------------------------------------------------------------------------------------------------------->			<?php
//												echo'
//												<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id                                                    >read more..</button> </a>';
                                        
                                                echo "<a data-toggle='collapse' data-parent='#accordion' href='#notice".$id."'><button type='button' class='btn btn-default btn-box-tool' data-widget='collapse'>Read More <span class='fa fa-ellipsis-h'></span></button></a>&nbsp;";
												echo'<a href="delete_noticeboard.php?delete='.$id.'" onclick=del_confirm()><button type=button name=delete id=delete  class="btn btn-default btn-box-tool btn-sm"><span class="fa fa-trash"></span>Delete</button></a>&nbsp;';
												if($file!=null)
												{
													echo "<a href=".$file." class='btn btn-default btn-box-tool'>
                                                    <i class='fa fa-paperclip'></i> Attached Notice</a>";
												}
												if($urgent=="u"){
													echo '<h4 class="alert-message pull-right"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';
												}
                                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->                     
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="notice<?php echo $id ?>" class="panel-collapse collapse out">
                                                <div class="box-body">
<!--------------------------------------------------------------------------------------------------------------------------->                                                                  <?php
                                            echo'<h4>Description :</h4><p class="text-justify">'.$notice.'</p>';
                                            ?>
<!--------------------------------------------------------------------------------------------------------------------------->                     
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--------------------------------------------------------------------------------------------------------------------------->                                            <?php
                                            }	
										}
										else{
											echo "<h5>No Branch Notice!</h5>";
										}
                                        ?>
<!--------------------------------------------------------------------------------------------------------------------------->
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end of row4-->
<!--------------------------------------------------------------------------------------------------------------------------->                                    <?php
									}
								}
								else{
									$teacher_branch="";
								}
							}
			?>
<!--000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000-->	
                            <div class="row"><!--start of row5-->
                                <div class="col-md-12">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Common Notice</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="box-group" id="accordion">
                        	<?php
							$var1="type";
							$var2=1;
							$var3=1;
							$type="c";
							$urgent=1;
							$id=1;
                                                
							$noticeboard = new Noticeboard($dbConnect->getInstance());
							$selectData=$noticeboard->getNoticeboard($var1,$type,$var2,$urgent,$var3,$id);
							if($selectData)
                            {
								while($row=$selectData->fetch_assoc())
								{
									$title=$row['title'];
									$notice=$row['notice'];
									$id=$row['id'];
									$file=$row['file'];
									$urgent=$row['urgent_notice'];
			?>
<!--------------------------------------------------------------------------------------------------------------------------->   
                                                <div class="panel box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h4>Title :
<!--------------------------------------------------------------------------------------------------------------------------->			<?php
											echo $title;
			?>
<!---------------------------------------------------------------------------------------------------------------------------> 
                                                                </h4>
                                                            </div>
                                                            <div class="col-md-6">
<!--------------------------------------------------------------------------------------------------------------------------->			<?php
//											echo'
//											<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id                                                             >read more..</button> </a>';
                                            echo "<a data-toggle='collapse' data-parent='#accordion' href='#notice".$id."'><button type='button' class='btn btn-default btn-box-tool' data-widget='collapse'>Read More <span class='fa fa-ellipsis-h'></span>
                                            </button></a>&nbsp;";
											if($role_id==Constants::ROLE_ADMIN_ID){
												echo'<a href="delete_noticeboard.php?delete='.$id.'" onclick=del_confirm()><button type=button name=delete id=delete class="btn btn-default btn-box-tool btn-sm"><span class="fa fa-trash"></span> Delete</button> </a>';
											}
											if($file!=null)
											{
												echo "<a href=$file class='btn btn-default btn-box-tool'>
                                                <i class='fa fa-paperclip'></i> Attached Notice</a>";
											}
											if($urgent=="u"){
												echo '<h4 class="alert-message pull-right"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';   
											}
                                            ?>
<!--------------------------------------------------------------------------------------------------------------------------->                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="notice<?php echo $id ?>" class="panel-collapse collapse out">
                                                                <div class="box-body">
<!--------------------------------------------------------------------------------------------------------------------------->                                                  <?php
                                                echo'<h4>Description :</h4><p class="text-justify">'.$notice.'</p>';
                                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
<!--------------------------------------------------------------------------------------------------------------------------->                                        <?php
										}
									}
									else{
										echo "<h5>No Common Notice!</h5>";
									}
			?> 
<!--------------------------------------------------------------------------------------------------------------------------->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end of row5-->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php
    include("../../../Resources/Dashboard/footer.php");
?>
    </body>
</html>
