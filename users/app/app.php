<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

/**
 * Add your routes here
 */
$app->post('/', function () {
    $body = $this->request->getJsonRawBody(true);

    $response = [
        'jsonrpc' => '2.0',
        'id' => $body['id'],
    ];

    try {
        switch ($body['method']) {
            case 'usersService.findUser':
                break;
            default:
                throw new DomainException('Unknown method');
        }

        list($class, $method) = explode('.', $body['method']);
        $params = $body['params'];

        $user = call_user_func_array([$this->{$class}, $method], $params);

        $response['result'] = $user;
    } catch (Throwable $e) {
        $response = [
            'error' => [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ],
        ];
    }

    echo json_encode($response);
});

/**
 * Not found handler
 */
$app->notFound(function () use($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});
