<?php

$app->get('/users/', function () use ($app) {

    $query = "SELECT * FROM users";
    /** @var PDOStatement $stm */
    $stm = $app['mysql']->prepare($query);
    $stm->execute();
    $users = $stm->fetchAll(\PDO::FETCH_ASSOC);
    return \Symfony\Component\HttpFoundation\JsonResponse::create($users);
});

$app->get('/users/{id}', function ($id) use ($app) {

    $query = "SELECT * FROM users WHERE id = :id";
    /** @var PDOStatement $stm */
    $stm = $app['mysql']->prepare($query);
    $stm->bindParam(':id', $id);
    $stm->execute();
    $users = $stm->fetchAll(\PDO::FETCH_ASSOC);
    return \Symfony\Component\HttpFoundation\JsonResponse::create($users);
});

$app->post('/users/', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    $query = "INSERT INTO users (`name`, email) VALUES (:name, :email)";
    /** @var PDOStatement $stm */
    $stm = $app['mysql']->prepare($query);
    $payload = json_decode($request->getContent(), true);
    $stm->bindParam(':name', $payload['name']);
    $stm->bindParam(':email', $payload['email']);
    $isOk = $stm->execute();

    if (!$isOk) {
        return \Symfony\Component\HttpFoundation\JsonResponse::create(
            $stm->errorInfo(),
            \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
        );
    }

    $userId = $app['mysql']->lastInsertId();
    return \Symfony\Component\HttpFoundation\JsonResponse::create($userId);
});

$app->delete('/users/{id}', function ($id) use ($app) {

    $query = "DELETE FROM users WHERE id = :id";
    /** @var PDOStatement $stm */
    $stm = $app['mysql']->prepare($query);
    $stm->bindParam(':id', $id);
    $stm->execute();

    if ($stm->rowCount() == 0) {
        return \Symfony\Component\HttpFoundation\JsonResponse::create(
            "There is no user with id $id",
            \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
        );
    }

    return \Symfony\Component\HttpFoundation\JsonResponse::create($id);
});
