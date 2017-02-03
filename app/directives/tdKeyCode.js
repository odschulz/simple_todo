app.directive('tdKeyCode', ["$parse", function($parse) {
    return {
        restrict: 'A',
        compile: function($element, attr){
            var parseCallback = $parse(attr['tdKeyCode'], null, true);

            // Apply event on keypress if keycode matches.
            return function tdKeyCodeHandler(scope, element, attrs) {
                element.on("keypress", function(event){
                    var keyCode = event.which || event.keyCode;

                    var input = element.val();
                    if (attrs.hasOwnProperty('code') && keyCode == attrs.code && input) {
                        element[0].value = '';
                        scope.$apply(parseCallback(scope, {$input: input}));
                    }
                });
            }
        }
    }
}]);