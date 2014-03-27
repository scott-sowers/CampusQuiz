$(".q-editor").popline({enable: ["bold","italic","strikethrough","underline","orderedList", "unOrderedList"]});
$(".cat-editor").blur(function(e) {
    var data = {
        category: $(this).text(),
        id: $(this).attr('catid')
    };
    
    $.post("/api/category.json", data, function() {
        $("h1[catid='"+data.id+"'] .category-text").text(data.category);
    });
    
});

$(".question.q-editor").blur(function(e) {
    var data = {
        id: $(this).attr('qid'),
        question: $(this).html()
    };
    console.log(data.question);
    $.post("/api/question.json", data, function(data) {});
});

$(".answer .q-editor").blur(function(e) {
    var data = {
        id: $(this).attr('qid'),
        answer: $(this).html()
    };
    $.post("/api/answer.json", data, function(data) {});
});