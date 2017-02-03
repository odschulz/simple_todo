<?php


namespace Models;

class TasksModel extends BaseModel {

    /**
     * Default method to fetch all tasks ordered by position.
     *
     * @return array
     */
    public function index() {
        $result = $this->db->prepare('SELECT id, title, position, status FROM task ORDER BY position ASC')->execute()->fetchAllAssoc();

        return $result;
    }

    /**
     * Insert task.
     *
     * @param string $title
     * @param int $position
     * @param bool $fetch_tasks
     *
     * @return string
     *
     * @throws \Exception
     */
    public function insertTask($title, $position, $fetch_tasks = TRUE) {
        if (
            empty($title) ||
            !is_string($title) ||
            empty($position) ||
            !intval($position)
        ) {
            throw new \Exception('Invalid task title or position provided when creating a new task.');
        }
//        $inserted = $this->db->prepare("INSERT INTO REGISTRY (name, value) VALUES (:name, :value)")->execute()->fetchAllAssoc();
        $inserted = $this->db
            ->prepare('INSERT INTO task (title, position) VALUES (?, ?)', [$title, $position])
            ->execute()
            ->getLastInsertedId();

        if ($fetch_tasks) {
            return $this->index();
        }

        return ['status' => 'OK'];
    }

    /**
     * Close task by id.
     *
     * @param int $id
     * @param bool $fetch_tasks
     *
     * @return array
     */
    public function closeTaskById($id, $fetch_tasks = TRUE) {
        if (!intval($id)) {
            throw new \Exception('Invalid ID provided for closing task.');
        }

        $this->db->prepare('UPDATE task set status = :status WHERE id = :id', [
                ':status' => 0,
                ':id' => $id
            ])->execute();
        
        if ($fetch_tasks) {
            return $this->index();
        }

        return ['status' => 'OK'];
    }

    /**
     * Delete task by id.
     *
     * @param int $id
     * @param bool $fetch_tasks
     *
     * @return array
     */
    public function deleteTaskById($id, $fetch_tasks = TRUE) {
        // TODO: Alternatively, do not delete but rather set to 'inactive'.
        if (!intval($id)) {
            throw new \Exception('Invalid ID provided for deleting task.');
        }
        $this->db->prepare('DELETE FROM task WHERE id = :id', [
            ':id' => $id
        ])->execute();


        if ($fetch_tasks) {
            return $this->index();
        }

        return ['status' => 'OK'];
    }

    /**
     * Get task by id.
     *
     * @param array $tasks
     *   Task ID as key, weight as value.
     * @param bool $fetch_tasks
     *
     * @return array
     *   All tasks after position has been updated.
     */
    public function reorderTasks($tasks, $fetch_tasks = TRUE) {
        foreach ($tasks as $task) {
            $this->db
                ->prepare('UPDATE task set position = :position WHERE id = :id', [
                    ':position' => $task['position'],
                    ':id' => $task['id']
                ])->execute();
        }

        if ($fetch_tasks) {
            return $this->index();
        }

        return ['status' => 'OK'];
    }

}
