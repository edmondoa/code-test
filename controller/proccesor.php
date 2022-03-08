<?php
require ('connection.php');
require ('dbo.php');
$pdo = (new SqliteConnect())->connect();
$db = new DBProcess($pdo);
$action = $_POST['action'];

switch($action){
    case 'displayList':
        $datas = $db->getTask(null,$_POST);
        $view = buildView($datas['tasks']);
        echo  json_encode(['tasks'=>$view,'total'=>$datas['total'],'completed' => $datas['completed']]);
        break;
    case 'addTask':
        $db->insertTask($_POST);
        break;
    case 'markComplete':
        $data = ['status' => 'Complete','completed_date' => date('Y-m-d H:i')];
        $db->markComplete($_POST['id'],$data);
        break;
    case 'delete':
        $db->delete($_POST['id']);
        break;
    case 'view':
        echo json_encode($db->getTask($_POST['id'],null));
        break;
    case 'updateTask':
        $db->updateTask($_POST);
        break;
    default:
        break;

}
/**
 * buildView, build table content 
 * @param Array data
 * @return String
 */
function buildView($datas){
    $strbuiler = "";
    foreach($datas as $data){
        $strbuiler.= "<tr>";
        $strbuiler.= "<td>{$data['id']}</td>";
        $strbuiler.= "<td>{$data['task_name']}</td>";
        $strbuiler.= "<td>".alertLabel($data)."</td>";
        $strbuiler.= "<td>".priorityMapping($data['priority'])."</td>";
        $strbuiler.= "<td>{$data['created']}</td>";
        $strbuiler.= "<td>".actions($data['id'])."</td>";
        $strbuiler.= "</tr>";
    }
    return $strbuiler;
}

/**
 * Map priority code to Text 
 * @param int priorityCode
 * @return String
 */
function priorityMapping($priorityCode){
    $map = [1 => 'Critical',2=>'Major',3=>'Medium',4=>'Low'];
    return $map[$priorityCode];
}

/**
 * Build action buttons
 * @param int id
 * @return String
 */
function actions($id){
    $btns = "";
    $btns .= "<a href='#' class='btn btn-sm btn-primary btn-view' data-id='".$id."' data-bs-toggle='modal' data-bs-target='#viewModal'>Edit</a>";
    $btns .= "<a href='#' class='btn btn-sm btn-danger btn-delete'  data-id='".$id."' >Delete</a>";
    $btns .= "<a href='#' class='btn btn-sm btn-success btn-complete' data-id='".$id."' >Complete</a>";
    return $btns;
}

/**
 * Build alert label for status
 * @param array data
 * @return String
 */
function alertLabel($data){
    $alert = ($data['status'] == 'Complete') ? "alert-success" : "alert-info";
    $strBuild = "<label class='alert {$alert}'>";
    $strBuild .= "<strong>{$data['status']} </strong>";
    $strBuild .= "</label>";
    return $strBuild;
}