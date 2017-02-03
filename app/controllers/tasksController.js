app.controller('tasksController', function($scope, $http) {

    // TODO: Response and error handling.
    // TODO: Set headers.

    getTasks = function (){
        $http.get('api/public/tasks').then(function(response){
            $scope.tasks = response.data;
        }, function (error) {
            console.log(error);
        });
    };

    $scope.addTask = function(title){
        $http.post('api/public/tasks/create', {
            'title': title,
            'position': $scope.tasks.length + 1
        }).then(function(response){
            $scope.tasks = response.data;
        }, function (error) {
            console.log(error);
        });
    };

    $scope.closeTask = function(task){
        if (confirm("Are you sure you want to close this task")) {
            $http.post('api/public/tasks/' + task.id + '/close').then(function(response){
                $scope.tasks = response.data;
            }, function (error) {
                console.log(error);
            });
        }
    };

    $scope.deleteTask = function(task){
        if (confirm("Are you sure you want to delete this task")) {
            $http.delete('api/public/tasks/' + task.id + '/delete').then(function(response){
                $scope.tasks = response.data;
            }, function (error) {
                console.log(error);
            });
        }
    };

    $scope.reorderTasks = function (index) {
        var newIndex;
        var reorderedTasks = [];
        // Modify tasks array and fetch the removed item.
        var removedTask = $scope.tasks.splice(index, 1)[0];

        angular.forEach($scope.tasks, function (task, indexKey) {
            if (removedTask.id === task.id) {
                newIndex = indexKey;
            }
            task.position = indexKey + 1;
            reorderedTasks.push(task);
        });

        var reorderIndex = Math.min(index, newIndex);
        // Get only tasks with a changed position to be updated.
        reorderedTasks.splice(0, reorderIndex);

        $http.post('api/public/tasks/reorder', {
            'tasks': reorderedTasks
        }).then(function (response) {
            $scope.tasks = response.data;

            $scope.tasks = response.data;
        }, function (error){
            console.log(error);
        });
    };

    // Load all tasks on init.
    getTasks();

});
