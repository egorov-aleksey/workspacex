<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

$app->session->start();

$app->before(function () use ($app) {
    if ($app->request->getURI() === '/login') {
        return true;
    }

    if (empty($app->session->get('auth'))) {
        $app->flashSession->error('You are not authenticated');
        $app->response->redirect('/login');
        $app->response->send();

        return false;
    }

    return true;
});

/**
 * Add your routes here
 */
$app->get('/', function () {
    /** @var \Phalcon\Mvc\Micro $this */
    echo $this->view->render('index');
});

$app->get('/login', function () {
    /** @var \Phalcon\Mvc\Micro $this */
    echo $this->view->render('login');
});

$app->post('/login', function () {
    /** @var \Phalcon\Mvc\Micro $this */
    $username = $this->request->get('username');
    $password = $this->request->get('password');

    try {
        $user = $this->usersService->findUser($username, $password);
    } catch (Throwable $e) {
        $this->flashSession->error($e->getMessage() . ' (' . $e->getCode() . ')' . ' ¯\_(ツ)_/¯');
        $this->response->redirect('/login');
        $this->response->send();
        return;
    }

    if (empty($user)) {
        $this->flashSession->error('Incorrect username or password ¯\_(ツ)_/¯');
        $this->response->redirect('/login');
        $this->response->send();
        return;
    }

    $this->session->set('auth', $user['id']);
    $this->flashSession->success('Success');
    $this->response->redirect('/');
    $this->response->send();
});

/**
 * Not found handler
 */
$app->notFound(function () use($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});
