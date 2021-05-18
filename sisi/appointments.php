<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Appointments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Appointments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="12711";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$obj = (object)$_POST;

if(empty($obj->action)){

    $obj->fromdate=date("Y-m-d");
    $obj->todate=date("Y-m-d");

}

$delid=$_GET['delid'];
$appointments=new Appointments();
if(!empty($delid)){
	$appointments->id=$delid;
	$appointments->delete($appointments);
	redirect("appointments.php");
}
//Authorization.
$auth->roleid="12710";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<input class="btn btn-info" onclick="showPopWin('addappointments_proc.php',600,430);" value="NEW" type="button"/>
<?php }?>

<form action="appointments.php" method="post">
    <table class="table">
        <tr>
            <td>Status:</td>
            <td><select name="status">
                    <option value="">Select...</option>
                    <option value="0" <?php if($obj->status==0)echo "selected"; ?>>Not Done</option>
                    <option value="1" <?php if($obj->status==1)echo "selected"; ?>>Complete</option>
                    <option value="2" <?php if($obj->status==2)echo "selected"; ?>>Overdue</option>
                </select></td>
            <td>From Date:</td>
            <td><input type="text" name="fromdate" class="date_input" readonly value="<?php echo $obj->fromdate; ?>"/></td>
            <td>To Date:</td>
            <td><input type="text" name="todate" class="date_input" readonly value="<?php echo $obj->todate; ?>"/></td>
            <td><input type="submit" name="action" class="btn btn-info" value="Filter"/></td>
        </tr>
    </table>
</form>

<table style="clear:both;"  class="table display" width="100%" >
	<thead>
		<tr>
			<th>#</th>
<!-- 			<th>Appointment </th> -->
			<th>Interaction </th>
<!-- 			<th>Facility </th> -->
			<th>Person </th>
			<th>Speciality </th>
<!-- 			<th>Person Schedule </th> -->
			<th>Med Representative </th>
			<th>Appointment Date </th>
			<th style="min-width:300px;width:300px;">Action </th>
			<th style="min-width:300px;width:300px;">Re-Action </th>
			<th>Rating </th>
			<th style="min-width:300px;width:300px;">Follow Up </th>
			<th>Longitude </th>
			<th>Latitude </th>
			<th>Status </th>
			<th>Rescheduled </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="12712";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="12713";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="crm_appointments.id, crm_persons.id person, crm_appointments.appointmentid, crm_appointments.type, crm_specialitys.name specialityid, crm_facilitys.name as facilityid, crm_persons.name as personid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, crm_appointments.appointmentdate, crm_appointments.appointmenttime, crm_appointments.action, crm_appointments.reaction, crm_ratings.name as ratingid, crm_appointments.followup, crm_appointments.longitude, crm_appointments.latitude, crm_appointments.status, crm_appointments.rescheduled, crm_appointments.remarks, crm_appointments.ipaddress, crm_appointments.createdby, crm_appointments.createdon, crm_appointments.lasteditedby, crm_appointments.lasteditedon";
		$join=" left join crm_facilitys on crm_appointments.facilityid=crm_facilitys.id  left join crm_persons on crm_appointments.personid=crm_persons.id left join hrm_employees on crm_appointments.employeeid=hrm_employees.id  left join crm_ratings on crm_appointments.ratingid=crm_ratings.id left join crm_specialitys on crm_specialitys.id=crm_persons.specialityid ";
		$having="";
		$groupby="";
		$where=" where date(crm_appointments.appointmentdate)>='$obj->fromdate' and date(crm_appointments.appointmentdate)<='$obj->todate' ";
		if(!empty($obj->action)){
		
            $where.=" and crm_appointments.status='$obj->status' ";
		
		}
		$orderby=" order by id desc ";
		$appointments->retrieve($fields,$join,$where,$having,$groupby,$orderby); echo mysql_error();
		$res=$appointments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		$color="";
		if($row->appointmentdate<date("Y-m-d")){
            $color="red";
		}
		if($row->status==1){
            $color="green";
		}
		
	?>
		<tr style="color:<?php echo $color; ?>;">
			<td><?php echo $i; ?></td>
<!-- 			<td><?php echo $row->appointmentid; ?></td> -->
			<td><?php echo $row->type; ?></td>
<!-- 			<td><?php echo $row->facilityid; ?></td> -->
			<td><a href="../persons/addpersons_proc.php?id=<?php echo $row->person; ?>" target="_blank"><?php echo $row->personid; ?></a></td>
			<td><?php echo $row->specialityid; ?></td>
<!-- 			<td><?php echo $row->personscheduleid; ?></td> -->
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatDate($row->appointmentdate)." ".$row->appointmenttime; ?></td>
			<td><?php echo $row->action; ?></td>
			<td><?php echo $row->reaction; ?></td>
			<td><?php echo $row->ratingid; ?></td>
			<td><?php echo $row->followup; ?></td>
			<td><?php echo $row->longitude; ?></td>
			<td><?php echo $row->latitude; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->rescheduled; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="12712";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addappointments_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../images/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="12713";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='appointments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../images/trash.png' alt='delete' title='delete' /></a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
