<!DOCTYPE html>
<html>
<head>
    <?php
    include("../../../Resources/sessions.php");
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>Select Branch and Batch - Student Course | EGyaan</title>
    <script type="text/javascript" src="../../../Resources/jQuery/jquery-3.2.1.js"></script>

    <style>
        div.hide {
            display: none;
        }
    </style>

</head>
<body>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Select Course</li>
            </ol>
        </section>
        <section class="content">

            <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Select Course</h3>
                    </div>
                    <form role="form" action="editDeleteCourse.php" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <select id="branch-id" name="branchId" class="form-control">
                                    <option value="-2">Select Branch</option>
                                    <?php
                                    /**
                                     * Created by PhpStorm.
                                     * User: fireion
                                     * Date: 20/6/17
                                     * Time: 1:17 PM
                                     */
                                    require_once("../../../classes/Constants.php");
                                    require_once("../../../classes/DBConnect.php");
                                    require_once("../../manage_branch/classes/Branch.php");
                                    require_once("../../manage_batch/classes/Batch.php");

                                    $dbConnect = new DBConnect(Constants::SERVER_NAME,
                                        Constants::DB_USERNAME,
                                        Constants::DB_PASSWORD,
                                        Constants::DB_NAME);

                                    $branch = new Branch($dbConnect->getInstance());
                                    $batch = new Batch($dbConnect->getInstance());

                                    $getBranchData = $branch->getBranch(0);
                                    if ($getBranchData != null) {
                                        while ($row = $getBranchData->fetch_assoc()) {
                                            $branchId = $row['id'];
                                            $branchName = $row['name'];

                                            echo "<option value='" . $branchId . "'>" . $branchName . "</option>";
                                        }
                                    } else {
                                        echo Constants::STATUS_FAILED;
                                    }
                                    ?>

                                </select>
                            </div>
                            <div id="new-drop-down" class="hide">
                                <div class="form-group">
                                    <select name="batchId" id="batch-id" class="form-control">
                                        <!--            <option value="-3">Select Batch</option>-->
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" value="Submit"><i class="fa fa-check"></i>&nbspSubmit
                            </button>
                        </div>
                    </form>
                </div>
        </section>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#branch-id").change(function () {
            var branchId = $("#branch-id option:selected").val();
            if (branchId < 0) {
                alert("Select Valid Branch");
                $("#new-drop-down").hide();
            } else {
                $("#new-drop-down").show();
                $.ajax(
                    {
                        type: "POST",
                        url: "get_batch_jquery.php",
                        data: "branchId=" + branchId,
//                        dataType: "json",
                        success: function (json) {
                            console.log(json);
                            $("div#new-drop-down").removeClass("hide");
                            $("#batch-id").empty();
                            $("#batch-id").append("<option value='-3'>Select Batch</option>");
                            var parsed = jQuery.parseJSON(json);
                            for (var i = 0; i < parsed.batchId.length; i++) {
                                var batchId = parsed.batchId[i];
                                var batchName = parsed.batchName[i];
                                $("#batch-id").append("<option value='" + batchId + "'>" + batchName + "</option>");
                            }
                        },
                        error: function (a, b, c) {
                            console.log("Error");
                        }
                    });
            }
        });
    });
</script>
<?php
include "../../../Resources/Dashboard/footer.php";
?>


</body>
</html>
