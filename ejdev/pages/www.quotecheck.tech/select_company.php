
<?php
$docid = $_POST['docid'];
$sql = "SELECT col_text , x , y , id FROM qc_pr_wholesaler_doc_col WHERE fk_doc_id = ?";
$args = array("i", $docid);
$conn3 = new database();

if ($conn3->connect_error) {
} else if ($conn3->query($sql, $args)) {
    $wholesalerResults3 = $conn3->all();

    $row_count_for_foreach = 1;
    if (count($wholesalerResults3) >0) {

        //  $fk_job_id = $wholesalerResults2[0]['fk_doc_id'];
        //  $idcheck = $wholesalerResults2[0]['id'];


        // output data of each row
        //          while($row = $result->fetch_assoc()) {

        //               $fk_job_id = $row["fk_doc_id"];
        //               $idcheck = $row["id"];

        ///echo"blog_title: " . $row["blog_title"]. "picture_id:" . $row["picture_id"]. "blog_text:" . $row["blog_text"]. "author:" . $row["author"]. "<br>";
        ob_start();
        ?>

        <table style="width: 100%; background:#ededed;"> <!-- jack - can we show this background colour to fade in the lower td tags? -->

            <thead>
                <tr>
                <?php
                $col_count = 0;
                foreach ($wholesalerResults3 as $row) {
                    $col_count++;
                    $col_text = $row["col_text"];
                    $x = $row["x"];
                    $y = $row["y"];
                    $id = $row["id"];
                    $row_count_for_foreach++;
                    ?>

                    <th id="ID:<?php echo $id?> X:<?php echo  $x?> Y:<?php echo $y?>">
                        <?php echo "$col_text"?>
                    </th>

                    <?php
                }
                ?>
            </tr>
        </thead>

        <?php
        echo "<tr style='background: linear-gradient(#ededed, #fff);'> ";
//        for ($x = $col_count; $x >= 1; $x--) {
        for ($blankCellIdx = 0; $blankCellIdx < $col_count; $blankCellIdx++) {
            echo "<td style='border-bottom: 0px; height: 40px;'></td>";
        };
        echo "</tr>";
        ?>

        <tr>
        </tr>
    </table>

    <!--JACK: This is not the right place to style all table objects so can you make it more specific to the table being created - perhaps use a class-->
    <style>
    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
</style>
<?php

$mainHTML = ob_get_contents();
ob_end_clean();


$return['html3'] = $mainHTML;
$conn3 = null;
//
} else {


    $mainHTML = "<h4>No Column Headers Defined - Add a new Column Header</h4>";
    $return['html3'] = $mainHTML;
    $return['html4'] = $mainHTML;
}
} else {
    $return['ErrorStatus'] = "Error: " . $sql . "<br>" . $conn->error;
}









die(json_encode($return));

?>
