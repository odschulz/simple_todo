<?php

namespace Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class TasksController extends BaseController {

    /**
     * {@inheritdoc}
     */
    protected function defineRoutes() {
        // TODO: Create input retrieval, validation and sanitization Class.

        $app = $this->app;
        $db = $this->db;
//        $allGetVars = $request->getQueryParams();
//        $allPostPutVars = $request->getParsedBody();

        $app->get('/tasks', function (Request $request, Response $response) use ($app, $db) {
            $model = new \Models\TasksModel($app, $db);
            $result = $model->index();

            return $response->withJson($result);
        });

        $app->post('/tasks/create', function (Request $request, Response $response) use ($app, $db) {
            $params = $request->getParsedBody();
            $title = isset($params['title']) ? $params['title'] : NULL;
            $position = isset($params['position']) ? $params['position'] : NULL;
            $model = new \Models\TasksModel($app, $db);
            $result = $model->insertTask($title, $position);

            return $response->withJson($result);
        });

        $app->post('/tasks/{id}/close', function (Request $request, Response $response) use ($app, $db) {
            $id = $request->getAttribute('id');
            $params = $request->getParsedBody();
            $model = new \Models\TasksModel($app, $db);
            $result = $model->closeTaskById($id);

            return $response->withJson($result);
        });

        $app->delete('/tasks/{id}/delete', function (Request $request, Response $response) use ($app, $db) {
            $id = $request->getAttribute('id');
            $params = $request->getParsedBody();
            $model = new \Models\TasksModel($app, $db);
            $result = $model->deleteTaskById($id);

            return $response->withJson($result);
        });

        $app->post('/tasks/reorder', function (Request $request, Response $response) use ($app, $db) {
            $params = $request->getParsedBody();
            $tasks = isset($params['tasks']) ? $params['tasks'] : NULL;
            $model = new \Models\TasksModel($app, $db);
            $result = $model->reorderTasks($tasks);

            return $response->withJson($result);
        });
    }

}
