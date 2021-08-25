<?php

// error_reporting(0)
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\NotFoundException;


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/usuario.php';

//cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Instanciar la app de slimframework para manejar las rutas

$app = AppFactory::create();
$app->setBasePath($_SERVER['BASE_PATH']); //base url
$app->addErrorMiddleware(true, true, true);

//instanciar mi modelo
$usuario = new usuario();

///////////////GET ALL
$app->get('/getUsers', function ($request, $response) use ($usuario) {

    $usuarios = $usuario->getAll();
    for ($i = 0; $i < count($usuarios); $i++) {
        //agregar la columna de acciones
        $id = $usuarios[$i]['id'];
        $usuarios[$i]['actions'] = "<button data-id='$id' class='btn btn-primary' onClick='editar(this)'>Editar</button>";
        $usuarios[$i]['actions'] .= "<button data-id='$id' class='btn btn-danger' onClick='eliminar(this)'>Borrar</button>";
    }

    $payload = json_encode(
        [
            "error" => false,
            "data" =>
            $usuarios
        ]
    );
    $response->getBody()->write($payload);
    return $response
        ->withHeader('Content-Type', 'application/json');
});

///////////////GET USER
$app->get('/getUser', function ($request, $response) use ($usuario) {
    $idUser = $request->getQueryParams()['id'];
    $userData = $usuario->getUser($idUser);

    $payload = json_encode(['error' => false, "message" => "Usuario obtenido con éxito", "data" => ['user' => $userData]]);
    $response->getBody()->write($payload);
    return $response
        ->withHeader('Content-Type', 'application/json');
});
///////////////CREATE USER
$app->post('/createUser', function ($request, $response) use ($usuario) {
    //optener cuerpo del request y parsearlo a un array
    $contents = json_decode(file_get_contents('php://input'), true);

    //llenar el modelo
    $usuario->name = $contents['name'];
    $usuario->last_name = $contents['last_name'];
    $usuario->email = $contents['email'];
    $usuario->phone = $contents['phone'];
    //guardar el usario
    $usuario->save();
    //respuesta
    $payload = json_encode(['error' => false, "message" => "Usuario creado con éxito", "data" => []]);
    $response->getBody()->write($payload);
    return $response
        ->withHeader('Content-Type', 'application/json');
});
///////////////UPDATE USER
$app->put('/updateUser', function ($request, $response) use ($usuario) {
    //optener el cuerpo del rquest y parsearlo a un array
    $contents = json_decode(file_get_contents('php://input'), true);
    //optemner el usuario a actualizar
    $idUser = $request->getQueryParams()['id'];
    $usuario->getUser($idUser);
    //actualizar las propiedades del modelo
    $usuario->name = $contents['name'];
    $usuario->last_name = $contents['last_name'];
    $usuario->email = $contents['email'];
    $usuario->phone = $contents['phone'];
    $usuario->save();

    $payload = json_encode(['error' => false, "message" => "Usuario actualizado con éxito", "data" => []]);
    $response->getBody()->write($payload);
    return $response
        ->withHeader('Content-Type', 'application/json');
});
//DELETE
$app->delete('/deleteUser', function ($request, $response) use ($usuario) {
    $idUser = $request->getQueryParams()['id'];
    $usuario->getUser($idUser);
    $usuarioDestruido = [
        'name' => $usuario->name,
        'last_name' => $usuario->last_name
    ];
    $usuario->delete_user();


    $payload = json_encode(['error' => false, "message" => "Se elimino el usuario <<$usuarioDestruido[name] $usuarioDestruido[last_name]>> con éxito", "data" => ['usuario' => $usuarioDestruido]]);
    $response->getBody()->write($payload);
    return $response
        ->withHeader('Content-Type', 'application/json');
});

$app->run();
