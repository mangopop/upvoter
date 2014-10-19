var myApp = angular.module('myApp', []);

myApp.controller('testCtrl', ['$scope', '$http',
    function ($scope, $http) {

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

            $http({method: 'GET', url: 'vote_lookup_data.php'}).
                success(function (data, status) {
                    $scope.status = status;
                    //this contains pretty much all the information we need to build the table
                    $scope.tasks = data;
                    for (var prop in $scope.tasks){
                        //console.log('user id: '+ $scope.tasks[prop].user_id);
                        if($scope.tasks[prop].user_id === 1){
                            //console.log(prop);
                            //console.log('user votes: '+$scope.tasks[prop].user_votes);
                            $scope.user_votes_left -= $scope.tasks[prop].user_votes;
                        }

                    }
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

        //only want to save - user_votes
        $scope.save = function () {
            $http.post('save.php', $scope.tasks).
                success(function (data, status) {
                    console.log(data);
                    $scope.fetch();
                }).
                error(function (data, status) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                    $scope.tasks = data || "task Request failed";
                    $scope.status = status;
                });

//            $http({
//                url: "vote_lookup_data.php",
//                method: "POST",
//                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
//                data: $.param($scope.tasks)
//            }).success(function(data, status, headers, config) {
//                //$scope.data = data;
//            }).error(function(data, status, headers, config) {
//                $scope.status = status;
//            });
        };

        //vote up
        $scope.voteup = function($index){
            if($scope.user_votes_left > 0){
                $scope.user_votes_left --;
                //this should hopefully be added to the tasks object for later use? checked - looks good
                $scope.tasks[$index].user_votes ++;
                console.log($scope.tasks);
            }
        };

        //vote down
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