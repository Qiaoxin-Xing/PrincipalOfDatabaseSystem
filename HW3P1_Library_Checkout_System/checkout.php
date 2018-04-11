<h2>Check Out Details</h2>
<table class="sortable" border="2" cellspacing="2" cellpadding="2">
	<tr>
		<th> BookId </th>
		<th> BookTitle </th>
		<th> Author </th>
		<th> CopyId </th>
        <th> CheckeoutDate </th>
		<th> DueDate </th>
		<th> Status </th>
		<th> Mname </th>
        <th> Mid </th>
	</tr>

<?php
    session_start();
    $memberid = $_SESSION['memberId'];
    
    //database connection
    $host = "localhost";
    $user = "root";
    $pass = "1111";
    $db = "hw3p1";
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_errno) die("Database Connection Failed: ".$db->connect_error);
    
    //check out selected book or echo notice if no book is selected.
    if (sizeof($_POST) == 0) {
        echo "No book is selected to check out with.<br>";
    } else {
    $selection = explode ('|', $_POST['selection']);
    $bookid = $selection[0];
    $booktitle = $selection[1];
    
    //choose one bookcopy
    $get_copy_id = "select copyid from bookcopy where bookid = '$bookid' and copyid not in (select copyid from checkedout where status = 'Holding' or status = 'Overdue') limit 1";
    $copyid_array = $conn->query($get_copy_id)->fetch_assoc();
    $copyid = $copyid_array['copyid'];
    
    $execute_checkout = "insert into checkedout(copyid, mid, checkoutdate, duedate, status) value('$copyid', '$memberid', curdate(), adddate(curdate(), interval 3 month), 'Holding')";
    
    $conn->query($execute_checkout);
	
    echo "Successfully checked out book: $booktitle. Copy id is $copyid <br>";
    }
    
    echo "<br>Current check out status of member id $memberid:<br>";
    
    //display current check out status
    $current_checked_books = "select bookid, booktitle, author, copyid, checkoutdate, duedate, status,mname, mid from  checkedout natural join bookcopy natural join book natural join member where mid = '$memberid' and status <> 'Returned'";   
    $result = $conn->query($current_checked_books);
    if (!$result) {
    throw new Exception("Database Error");
    }
	while ( $row = $result->fetch_assoc() ) {
		$bookid = $row['bookid'];
		$booktitle = $row['booktitle'];
		$author = $row['author'];
		$copyid = $row['copyid'];
        $checkoutDate = $row['checkoutdate'];
		$dueDate = $row['duedate'];
		$status = $row['status'];
		$mname = $row['mname'];
        $mid = $row['mid'];
?>

<tr>
	<td> <?php echo $bookid;?> </td>
	<td> <?php echo $booktitle;?> </td>
	<td> <?php echo $author;?> </td>
	<td> <?php echo $copyid;?> </td>
    <td> <?php echo $checkoutDate;?> </td>
	<td> <?php echo $dueDate;?> </td>
	<td> <?php echo $status;?> </td>
	<td> <?php echo $mname;?> </td>
    <td> <?php echo $mid;?> </td>
</tr>	

<?php
	}
	echo "</table>";
	$result->free();
	$conn->close();
?>