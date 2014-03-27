<div id="buzzer" class="container-fluid">
    <div id="buzzer-form" class="quizbox">
        <h2 id="buzzer-title">Register Your Team</h2>
        <input type="text" class="input-block-level" placeholder="Team Name..." id="buzzer-team-name" />
        <br />
        <button id="register-button" class="btn btn-large btn-primary" type="button">Register Team</button>
        <div id="buzzer-button" class="hidden">
            <button type="button">Answer</button>
        </div>
    </div>
</div>
<?php echo Asset::js('//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js'); ?>
<?php echo Asset::js('bootstrap.min.js'); ?>
<?php echo Asset::js('buzzer.js'); ?>
