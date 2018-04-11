<!DOCTYPE html>
<html>
<head>
<title>Books Search Result</title>
<style>th, td { border: 1px solid black; }</style>
</head>
<body>
    
<?php
session_start();
error_reporting(E_ALL);

$keyword = htmlspecialchars($_POST['keyWord']);
$_SESSION['memberId'] = htmlspecialchars($_POST['memberId']);
$memberid = $_SESSION['memberId'];
    
$valid_member = "select * from member where mid = '$memberid'";

    
$host = "localhost";
$user = "root";
$password = "1111";
$db = "hw3p1";
$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$member_check = $conn->query($valid_member);
$member_check_result = $member_check -> fetch_assoc();

if (is_null($member_check_result)) {
    echo "Invalid member";
} else {
    $search_keyword_query = "select distinct bookid, booktitle, category, author, publishdate, count(bookcopy.copyid) from bookcopy left join checkedout on bookcopy.copyid = checkedout.copyid natural join book where bookcopy.copyid not in (select copyid from checkedout where status = 'Holding' or status = 'Overdue') and (booktitle like '%$keyword%' or category like '%$keyword%') group by bookid";
    
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($search_keyword_query)) {
        echo "Failed to prepare. <br/>";
    }
    else {
        $stmt->execute();
        $stmt->bind_result($bookid, $booktitle, $category, $author, $publishdate,$in_stock);
        echo "Books available with keyword: $keyword";
        echo "<form name='target books available with keyword: $keyword' action='checkout.php' method='post'/>
        <table>
        <tr>
            <th>BookId</th>
            <th>BookTitle</th>
            <th>Category</th>
            <th>Author</th>
            <th>PublishDate</th>
            <th>InStock</th>
            <th>Select</th>
        </tr>";
        while($stmt->fetch()) {
            $sendstr = $bookid . '|' . $booktitle;  
            echo   "<tr><td> $bookid
                   </td><td> $booktitle
                   </td><td> $category
                   </td><td> $author
                   </td><td> $publishdate
                   </td><td> $in_stock
                   </td><td> <input type='radio' name='selection' value='$sendstr'/>
                   </td></tr>";
        }
        echo "</table>
        <input type='submit' value='Check Out'/>";
    }
}
$conn->close();

?>
</body>
</html>