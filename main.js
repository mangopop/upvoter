var myApp = angular.module('myApp', []);

myApp.controller('testCtrl', ['$scope', '$http',
    function ($scope, $http) {
        $scope.greeting = 'Hola!';
        $scope.method = 'GET';
        $scope.task_url = 'vote_lookup_data.php';
        $scope.user_votes_left = 5;

        //get votes information task_id, votes, user_id
        $http.get('vote_lookup_data.php').
            success(function(data, status) {
                $scope.votes = data;
            }).
            error(function(data, status) {
                $scope.votes = data || "user request failed";
            });

        //get task data
        $scope.fetch = function () {
            $scope.code = null;
            $scope.response = null;

            $http({method: $scope.method, url: $scope.task_url}).
                success(function (data, status) {
                    $scope.status = status;
                    $scope.tasks = data; //CANT GET TO THIS!
                    //console.log(data);
                }).
                error(function (data, status) {
                    $scope.tasks = data || "task Request failed";
                    $scope.status = status;
                });
        };

        $scope.fetch();

        $scope.test = function(){
            console.log($scope.tasks);
        };

        //PHP will save id,task, user_id
        $scope.save = function () {
            $http.post($scope.task_url, $scope.tasks).
                success(function (data, status) {
                    // this callback will be called asynchronously
                    // when the response is available
                    fetch();
                }).
                error(function (data, status) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
        };

        //$scope.user_votes_left = user['user_votes'];

        $scope.voteup = function($index){
            if($scope.user_votes_left > 0){
                $scope.user_votes_left --;

                $scope.tasks[$index].user_votes ++;
            }
        };

        //console.log($scope.tasks); //undefined until fetched

        $scope.votedown = function($index){
            if ($scope.user_votes_left < 5) {

                if($scope.tasks[$index].user_votes > 0){
                    $scope.tasks[$index].user_votes --;
                    $scope.user_votes_left ++;

                }
            }
        };

        //$scope.$apply();

    }]);