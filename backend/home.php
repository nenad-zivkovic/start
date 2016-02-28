<?php 
    require_once __DIR__.'/../loader.php';

    use app\themes\Layout as Layout;
    use app\components\auth\AuthManager as AuthManager;
    use app\components\session\SessionManager as SessionManager;
    use app\components\web\Html as Html;

    $auth = new AuthManager();
    $auth->protectPage();

    $layout = new Layout($auth);
    $layout->header(); 

    $username = (new SessionManager())->get('username');
?>

        <!-- Top content -->
        <div class="top-content">
            
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Wellcome</strong> <?= Html::encode($username); ?></h1>
                            <div class="description">
                                <p>
                                    You can see all users by clicking on <strong>Users</strong> menu option.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

<?php 
    $layout->footer();
?>