<?php

// use Psr\Http\Message\ResponseInterface as Response;
// use Psr\Http\Message\ServerRequestInterface as Request;
// use Firebase\JWT\JWT;

// class AuthController {
//     public function login(Request $request, Response $response, $args) {
//         $data = $request->getParsedBody();
//         $username = $data['username'];
//         $password = $data['password'];

//         // Aqui você deve verificar os dados do usuário com o banco de dados
//         if ($username == 'admin' && $password == 'password') {
//             $token = array(
//                 "iat" => time(),
//                 "exp" => time() + 3600,
//                 "data" => [
//                     "userId" => 1,
//                     "username" => $username
//                 ]
//             );

//             $jwt = JWT::encode($token, getenv('JWT_SECRET'));
//             $response->getBody()->write(json_encode(['token' => $jwt]));
//             return $response->withHeader('Content-Type', 'application/json');
//         } else {
//             return $response->withStatus(401)->withJson(['message' => 'Usuário ou senha inválidos']);
//         }
//     }
// }