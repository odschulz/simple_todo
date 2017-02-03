
var app = angular.module('toDoApp', ['ngRoute', 'dndLists']);

app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'templates/tasks.html',
                controller: 'tasksController'
            });
    }
]);

