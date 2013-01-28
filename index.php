<?php
require 'lib/common.php';
#error_reporting(E_ALL);

use Form\Form,
    Form\Elements,
    Form\Elements\File,
    Form\Validators,
    Translate\Translate,
    Auth\Auth,
    DataBase\DataBase;

$db = new DataBase($config['dsn'], $config['user'], $config['pass']);
$tr = new Translate(__DIR__ . '/lang', 'ru');
/* @var $auth Auth */
$auth = Auth::getInstance();
/* validators */
$max = new Validators\MaxLength(255);
$validatorEmail = new Validators\Email();
$notBlank = new Validators\NotBlank();
$unique = new Validators\Unique('test_user', 'name', $db->getDbh());
$fileTypes = new Validators\FileType(array('image/jpeg', 'image/png', 'image/gif'));
$required = new Validators\Required();
/* form Reg */
$form = new Form('reg');
$form->setTranslate($tr); /* set translate */
$submit = new Elements\Submit('submit');
$submit->setAttr('class', 'btn btn-large btn-primary');
$attrInput = array('class' => 'input-block-level');
$form->addInputElement('email', 'email', $attrInput)
        ->addValidators($validatorEmail, $notBlank, $max, $unique, $required)
        ->setLabel('Email');
$form->addInputElement('pass', 'password', $attrInput)->addValidators($notBlank, $max, $required)
        ->setLabel('Password');
$file = new File('avatar', __DIR__ . '/uploads/');
$file->addValidators($fileTypes)
        ->setLabel('Avatar');
$form->addElements($file, $submit);
/* form login */
$formLogin = new Form('login');
$file->setTranslate($tr);
$email = $formLogin->addInputElement('_username', 'email');
$email->addValidators($validatorEmail, $notBlank, $max, $required)->setLabel('Email');
$pass = $formLogin->addInputElement('_password', 'password');
$pass->addValidators($notBlank, $max, $required)->setLabel('Password');
$formLogin->addElement($submit);
/* logout */
if (isset($_GET['logout'])) {
    $auth->unsetIdentity();
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
}
/* check form */
if ($form->isRequestMethod('POST')) {
    if (isset($_POST['_username'])) {
        $formLogin->bind($_POST);
        if ($formLogin->isValid()) {
            if ($user = $db->getFromNamePass($formLogin->getValue('_username'), md5($formLogin->getValue('_password')))) {
                $auth->setData($user);
            } else {
                /* @var $username Elements\Input */
                $username = $formLogin->getElement('_username');
                $username->setErrorMessages(array('Username or password Incorrect'));
            }
        }
    } else {
        $form->bind($_POST);
        if ($form->isValid()) {
            if ($user = $db->addUser($form->getValue('email'), md5($form->getValue('pass')))) {
                $auth->setData($user);
                $file = $form->getElement('avatar');
                if ($file->getFileName()) {
                    $file->setFileName(md5($user->name));
                    $filename = $file->getValue();
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                max-width: 300px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }

        </style>
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
        <!--[if lt IE 9]>
              <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->
        <title><?php echo $tr->translate('Form Login'); ?></title>
    </head>
    <body>
        <div class="container">
            <?php if ($auth->hasIdentity()): ?>
                <div class="form-signin">
                    <?php echo $tr->translate('Hello'); ?> <?php echo $auth->getIdentity()->name; ?>
                    <?php if (file_exists(__DIR__ . '/uploads/' . md5($auth->getIdentity()->name))): ?>
                        <img src="/uploads/<?php echo md5($auth->getIdentity()->name);?>"/>
                    <?php endif; ?>
                    <a href="?logout=true"><?php echo $tr->translate('Logout'); ?></a>
                </div>
            <?php else: ?>
                <form onsubmit="return validate(this);" method="<?php echo $form->getMethod(); ?>" enctype="<?php echo $form->getEnctype(); ?>" id="<?php echo $form->getName(); ?>" class="form-signin">
                    <h2 class="form-signin-heading"><?php echo $tr->translate('Join Today'); ?></h2>
                    <?php echo $form->render(); ?>
                </form>

                <form onsubmit="return validate(this);" method="<?php echo $formLogin->getMethod(); ?>" enctype="<?php echo $formLogin->getEnctype(); ?>" id="<?php echo $formLogin->getName(); ?>" class="form-signin">
                    <h2 class="form-signin-heading"><?php echo $tr->translate('Please sign in'); ?></h2>
                    <?php echo $formLogin->render(); ?>
                </form>
            <?php endif; ?>
        </div>
        <script src="js/common.js"></script>
    </body>
</html>
