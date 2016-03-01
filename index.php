<?php 
    require_once 'loader.php';

    use app\themes\Layout as Layout;
    use app\components\auth\AuthManager as AuthManager;
    use app\components\session\SessionManager as SessionManager;
    use app\components\web\UrlManager as UrlManager;
    use app\components\web\Html as Html;

    $auth = new AuthManager();
    $layout = new Layout($auth);
    $layout->header(['title' => 'PHP Start Template']);

    // dont allow members to see this page
    if ($auth->userIsMember()) {
        UrlManager::goToMembersHome();
    }

    //-- handle errors --//
    $session = new SessionManager();

    if ($session->has('form-errors')) {
        $error = $session->get('form-errors');
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
	                            	To continue please <strong>Log in</strong> 
                                    or create an account if you do not have one.
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login to our site</h3>
                                    <?php if (isset($error)): ?>
                                       <p class="text-danger"><?= $error ?></p>
                                    <?php else: ?>
                                        <p>Please enter your username and password:</p>
                                    <?php endif ?>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action=<?= Html::process('login.php') ?> 
                                      method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="form-username" placeholder="Username..." 
                                            class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="form-password" placeholder="Password..." 
                                            class="form-password form-control" id="form-password">
			                        </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn">Sign in!</button>
                                        <span class="pull-right">
                                            If you do not have account you can <a href="register.php">Register</a>
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