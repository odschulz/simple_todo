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

        // Get all tasks.
        $app->get('/tasks', function (Request $request, Response $response) use ($app, $db) {
            $model = new \Models\TasksModel($app, $db);
            $result = $model->index();

            return $response->withJson($result);
        });

        // Create new task.
        $app->post('/tasks', function (Request $request, Response $response) use ($app, $db) {
            $params = $request->getParsedBody();
            $title = isset($params['title']) ? $params['title'] : NULL;
            $position = isset($params['position']) ? $params['position'] : NULL;
            $model = new \Models\TasksModel($app, $db);
            $result = $model->insertTask($title, $position);

            return $response->withJson($result);
        });

        // Update a task.
        $app->put('/tasks/{id}', function (Request $request, Response $response) use ($app, $db) {
            $id = $request->getAttribute('id');
            $params = $request->getParsedBody();
            $model = new \Models\TasksModel($app, $db);
            $result = $model->updateTaskById($id, $params);

            return $response->withJson($result);
        });

        // Delete a task
        $app->delete('/tasks/{id}', function (Request $request, Response $response) use ($app, $db) {
            $id = $request->getAttribute('id');
            $model = new \Models\TasksModel($app, $db);
            $result = $model->deleteTaskById($id);

            return $response->withJson($result);
        });

        // Update tasks order.
        $app->patch('/tasks/reorder', function (Request $request, Response $response) use ($app, $db) {
            $params = $request->getParsedBody();
            $model = new \Models\TasksModel($app, $db);
            $result = $model->reorderTasks($params);

            return $response->withJson($result);
        });
    }

}
