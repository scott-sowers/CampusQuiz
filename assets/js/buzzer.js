(function ($) {
    $('button#register-button').click(function (e) {
        e.preventDefault();
        var teamName = $('#buzzer-team-name').val().trim();

        if (teamName.length > 0) {
            registerTeam(teamName);
        }
    });

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

    function getTeamSlug(teamName) {
        return teamName.toLowerCase().replace(/ /g, "-");
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
})(jQuery);