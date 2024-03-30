<?php
include("php/dbconnect.php");

if (isset($_POST['req']) && $_POST['req'] == '1') {
  $sid = isset($_POST['student']) ? mysqli_real_escape_string($conn, $_POST['student']) : '';
  $sql = "SELECT paid, submitdate, transcation_remark FROM fees_transaction WHERE stdid = '".$sid."'";
  $fq = $conn->query($sql);
  if ($fq->num_rows > 0) {
      $sql = "SELECT s.id, s.sname, s.balance, s.fees, s.contact, s.course, s.joindate FROM student AS s where  s.id = '".$sid."'";
      $sq = $conn->query($sql);

      // Check if the query returned a valid result
      if ($sq && $sq->num_rows > 0) {
          $sr = $sq->fetch_assoc();

          echo '
<h4>Student Info</h4>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th>Full Name</th>
<td>'.$sr['sname'].'</td>
<th>Course</th>
<td>'.$sr['course'].'</td>
</tr>
<tr>
<th>Contact</th>
<td>'.$sr['contact'].'</td>
<th>Joined On</th>
<td>'.date("d-m-Y", strtotime($sr['joindate'])).'</td>
</tr>
</table>
</div>';

          echo '
<h4>Fee Info</h4>
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Date</th>
      <th>Paid</th>
      <th>Remarks</th>
    </tr>
  </thead>
  <tbody>';
          $totapaid = 0;
          while ($res = $fq->fetch_assoc()) {
              $totapaid += $res['paid'];
              echo '<tr>
      <td>'.date("d-m-Y", strtotime($res['submitdate'])).'</td>
      <td>'.$res['paid'].'</td>
      <td>'.$res['transcation_remark'].'</td>
    </tr>';
          }

          echo '	  
  </tbody>
</table>
</div> 

<table style="width:150px;" >
<tr>
<th>Total Fees: 
</th>
<td>'.'Rs. '.$sr['fees'].'
</td>
</tr>

<tr>
<th>Total Paid: 
</th>
<td>'.'Rs. '.$totapaid.'
</td>
</tr>

<tr>
<th>Balance: 
</th>
<td>'.'Rs. '.$sr['balance'].'
</td>
</tr>
</table>
';
      } else {
          echo 'No student information found.';
      }
  } else {
      echo 'No fees submitted.';
  }
}

?>