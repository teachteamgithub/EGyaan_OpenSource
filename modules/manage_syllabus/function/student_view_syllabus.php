<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Syllabus.php");
require_once("../../manage_course/classes/Course.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$user_id=$_SESSION["id"];
$syllabus=new Syllabus($dbconnect->getInstance());
$course=new Course($dbconnect->getInstance());
$courses_result=$course->getCourse('no',$user_id,'no',0,0,null,0);
?>

<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>List Of Syllabus</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">List Of Syllabus:</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Course</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($courses_result!=null)
                                    {
                                        while($rowCourses=$courses_result->fetch_assoc())
                                        {
                                            $result=$syllabus->getSyllabus($rowCourses['course_id']);
                                            if($result!=null)
                                            {	
                                                $no=1;
                                                while($row=$result->fetch_assoc())
                                                {
                                                    echo '<tr><td>'.$no.'</td><td>'.$rowCourses['name'].'</td>';
                                                    echo '<td><a href='.$row['file'].'><span class="fa fa-file-pdf-o fa-lg "></span></a></td>';
                                                    echo '</tr>';
                                                    $no=$no+1;
                                                }
                                            }
                                        }	
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!--end of Table box-->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<?php
    include("../../../Resources/Dashboard/footer.php");
?>
    </body>
</html>
