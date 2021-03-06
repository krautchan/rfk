<?php
$template = array();
require_once('../lib/common-web.inc.php');
include('include/listenercount.php');
global $lang;
$template['section'] = "register";
$template['PAGETITLE'] = $lang->lang('L_REGISTER');

if(isset($_POST['action']) && $_POST['action'] == 'register'){
    $err = false;
    if($_POST['password'] != $_POST['password2']){
        $_MSG['err'][] = $lang->lang('L_ERR_PASSMISMATCH');
        $err = true;
    }
    if(strlen($_POST['username']) < 3){
        $_MSG['err'][] = $lang->lang('L_ERR_USERNAME2SHORT');
        $err = true;
    }
    if(!$err){
        if($user->register($_POST['username'],$_POST['password']) == 0){
            $user->set_streampassword($_POST['streampassword']);
            $_MSG['msg'][] = $lang->lang('L_REG_SUCCESS');
            redirect_to_page('login.php',$_SERVER['PHP_SELF']);
        }else{
            $_MSG['err'][] = $lang->lang('L_ERR_REGFAIL');
        }
    }else{
        $template['username'] = $_POST['username'];
        $template['streampassword'] = $_POST['streampassword'];
    }
}

cleanup_h2o($template);
$h2o = new H2o('register.html',$h2osettings);
echo $h2o->render($template);
?>
