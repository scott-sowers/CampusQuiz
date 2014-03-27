(function ($) {
    if (localStorage.ciscoquizteams) {
        loadTeams();
    } else {
        teamArray = [];
        storeTeams(teamArray);
    }

    if (localStorage.ciscoquizanswered) {
        loadAnswered();
    } else {
        answeredArray = [];
        storeAnswered(answeredArray);
    }

    var pusher = new Pusher('09aae1bb5ce4cc532936');
    var channel = pusher.subscribe('cisco-quiz');

    // Listens for the 'register-team' pusher
    channel.bind('register-team', function (data) {
        var teamName = data.teamName;
        var teamSlug = data.teamSlug;
        addTeam(teamName, teamSlug);
    });

    // Listens for the 'team-answer' pusher
    channel.bind('team-answer', function (data) {
        var teamName = data.teamName;
        var teamSlug = data.teamSlug;
        teamAnswer(teamName, teamSlug);
    });

    $('button.start-quiz').click(function (e) {
        $('#start-quiz').remove();
        $('#question-matrix').removeClass('hidden');
    });

    // Clicking on one of the points under a category takes the admin to the corresponding Q&A screen
    $('a.question-link').click(function (e) {
        e.preventDefault();

        var questionId = $(this).attr('href');
        $('#question-matrix').addClass('hidden');
        $(questionId).removeClass('hidden').addClass('active-question');
        $('#questions').removeClass('hidden');
    });

    // Takes admin back to Quizboard from a Q&A screen
    $('button.go-back').click(function (e) {
        e.preventDefault();
        $('.question-container').addClass('hidden').removeClass('active-question');
        $('#question-matrix').removeClass('hidden');
        $('#questions').addClass('hidden');
    });

    // Displays the answer for a questiosn on a Q&A screen
    $('button.show-answer').click(function (e) {
        e.preventDefault();
        $(this).siblings('.answer').removeClass('hidden');
        markAnswered($(this).parent().attr('id'));
        setAnswered($(this).parent().attr('id'));
        $(this).addClass('hidden');
    });

    // Clears the entire board for a new game
    $('i#refresh-board').click(function (e) {
        e.preventDefault();
        hideAnswers();
        clearQuestioMatrix();
        clearAllResponses();
        clearRegisterdTeams();
        clearLocalStorage();
    });

    // Hides all of the answers that have been previously shown
    function hideAnswers() {
        $('#questions .answer').addClass('hidden');
        $('button.show-answer').removeClass('hidden');
    }

    // Marks all of the questions on the quiz board as un-answered
    function clearQuestioMatrix() {
        $('#question-matrix td').removeClass('answered');
    }

    // Clears all of the buzz-in responses on Q&A screens
    function clearAllResponses() {
        $('#team-answers li').remove();
    }

    // Removes registered teams fromm the Leaderboard
    function clearRegisterdTeams() {
        $('#registered-teams .team').remove();
    }

    // Clears all items in local storage
    function clearLocalStorage() {
        localStorage.removeItem('ciscoquizteams');
        localStorage.removeItem('ciscoquizanswered');
    }

    // When an answer is displayed the corresponding cell on the Quiz Board changes to show that the question has been answered
    function markAnswered(questionId) {
        $('td[qid="' + questionId + '"]').addClass('answered');
    }

    // Adds a new team to the leaderboard when registered, will not add duplicate team names
    function addTeam(teamName, teamSlug) {
        var team = $('#registered-teams #' + teamSlug);

        if (team.length == 0 && findTeam(getTeams(), teamSlug) < 0 ) {
            addTeamHTML(teamName, teamSlug, '0');
            storeNewTeam(teamName, teamSlug);
        }
    }

    // Places the newly created teams html to the dom
    function addTeamHTML(teamName, teamSlug, teamPoints) {
        jQuery('<div id="' + teamSlug + '" class="fluid-row team"><div class="span4 team-score">' + teamPoints + '</div><div class="span8 team-name">' + teamName + '<i class="icon-remove" id="remove-' + teamSlug +'"></i></div><div class="clear"></div></div>').appendTo('#registered-teams');
        
        // Bind event to remove team from leaderboard
        $('i#remove-'+teamSlug).click(function(e) {
            console.log('foo');
            var teamSlug = $(this).parent().parent().attr('id');
            removeTeam(teamSlug);
            $(this).parent().parent().remove();
        });
    }

    // Adds a team's response to Q&A screen when buzzed in
    function teamAnswer(teamName, teamSlug) {
        var currentQuestion = $('.active-question');

        if (currentQuestion.length != 0) {
            var team = $('.active-question #team-answers #' + teamSlug);
            var teamOnBoard = findTeam(getTeams(),teamSlug);
            
            var responseOrder = $('.active-question #team-answers li').length + 1;

            if (team.length == 0 && teamOnBoard >= 0) {
                jQuery('<li><div class="team-response" id="' + teamSlug + '"><span class="response-order">' + responseOrder + '.</span> <span class="team-name">' + teamName + '</span></div><div class="score-controls"><i class="icon-plus"></i> <i class="icon-minus"></i></div><div class="clear"></div></li>').appendTo('.active-question #team-answers');
                $('i.icon-plus').unbind('click');
                $('i.icon-minus').unbind('click');
                $('i.icon-plus').click(function (e) {
                    var teamSlug = $(this).parent().siblings('.team-response').attr('id');
                    addTeamPoints(teamSlug);
                });
                $('i.icon-minus').click(function (e) {
                    var teamSlug = $(this).parent().siblings('.team-response').attr('id');
                    removeTeamPoints(teamSlug);
                });
            }
        }
    }

    function getTeamSlug(teamName) {
        return teamName.toLowerCase().replace(/ /g, "-");
    }

    function getQuestionPoints() {
        return parseInt($('.active-question .question-value .points').text(), 10);
    }

    function getTeamScore(teamSlug) {
        var scoreText = $('#registered-teams #' + teamSlug + ' .team-score').text();

        if (scoreText == '0') {
            return 0;
        }
        return parseInt(scoreText, 10);
    }

    function addTeamPoints(teamSlug) {
        var currentScore = getTeamScore(teamSlug);
        var pointsAdded = getQuestionPoints();
        var newScore = currentScore + pointsAdded;
        setTeamScore(teamSlug, newScore);
    }

    function removeTeamPoints(teamSlug) {
        var currentScore = getTeamScore(teamSlug);
        var pointsRemoved = getQuestionPoints();
        var newScore = currentScore - pointsRemoved;
        /*if (newScore < 0) {
            newScore = 0;
        }*/
        setTeamScore(teamSlug, newScore);
    }

    function setTeamScore(teamSlug, teamScore) {
        var stringScore = '';

        /*if (teamScore < 10) {
            stringScore = "000" + String(teamScore);
        }
        else if (teamScore < 100) {
            stringScore = "00" + String(teamScore);
        }
        else if (teamScore < 1000) {
            stringScore = "0" + String(teamScore);
        }
        else {
            stringScore = String(teamScore);
        }*/
        stringScore = String(teamScore);
        $('#registered-teams #' + teamSlug + ' .team-score').text(stringScore);
        setTeamPoints(teamSlug, stringScore);
    }

    function findTeam(teamArray, teamSlug) {
        var numTeams = teamArray.length;
        for (var i = 0; i < numTeams; i++) {
            if (teamArray[i].teamslug == teamSlug) {
                return i;
            }
        }

        return -1;
    }
    
    function removeTeam(teamSlug) {
        var teamArray = getTeams();
        var thisTeamIndex = findTeam(teamArray,teamSlug);
        teamArray.splice(thisTeamIndex,1);
        storeTeams(teamArray);
    }

    function storeAnswered(answeredArray) {
        localStorage.ciscoquizanswered = JSON.stringify(answeredArray);
    }

    function getAnswered() {
        var answeredArray = localStorage.ciscoquizanswered;
        return JSON.parse(answeredArray);
    }

    function setAnswered(questionId) {
        var answeredArray = getAnswered();
        if (findAnswered(answeredArray, questionId) == false) {
            answeredArray.push(questionId);
            storeAnswered(answeredArray);
        }
    }

    function findAnswered(answeredArray, questionId) {
        var count = answeredArray.length;
        for (var i = 0; i < count; i++) {
            if (answeredArray[i] == questionId) {
                return true;
            }
        }
        return false;
    }

    function loadAnswered() {
        var answeredArray = getAnswered();
        var count = answeredArray.length;
        for (var i = 0; i < count; i++) {
            var questionId = answeredArray[i];
            markAnswered(questionId);
        }
    }

    function storeTeams(teamArray) {
        localStorage.ciscoquizteams = JSON.stringify(teamArray);
    }

    function getTeams() {
        var teamArray = localStorage.ciscoquizteams;
        return JSON.parse(teamArray);
    }

    function storeNewTeam(teamName, teamSlug) {
        var teamArray = getTeams();
        var points = "0";
        var team = { 'teamname': teamName, 'teamslug': teamSlug, 'points': points };
        teamArray.push(team);
        storeTeams(teamArray);
    }

    function setTeamPoints(teamSlug, teamPoints) {
        var teamArray = getTeams();
        var teamIndex = findTeam(teamArray, teamSlug);
        teamArray[teamIndex].points = teamPoints;
        storeTeams(teamArray);
    }

    function loadTeams() {
        var teamArray = getTeams();
        var teamCount = teamArray.length;

        for (var i = 0; i < teamCount; i++) {
            var team = teamArray[i];
            var teamName = team.teamname;
            var teamSlug = team.teamslug;
            var teamPoints = team.points;

            addTeamHTML(teamName, teamSlug, teamPoints);
        }
    }

})(jQuery);