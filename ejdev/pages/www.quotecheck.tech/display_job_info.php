
<?php
function display_job_info() {
    $return = array();
    $return['ErrorStatus'] = "0";
    $return['html'] = "";

    $jobid = $_POST['jobid'];
    $fk_user_id = $_SESSION['user']['id'];

    //add new job to the DB. Check for duplicates here and return error if necessary
    $sql = "SELECT job_name FROM qc_pr_job_names WHERE fk_user_id = ? AND id = ?";
    $args = array("ii", $fk_user_id, $jobid);
    $conn = new database();

    if ($conn->connect_error) {
        $return = "Connection failed: " . $conn->connect_error;
    } else if ($conn->query($sql, $args)) {

        $jobResults = $conn->all();
        if (count($jobResults) >0) {

            ob_start();
            ?>
            <section id="content <?php echo"$job_name"?>" style="margin-bottom: 0px;">
                <div class="content-wrap">
                    <div class="container clearfix">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- <h2>Job Name:
                                    <?php //echo "$job_name"?>
                                </h2> -->
                            </div>
                        </div>
                        <div id="jobquotes" class="container">
                            <h2>Quotes</h2>
<!-- quotes listed here -->
                        </div>
                        <div id="jobinvoices" class="container">
                            <h2>Invoices</h2>
<!-- invoices listed here -->
                        </div>
                    </div>
                </div>
            </section>
            <?php
            $mainHTML = ob_get_contents();
            ob_end_clean();

            $return['html'] = $mainHTML;

        } else {
            $mainHTML = "<h3>No Files Uploaded</h3>";
            $return['html'] = $mainHTML;

        }
    } else {
        $return['ErrorStatus'] = "Error: " . $sql . "<br>" . $conn->error;
    }

    die(json_encode($return));
}
?>
