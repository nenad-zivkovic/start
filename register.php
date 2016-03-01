<?php 
    require_once 'loader.php';

    use app\themes\Layout as Layout;
    use app\components\auth\AuthManager as AuthManager;
    use app\components\session\SessionManager as SessionManager;
    use app\components\web\UrlManager as UrlManager;
    use app\components\web\Html as Html;

    $auth = new AuthManager();
    $layout = new Layout($auth);
    $layout->header(['title' => 'Register']);

    // dont allow members to see this page
    if ($auth->userIsMember()) {
        UrlManager::goToMembersHome();
    }

    //-- handle errors --//
    $session = new SessionManager();

    if ($session->has('form-errors')) {
        $errors = $session->get('form-errors');
    }
    $session->remove('form-errors');  
?>

        <!-- Top content -->
        <div class="top-content">
            
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Wellcome</strong> to our site</h1>
                            <div class="description">
                                <p>
                                    Here you can <strong>create</strong> your account.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3>Register to our site</h3>
                                    <?php if (!empty($errors)): ?>
                                        <p class="text-danger">Please fix the following errors:</p>
                                        <ul>
                                        <?php foreach ($errors as $msg): ?>
                                            <li class="text-danger"><?= $msg ?></li>
                                        <?php endforeach ?>
                                        </ul>
                                    <?php else: ?>
                                        <p>Please fill out the following fields to register:</p>
                                    <?php endif ?>
                                </div>
                                <div class="form-top-right">
                                    <i class="fa fa-group"></i>
                                </div>
                            </div>
                            <div class="form-bottom">
                                <form role="form" action=<?= Html::process('register.php') ?> 
                                      method="post" class="register-form">
                                    <div class="form-group">
                                        <label class="sr-only" for="form-username">Username</label>
                                        <input type="text" name="form-username" placeholder="Create your username" 
                                               class="form-username form-control" id="form-username">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-email">E-mail</label>
                                        <input type="text" name="form-email" placeholder="Enter your E-mail" 
                                               class="form-email form-control" id="form-email">
                                    </div>                                    
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Password</label>
                                        <input type="password" name="form-password" placeholder="Create your password" 
                                               class="form-password form-control" id="form-password">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn">Register me!</button>
                                        <span class="pull-right">
                                            If you have account you can <a href="#">Log in</a>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- /row-->
                </div>
            </div>
            
        </div>

<?php 
    $layout->footer();
?>