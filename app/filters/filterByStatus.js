app.filter('filterByStatus', function() {
    return function(items, search) {
        if (!search) {
            return items;
        }

        var status = search.status;
        if (status === undefined || status === '') {
            return items;
        }

        return items.filter(function(element, index, array) {
            return element.status == search.status;
        });
    };
});
