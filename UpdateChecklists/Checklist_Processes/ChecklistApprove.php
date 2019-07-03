<?php require('../../Globals/init.php');

//get ID from Post request
$id = $_POST["cid"];
$version = $_POST["ver"];
$error='';
  $db = new Database;
//Get Checklist info

$query = "SELECT * FROM LogChecklist WHERE IDchecklist=" . $id. " AND Version=" . $version;
$data=Query($query,1);

//get last Draft Edit info

$query = "SELECT * FROM LogChecklistHistory WHERE IDchecklist=" . $id . " AND Version=" . $version . " AND Status='Draft' ORDER BY FileTime DESC LIMIT 1";
$draft = Query($query,1);
$lastEditBy = $draft->FileBy;
$lastEditTime = $draft->FileTime;


//TODO: Check user info
$user = getUser();

//Check missing info
if($id=='' || $version==''){
    $error = "Missing Information";
    echo $error;
}

// check status
if($data->Status != "Draft"){
    $error = "Invalid Status";
    echo $error;
}

if($error==null)
{
    if($version>1){
    //set previous Approved as Archived
    $previous = $version -1;
    $query = "UPDATE LogChecklist SET Status='Archived' WHERE IDchecklist=" . $id . " AND Version=" . $previous . " AND Status='Approved'";
    $db->query($query);
    $db->execute();
    
    //File History
    $HistoryFields = array(
        'IDchecklist'=> $id,
        'Version' => $previous,
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy'=> $user,
        'FileAction'=> "Marked as Archived",
        'Status' => "Archived");
        
    Create($HistoryFields,'LogChecklistHistory');
    }
    
    //set current Draft Version as Approved Checklist
    if($version>0){
           $query = "UPDATE LogChecklist SET Status='Approved' WHERE IDchecklist=" . $id . " AND Version=" . $version . " AND Status='Draft'";
    $db->query($query);
    $db->execute();
        
    //File History for current version
          $HistoryFields = array(
        'IDchecklist'=> $id,
        'Version' => $version,
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy'=> $user,
        'FileAction'=> "Marked as Approved",
        'Status' => "Approved");
        
    Create($HistoryFields,'LogChecklistHistory');
    }
    
    //get Approve data
    $query = "SELECT * FROM LogChecklistHistory WHERE IDchecklist=" . $id . " AND Version=" . $version . " AND Status='Approved' ORDER BY FileTime DESC LIMIT 1";
        $approve_data = Query($query,1);
    
    
    //send email
    if($_SERVER['SERVER_NAME']== "staff.meditech.com")
    {

        switch($data->ProdLine) {
         case 'FS':
            $to = strtolower($user).'@meditech.com, fs-checklist-backup-group@meditech.com';
            break;
         case 'M-AT':
         $to = strtolower($user).'@meditech.com, 6x-checklist-backup-group@meditech.com';
            break; 
        default:
        $to = strtolower($user).'@meditech.com, update-checklist-backup-group@meditech.com';
            break;
        }
     //   if($data->ProdLine =='FS'){
      //      $to = strtolower($user).'@meditech.com, fs-checklist-backup-group@meditech.com';
      //  }else {
      //      $to = strtolower($user).'@meditech.com, update-checklist-backup-group@meditech.com';

     //   }
    }else{
        $to = strtolower($user).'@meditech.com';
    }
    
    $headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';
$headers[] = "From: ".strtolower($user)."@meditech.com";
    $subject = "( CID: " . $id . " Version: " . $version . " ) ... ( " . $data->ProdLine . " - " . $data->System . " - " . $data->Process;
    if($data->Rel)
    {
        $subject.= " - ". $data->Rel;
    }
    if($data->Type){
        $subject.= " - " .$data->Type;
    }
    
    $subject.=" ) ... ( ". $data->Title . " )";
    
    //to check cc info
    
    $body = "<font color=Red>This is an emergency backup Checklist. Please ensure you are using the most recent backup as this version could be out-of-date.</font>
<br><br>
<b>CHECKLIST ID:</b> " . $id . "<br>
<b>VERSION:</b> " . $version . "<br>
<b>STATUS:</b>  Approved <br><br>
<b>LAST EDIT:</b> ". $lastEditBy . " @ " . $lastEditTime . "<br>
<b>APPROVED:</b> " . $approve_data->FileBy . " @ " . $approve_data->FileTime . "<br><br>
<b>TITLE:</b> " . $data->Title . "<br><br>
<b>PLATFORM:</b> " . $data->ProdLine . "<br>
<b>SYSTEM:</b> " . $data->System . "<br>
<b>PROCESS:</b> " . $data->Process . "<br>
<b>RELEASE:</b> " . $data->Rel . "<br>
<b>TYPE:</b> " . $data->Type . "<br><br>
<b>OBJECTIVE & SCOPE:</b> " . $data->Scope . "<br><br>";
    
//checklist Steps
$query = "SELECT * FROM LogChecklistSteps WHERE IDchecklist=" . $id . " AND Version=" . $version. " ORDER BY Step";
    $steps = Query($query);
    if(!$steps){
        $body .= "<table>
        <tr>
 <td colspan=3 align=center nowrap>There are no Steps found.</td>
 </tr>
        </table";
    }else{
        $body.= "<table border=0 align=center cellpadding=5 cellspacing=0>";
            foreach($steps as $step ){
                	$body.= "<tr>
    <td colspan=3 align=center nowrap><hr width='100%'></td>
	</tr>
	<tr>
    <td align=center valign=top><font face=Verdana size=5><b>" . $step->Step . "</b></font></td>
	<td width=50>&nbsp;</td>
	<td align=left><font face=Verdana>" . $step->StepText . "</font></td>
	</tr>";
            }
    }
        mail($to,$subject,$body,implode("\r\n",$headers));
    
}
header("Location: ../Checklist_views/ChecklistDetails.php?cid=".$id.'&Ver='.$version);
exit();
