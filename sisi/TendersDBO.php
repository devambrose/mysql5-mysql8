<?php 
require_once("../../../DB.php");
class TendersDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="tender_tenders";

	function persist($obj){
		$sql="insert into tender_tenders(id,proposalno,facilityid,name,tendertypeid,datereceived,actionplandate,dateofreview,dateofsubmission,employeeid,statusid,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->proposalno',$obj->facilityid,'$obj->name',$obj->tendertypeid,'$obj->datereceived','$obj->actionplandate','$obj->dateofreview','$obj->dateofsubmission',$obj->employeeid,$obj->statusid,'$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update tender_tenders set proposalno='$obj->proposalno',facilityid=$obj->facilityid,name='$obj->name',tendertypeid=$obj->tendertypeid,datereceived='$obj->datereceived',actionplandate='$obj->actionplandate',dateofreview='$obj->dateofreview',dateofsubmission='$obj->dateofsubmission',employeeid=$obj->employeeid,statusid=$obj->statusid,remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from tender_tenders $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from tender_tenders $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

