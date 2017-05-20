function Recipe($scope, $http) {
    $http.get('http://drupal8.dev/api/recipes/6').
        success(function(data) {
            $scope.recipes = data[0];
        });
}