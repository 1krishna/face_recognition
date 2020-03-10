<form action="students.php" method="post">
    Period: <input type="text" name="dvr" id="dvr">
    <input type="submit" name="down" value="Download Attendance">
    <input type="submit" name="clear" value="reset" >
    
    </form>


<?php
$conn = mysqli_connect("localhost", 'root', '', 'face_recognition');

$q = "SELECT * from student where status=1";
$res = mysqli_query($conn, $q);
?>
<h4 style="color: green">
    <?php if(isset($_GET['reset'])){
        echo "ATTENDANCE RESET";
    }
    ?>
</h4>
<table border=1>
    <thead>
        <th>Roll Number</th>
        <th>Name</th>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
            <td>".$row['roll_no']."</td><td>".$row['name']."</td><tr>";
        }
        ?>
    </tbody>
</table>
<?php
if (isset($_POST['down'])) {
?>
    <div style="text-align:center">
        <a type="button" class="btn btn-primary" href="<?php echo $_POST['dvr'] . '.csv'; ?>" target='_blank'>Download</a>
    </div>
<?php
    $q = "SELECT * from student where status=1";
    $res = mysqli_query($conn, $q);

    $fp = fopen($_POST['dvr'] . ".csv", 'w');
    fwrite($fp, 'Roll Number,' . 'Name' . "\n");
    while ($row = mysqli_fetch_assoc($res)) {
        echo $row['name'];
        echo $row['roll_no'];
        fwrite($fp, $row['roll_no'] . ',');
        fwrite($fp, $row['name'] . ',');
        fwrite($fp, "\n");
    }
}
?>


<?php  
if (isset($_POST['clear'])){
    $u="UPDATE student set status=0";
    $t=mysqli_query($conn,$u);
    if($t){
        header('Location: students.php?reset');
    }
}