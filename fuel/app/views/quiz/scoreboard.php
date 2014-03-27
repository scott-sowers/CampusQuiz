<div id="scoreboard" class="container-fluid">
    <div class="row-fluid">
        <div id="leaderboard" class="span4 quizbox">
            <h1>Leaderboard <i class="icon-refresh" id="refresh-board"></i></h1>
            <div id="registered-teams"></div>
        </div>
        <div id="gameboard" class="span8 offset4">
            <div id="start-quiz" class="quizbox">
                <h1>Cisco Quiz</h1>
                <ol id="instructions">
                    <li>Go to <a href="ciscoquiz.ssowers.com">ciscoquiz.ssowers.com</a></li>
                    <li>Enter your team name</li>
                    <li>Click "Register"</li>
                    <li>Click "Answer" when you know the answer to a question</li>
                </ol>
                <button class="btn start-quiz" type="button">Start Quiz</button> <a href="/edit">Edit Quiz</a>
            </div>
            <div id="question-matrix" class="hidden quizbox">
                <table class="table table-bordered">
                    <thead>
                        <?php foreach ($categories as $category) : ?>
                        <th>
                            <?php echo stripslashes($category->getName()); ?>
                        </th>
                        <?php endforeach; ?>
                        <?php for ($i = 1; $i <= $pointsCount; $i++) : ?>
                        <tr>
                            <?php for ($j = 1; $j <= $categoryCount; $j++ ) : $pointIndex = $i - 1; ?>
                            <td qid="question<?php echo $i . $j; ?>"><a href="#question<?php echo $i . $j; ?>" class="question-link"><?php echo $points[$pointIndex]->getValue(); ?></a></td>
                            <?php endfor; ?>
                        </tr>
                        <?php endfor; ?>
                    </thead>
                </table>
            </div>
            <div id="questions" class="quizbox hidden">
                <?php foreach ($questions as $question) :?>
                <div id="question<?php echo $question->getPoints()->getId() . $question->getCategory()->getId(); ?>" class="question-container hidden">
                    <h1><?php echo stripslashes($question->getCategory()->getName()); ?> 
                        <small class="question-value"><span class="points"><?php echo $question->getPoints()->getValue() ?></span> Points</small></h1>
                    <div class="question lead"><?php echo stripslashes($question->getQuestion()); ?></div>
                    <div class="answer hidden">
                        <h2>Answer:</h2>
                        <div class="lead"><?php echo stripslashes($question->getAnswer()); ?></div>
                    </div>
                    <button class="show-answer btn" type="button">Reveal Answer</button>
                    <div id="response-container">
                        <h2>Responses:</h2>
                        <ul id="team-answers"></ul>
                    </div>
                    <div><button type="button" class="go-back btn"><i class="icon-arrow-left"></i> Back</button></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
    <?php echo Asset::js('//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js'); ?>
    <?php echo Asset::js('bootstrap.min.js'); ?>
    <?php echo Asset::js('http://js.pusher.com/2.1/pusher.min.js'); ?>
    <?php echo Asset::js('gameboard.js'); ?>