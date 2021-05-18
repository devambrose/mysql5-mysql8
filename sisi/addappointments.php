<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
$pop=1;
include "../../../head.php";

?>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 } );
 </script>

   <form class="forms" id="theform" action="addappointments_proc.php" name="appointments" method="POST" enctype="multipart/form-data">
	  <table width="100%" class="table titems gridd">
   <?php if(!empty($obj->retrieve)){?>
	  <tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	  </tr>
	  <?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Appointment : </td>
		<td><input type="text" name="appointmentid" id="appointmentid" value="<?php echo $obj->appointmentid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Interaction Method : </td>
		<td>
			<input type="radio" name="type" id="type" value='remote' <?php if($obj->type=='remote'){echo"checked";}?>>Remote 
			<input type="radio" name="type" id="type" value='physical' <?php if($obj->type=='physical'){echo"checked";}?>>Physical 
		</td>
	</tr>
	<tr>
		<td align="right">Facility : </td>
			<td>         <select name="facilityid" class="selectbox">
            <option value="">Select...</option>
          <?php
          $facilitys=new Facilitys();
          $where="  ";
          $fields="crm_facilitys.id, crm_facilitys.name, crm_facilitys.subregionid, crm_facilitys.location, crm_facilitys.longitude, crm_facilitys.latitude, crm_facilitys.address, crm_facilitys.email, crm_facilitys.tel, crm_facilitys.facilitytypeid, crm_facilitys.keyaccounts, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)), crm_facilitys.customerid, crm_facilitys.remarks, crm_facilitys.ipaddress, crm_facilitys.createdby, crm_facilitys.createdon, crm_facilitys.lasteditedby, crm_facilitys.lasteditedon";
          $join="";
          $having="";
          $groupby="";
          $orderby="";
          $facilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

          while($rw=mysql_fetch_object($facilitys->result)){
          ?>
		          <option value="<?php echo $rw->id; ?>" <?php if($obj->facilityid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
          <?php
          }
          ?>
          </select>
		       </td>
	</tr>
	<tr>
		<td align="right">Person : </td>
			<td>         <select name="personid" class="selectbox">
            <option value="">Select...</option>
          <?php
          $persons=new Persons();
          $where="  ";
          $fields="crm_persons.id, crm_persons.name, crm_persons.titleid, crm_persons.positionid, crm_persons.cadreid, crm_persons.specialityid, crm_persons.classeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)), crm_persons.email, crm_persons.tel, crm_persons.remarks, crm_persons.ipaddress, crm_persons.createdby, crm_persons.createdon, crm_persons.lasteditedby, crm_persons.lasteditedon";
          $join="";
          $having="";
          $groupby="";
          $orderby="";
          $persons->retrieve($fields,$join,$where,$having,$groupby,$orderby);

          while($rw=mysql_fetch_object($persons->result)){
          ?>
		          <option value="<?php echo $rw->id; ?>" <?php if($obj->personid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
          <?php
          }
          ?>
          </select>
		       </td>
	</tr>
	<tr>
		<td align="right">Person Schedule : </td>
			<td>         <select name="personscheduleid" class="selectbox">
            <option value="">Select...</option>
          <?php
          $personshedules=new Personshedules();
          $where="  ";
          $fields="*";
          $join="";
          $having="";
          $groupby="";
          $orderby="";
          $personshedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);

          while($rw=mysql_fetch_object($personshedules->result)){
          ?>
		          <option value="<?php echo $rw->id; ?>" <?php if($obj->personscheduleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
          <?php
          }
          ?>
          </select>
		       </td>
	</tr>
	<tr>
		<td align="right">Med Representative : </td>
			<td>
			<?php
			$employees=new Employees();
            $where="  ";
            $fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname) name";
            $join="";
            $having="";
            $groupby="";
            $orderby="";
            $employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $employees->sql;echo mysql_error();
			?>
			<select name="employeeid" class="selectbox">
            <option value="">Select...</option>
          <?php    

          while($rw=mysql_fetch_object($employees->result)){
          ?>
		          <option value="<?php echo $rw->id; ?>" <?php if($obj->employeeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
          <?php
          }
          ?>
          </select>
		       </td>
	</tr>
	<tr>
		<td align="right">Appointment Date : </td>
		<td><input type="text" name="appointmentdate" id="appointmentdate" class="date_input" size="12" readonly  value="<?php echo $obj->appointmentdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Appointment Time : </td>
		<td><input type="text" name="appointmenttime" id="appointmenttime" value="<?php echo $obj->appointmenttime; ?>"></td>
	</tr>
	<tr>
		<td align="right">Action : </td>
		<td><textarea name="action"><?php echo $obj->action; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Re-Action : </td>
		<td><textarea name="reaction"><?php echo $obj->reaction; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Rating : </td>
			<td>         <select name="ratingid" class="selectbox">
            <option value="">Select...</option>
          <?php
          $ratings=new Ratings();
          $where="  ";
          $fields="          crm_ratings.id, crm_ratings.name, crm_ratings.remarks, crm_ratings.ipaddress, crm_ratings.createdby, crm_ratings.createdon, crm_ratings.lasteditedby, crm_ratings.lasteditedon";
          $join="";
          $having="";
          $groupby="";
          $orderby="";
          $ratings->retrieve($fields,$join,$where,$having,$groupby,$orderby);

          while($rw=mysql_fetch_object($ratings->result)){
          ?>
		          <option value="<?php echo $rw->id; ?>" <?php if($obj->ratingid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
          <?php
          }
          ?>
          </select>
		       </td>
	</tr>
	<tr>
		<td align="right">Follow Up : </td>
		<td><textarea name="followup"><?php echo $obj->followup; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Longitude : </td>
		<td><input type="text" name="longitude" id="longitude" value="<?php echo $obj->longitude; ?>"></td>
	</tr>
	<tr>
		<td align="right">Latitude : </td>
		<td><input type="text" name="latitude" id="latitude" value="<?php echo $obj->latitude; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><input type="text" name="status" id="status" value="<?php echo $obj->status; ?>"></td>
	</tr>
	<tr>
		<td align="right">Rescheduled : </td>
		<td><input type="text" name="rescheduled" id="rescheduled" value="<?php echo $obj->rescheduled; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
</table>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>
