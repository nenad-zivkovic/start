<?php 
    require_once __DIR__.'/../loader.php';

    use app\themes\Layout as Layout;
    use app\components\auth\AuthManager as AuthManager;
    use app\components\web\Html as Html;
    use app\models\User as User;

    $auth = new AuthManager();
    $auth->protectPage();

    $layout = new Layout($auth);
    $layout->header(); 

    $users = (new User())->findAll();
?>

        <!-- Top content -->
        <div class="top-content">
            
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Users</strong> of our system</h1>
                            <div class="description">
                                <p>
                                    Here are our newest <strong>users</strong>.
                                </p>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $user->id ?></td>
                                        <td><?= $user->username ?></td>
                                        <td><?= $user->email ?></td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

<?php 
    $layout->footer();
?>