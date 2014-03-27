<div id="scoreboard" class="container-fluid">
    <div class="row-fluid">
        <div id="gameboard" class="span12">
            <h1>Quiz Editor <small><a href="/scoreboard">Go To Scoreboard</a></small></h1>
            <div id="question-matrix" class="quizbox">
                
                <table class="table table-bordered">
                    <thead>
                        <?php foreach ($categories as $category) : ?>
                        <th>
                            <div class="cat-editor" catid="<?php echo $category->getId(); ?>" contenteditable="true"><?php echo stripslashes($category->getName()); ?></div>
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
                    <h1 catid="<?php echo $question->getCategory()->getId(); ?>"><span class="category-text"><?php echo stripslashes($question->getCategory()->getName()); ?></span> 
                        <small class="question-value"><span class="points"><?php echo $question->getPoints()->getValue() ?></span> Points</small></h1>
                    <div class="question lead q-editor" qid="<?php echo $question->getId(); ?>" contenteditable="true"><?php echo stripslashes($question->getQuestion()); ?></div>
                    <div class="answer">
                        <h2>Answer:</h2>
                        <div class="lead q-editor" contenteditable="true" qid="<?php echo $question->getId(); ?>"><?php echo stripslashes($question->getAnswer()); ?></div>
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
    <?php echo Asset::js('jquery.popline.min.js'); ?>
    <?php echo Asset::js('editgame.js'); ?>