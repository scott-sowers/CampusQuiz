(function ($) {
    console.log(document.URL);
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

    channel.bind('register-team', function (data) {
        var teamName = data.teamName;
        var teamSlug = data.teamSlug;
        addTeam(teamName, teamSlug);
    });

    channel.bind('team-answer', function (data) {
        var teamName = data.teamName;
        var teamSlug = data.teamSlug;
        teamAnswer(teamName, teamSlug);
    });

    $('button.start-quiz').click(function (e) {
        $('#start-quiz').remove();
        $('#question-matrix').removeClass('hidden');
    });

    $('a.question-link').click(function (e) {
        e.preventDefault();

        var questionId = $(this).attr('href');
        $('#question-matrix').addClass('hidden');
        $(questionId).removeClass('hidden').addClass('active-question');
        $('#questions').removeClass('hidden');
    });

    $('button.go-back').click(function (e) {
        e.preventDefault();
        $('.question-container').addClass('hidden').removeClass('active-question');
        $('#question-matrix').removeClass('hidden');
        $('#questions').addClass('hidden');
    });

    $('button.show-answer').click(function (e) {
        e.preventDefault();
        $(this).siblings('.answer').removeClass('hidden');
        markAnswered($(this).parent().attr('id'));
        setAnswered($(this).parent().attr('id'));
        $(this).remove();
    });

    $('button#register-button').click(function (e) {
        e.preventDefault();
        var teamName = $('#buzzer-team-name').val().trim();

        if (teamName.length > 0) {
            registerTeam(teamName);
        }
    });

    function markAnswered(questionId) {
        $('td[qid="' + questionId + '"]').addClass('answered');
    }

    function registerTeam(teamName) {
        var teamSlug = getTeamSlug(teamName);

        var response = $.ajax({
            url: '/pusher/event.json?event=register-team&teamName='
                + teamName + '&teamSlug=' + teamSlug
        });

        $('#buzzer-title').text(teamName);
        $('#buzzer-team-name').remove();
        $('#register-button').remove();
        $('#buzzer-button').removeClass('hidden');
    }

    function addTeam(teamName, teamSlug) {
        var team = $('#registered-teams #' + teamSlug);

        if (team.length == 0 && findTeam(getTeams(), teamSlug) === false) {
            addTeamHTML(teamName, teamSlug, '0000');
            storeNewTeam(teamName, teamSlug);
        }
    }

    function addTeamHTML(teamName, teamSlug, teamPoints) {
        jQuery('<div id="' + teamSlug + '" class="fluid-row team"><div class="span4 team-score">' + teamPoints + '</div><div class="span8 team-name">' + teamName + '</div><div class="clear"></div></div>').appendTo('#registered-teams');
    }

    $('#buzzer-button button').click(function (e) {
        e.preventDefault();
        var teamName = $('#buzzer-title').text();

        answerQuestion(teamName);
    });

    function answerQuestion(teamName) {
        var teamSlug = getTeamSlug(teamName);

        var response = $.ajax({
            url: '/pusher/event.json?event=team-answer&teamName='
                + teamName + '&teamSlug=' + teamSlug
        });
    }

    function teamAnswer(teamName, teamSlug) {
        var currentQuestion = $('.active-question');

        if (currentQuestion.length != 0) {
            var team = $('.active-question #team-answers #' + teamSlug);
            var responseORder = $('.active-question #team-answers li').length + 1;

            if (team.length == 0) {
                jQuery('<li><div class="team-response" id="' + teamSlug + '"><span class="response-order">' + responseORder + '.</span> <span class="team-name">' + teamName + '</span></div><div class="score-controls"><i class="icon-plus"></i> <i class="icon-minus"></i></div><div class="clear"></div></li>').appendTo('.active-question #team-answers');
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

        if (scoreText == '0000') {
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
        if (newScore < 0) {
            newScore = 0;
        }
        setTeamScore(teamSlug, newScore);
    }

    function setTeamScore(teamSlug, teamScore) {
        var stringScore = '';

        if (teamScore < 10) {
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
        }
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

        return false;
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
        var points = "0000";
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