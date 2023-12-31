        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{asset('assets/js/jquery-3.5.1.min.js')}}"></script>
        <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->
        <script type="text/javascript">

            $(document).ready(function(){
                $('.toggle').on('click', function() {
                    $('.container').stop().addClass('active');
                });

                $('.close').on('click', function() {
                    $('.container').stop().removeClass('active');
                });
            });
            
            let quiz = document.querySelector("#quiz");
            let intro = document.querySelector("#introduction");
            let assesFT = document.querySelector("#assess-ft");
            let progressBar = document.querySelector(".progress");
            let startBtn = document.querySelector("#startBtn");
            let timeSpan = document.querySelector("#timeSpan");
            let questionH5 = document.querySelector("#question");
            let answersDiv = document.querySelector("#answers");
            let allDone = document.querySelector("#allDone");
            let finalScore = document.querySelector("#finalScore");
            let submit = document.querySelector("#submit");
            let highScoresList = document.querySelector("#highScoresList");
            let initials = document.querySelector("#initials");
            let clearHighscoresBtn = document.querySelector("#clearHighscoresBtn");

            let totalSeconds = 150;
            let timeRemining = totalSeconds;
            let secondsElapsed = 0;
            let discountSeconds = 0;
            let currentQuestion = 0;
            let progress = 0;
            let correctAnswers = 0;
            let correctScore = 0;
            var localHighscoresArray = [];
            let time = setInterval(timer, 1000);
            let justRegistered = false;
            clearInterval(time);

            let quizArray = [];

            $.ajax({
                url : "{{url('getQuestion')}}",
                type: "GET",
                dataType: "json",
                success: function(response){
                    
                    response.forEach((data) => {
                        quizArray.push({
                            question: data['question'],
                            options: data['options'],
                            correct: data['correct'],
                        });
                    })
                },  
            });
                
            startBtn.addEventListener("click", startQuiz);
            answersDiv.addEventListener("click", assesSelection);
            submit.addEventListener("click", addToHighscores);
            clearHighscoresBtn.addEventListener("click", clearHighscores);
            $("#staticBackdrop").on("shown.bs.modal", function (e) {
                loadHighScores();
            });
            $("#staticBackdrop").on("hidden.bs.modal", function (e) {
                if (justRegistered) {
                    init();
                }
            });

            init();

            function init() {
                timeSpan.textContent = timeRemining;
                quiz.style.display = "none";
                allDone.style.display = "none";
                assesFT.style.display = "none";
                intro.style.display = "block";
                startBtn.style.display = "block";
                progressBar.style.display = "none";

                totalSeconds = 150;
                timeRemining = totalSeconds;
                secondsElapsed = 0;
                discountSeconds = 0;
                currentQuestion = 0;
                progress = 0;
                correctAnswers = 0;
                correctScore = 0;
                justRegistered = false;
                timeSpan.textContent = timeRemining;

                if (localStorage.getItem("highscore")) {
                    localHighscoresArray = localStorage.getItem("highscore").split(",");
                }
                clearInterval(time);
                updateProgress();

                allDone.firstElementChild.setAttribute("class", "alert alert-info mt-0 mb-0");
                submit.setAttribute("class", "btn btn-info");
                progressBar.firstElementChild.setAttribute(
                    "class",
                    "progress-bar bg-info progress-bar-striped progress-bar-animated"
                );
            }

            function startQuiz() {
                intro.style.display = "none";
                startBtn.style.display = "none";
                quiz.style.display = "block";
                time = setInterval(timer, 1000);
                progressBar.style.display = "block";
                showQuestion();
            }

            function timer() {
                timeRemining = totalSeconds - secondsElapsed - 1 - discountSeconds;
                timeSpan.textContent = timeRemining;
                secondsElapsed++;
                if (timeRemining <= 0) {
                    clearInterval(time);
                    disableQuestions();
                    gameOver("time_out");
                }
            }

            function showQuestion() {
                console.log(quizArray[currentQuestion].correct)
                questionH5.textContent = quizArray[currentQuestion].question;
                var optionsBtnsArray = [];
                var indexArray = [];

                // console.log(questionBtn)

                for (i = 0; i < quizArray[currentQuestion].options.length; i++) {
                    var questionBtn = document.createElement("button");
                    questionBtn.setAttribute("type", "button");
                    questionBtn.setAttribute(
                        "class",
                        "list-group-item list-group-item-action list-group-item-info mt-1 answerButton"
                    );
                    questionBtn.setAttribute("data-index", i);
                    console.log(questionBtn)
                    if (i === quizArray[currentQuestion].correct) {
                        questionBtn.setAttribute("correct", "yes");
                    } else {
                        questionBtn.setAttribute("correct", "no");
                    }
                    questionBtn.textContent = quizArray[currentQuestion].options[i];
                    answersDiv.append(questionBtn);
                    indexArray.push(i);
                }

                answersDiv.childNodes.forEach(function (child) {
                    var rndIndex = Math.floor(Math.random() * indexArray.length);
                    answersDiv.append(answersDiv.children[rndIndex]);
                    indexArray.splice(rndIndex, 1);
                });
            }

            function disableQuestions() {
                let questionsAssed = document.querySelectorAll(".answerButton");
                questionsAssed.forEach((element) => {
                    element.setAttribute(
                        "class",
                        "list-group-item list-group-item-action list-group-item-danger mt-1 answerButton disabled"
                    );
                    if (
                        parseInt(element.getAttribute("data-index")) === quizArray[currentQuestion].correct
                    ) {
                        element.setAttribute(
                            "class",
                            "list-group-item list-group-item-action list-group-item-success mt-1 answerButton disabled"
                        );
                    }
                });
            }

            function assesSelection(event) {
                if (event.target.matches("button")) {
                    var index = parseInt(event.target.getAttribute("data-index"));
                    var timeInterval = 1000;
                    disableQuestions();
                    if (event.target.getAttribute("correct") === "yes") {
                        displayFTAlert(true);
                        correctAnswers++;
                    } else {
                        discountSeconds += 3;
                        clearInterval(time);
                        time = setInterval(timer, 1000);
                        displayFTAlert(false);
                    }
                    currentQuestion++;
                    updateProgress();

                    if (currentQuestion === quizArray.length) {
                        timeInterval = 5000;
                        gameOver("questions_done");
                    } else {
                        setTimeout(removeQuestionsButtons, 1000);
                        setTimeout(showQuestion, 1001);
                    }

                    setTimeout(function () {
                        assesFT.style.display = "none";
                    }, timeInterval);
                }
            }

            function updateProgress() {
                progress = Math.floor((currentQuestion / quizArray.length) * 100);
                if(isNaN(progress)) progress = 0;
                console.log(progress)
                var styleStr = String("width: " + progress + "%; height: 100%;");
                progressBar.firstElementChild.setAttribute("style", styleStr);
                progressBar.firstElementChild.textContent = progress + " %";
                correctScore = Math.floor((correctAnswers / quizArray.length) * 100);
            }

            function displayFTAlert(correct) {
                if (correct) {
                    assesFT.setAttribute(
                        "class",
                        "alert alert-success mt-0 mb-0 pt-0 pb-0 text-center"
                    );
                    assesFT.innerHTML = "<strong>Correct</strong>";
                    assesFT.style.display = "block";
                } else {
                    assesFT.setAttribute(
                        "class",
                        "alert alert-danger mt-0 mb-0 pt-0 pb-0 text-center"
                    );
                    assesFT.innerHTML =
                        "<strong>Incorrect. </strong> 3 secs. discounted. Keep trying!!";
                    assesFT.style.display = "block";
                    timeSpan.style.color = "red";
                    setTimeout(function () {
                        timeSpan.style.color = "#ffffff";
                    }, 1000);
                }
            }

            function removeQuestionsButtons() {
                questionH5.textContent = "";
                var child = answersDiv.lastElementChild;
                while (child) {
                    answersDiv.removeChild(child);
                    child = answersDiv.lastElementChild;
                }
            }

            function gameOver(cause) {
                if (cause === "questions_done") {
                    console.log("QUESTIONS DONE");
                    setTimeout(() => {
                        assesFT.setAttribute(
                            "class",
                            "alert alert-dark mt-0 mb-0 pt-0 pb-0 text-center"
                        );
                        assesFT.innerHTML = "<strong>Quiz Finished</strong> Good luck!!!";
                    }, 1500);
                    clearInterval(time);
                } else if (cause === "time_out") {
                    console.log("TIME OUT");
                    disableQuestions();
                    assesFT.setAttribute(
                        "class",
                        "alert alert-info mt-0 mb-0 pt-0 pb-0 text-center"
                    );
                    assesFT.innerHTML = "<strong>Time finished</strong> Good luck!";
                } else {
                    return false;
                }
                assesFT.style.display = "block";
                if (correctScore >= 70) {
                    setTimeout(() => { }, 5000);
                } else {
                    setTimeout(() => {
                        allDone.firstElementChild.setAttribute(
                            "class",
                            "alert alert-danger mt-0 mb-0"
                        );
                        progressBar.firstElementChild.setAttribute(
                            "class",
                            "progress-bar bg-danger progress-bar-striped progress-bar-animated"
                        );
                        submit.setAttribute("class", "btn btn-danger");
                    }, 5000);
                }
                setTimeout(function () {
                    finalScore.textContent = correctScore;
                    quiz.style.display = "none";
                    allDone.style.display = "block";
                    assesFT.style.display = "none";
                    removeQuestionsButtons();
                }, 5000);
            }

            function addToHighscores() {
                var highScoreElement = document.createElement("li");
                var highscoreStr = initials.value + " - " + correctScore;
                localHighscoresArray.push(highscoreStr);
                var highscoreArrayStr = localHighscoresArray.toString();
                highScoreElement.textContent = highscoreStr;
                highScoresList.append(highScoreElement);
                localStorage.setItem("highscore", localHighscoresArray);
                justRegistered = true;
                initials.value = "";
                $("#staticBackdrop").modal("show");
            }

            function loadHighScores() {
                var tempHighscoresArray = [];
                var tempHighscoresObject = {};
                var tempHighscoresObjectsArray = [];
                var tempLocalSCoreArray = [];
                while (highScoresList.hasChildNodes()) {
                    highScoresList.removeChild(highScoresList.childNodes[0]);
                }
                var lastPos;
                var lastChar = "";
                var localScore = 0;
                var localStrScore = "";
                var tempHighscore = "";
                for (i = 0; i < localHighscoresArray.length; i++) {
                    for (j = localHighscoresArray[i].length - 1; j >= 0; j--) {
                        lastPos = localHighscoresArray[i].length - 1;
                        lastChar = localHighscoresArray[i][lastPos - j];
                        if (lastChar && lastChar >= 0 && lastChar <= 9) {
                            localScore += lastChar;
                        }
                        if (j > 1) {
                            if (j === 2 && lastChar === "1") {
                            }
                            localStrScore += lastChar;
                        }

                        localScore = parseInt(localScore);
                    }

                    tempHighscore = localScore + localStrScore;
                    tempHighscoresArray.push(tempHighscore);
                    tempHighscoresObject.score = localScore;
                    tempHighscoresObject.scoreStr = localStrScore;

                    tempHighscoresObjectsArray.push(tempHighscoresObject);
                    tempLocalSCoreArray.push(localScore);
                    localScore = 0;
                    localStrScore = "";
                    tempHighscoresObject = {};
                }
                tempLocalSCoreArray.sort(function (a, b) {
                    return b - a;
                });
                var sortedScoresCompleteArray = [];
                var flagged = [];
                tempLocalSCoreArray.forEach(function (element) {
                    tempHighscoresObjectsArray.forEach(function (object, index) {
                        if (element === object.score && !flagged.includes(index)) {
                            flagged.push(index);

                            var tempScoreString = object.scoreStr + " " + object.score;
                            sortedScoresCompleteArray.push(tempScoreString);
                        }
                    });
                });
                for (i = 0; i < sortedScoresCompleteArray.length; i++) {
                    var highScoreElement = document.createElement("li");
                    highScoreElement.textContent = sortedScoresCompleteArray[i];
                    for (j = sortedScoresCompleteArray[i].length - 1; j >= 0; j--) {
                        lastPos = sortedScoresCompleteArray[i].length - 1;
                        lastChar = sortedScoresCompleteArray[i][lastPos - j];
                        if (lastChar && lastChar >= 0 && lastChar <= 9) {
                            localScore += lastChar;
                        }
                        if (j > 1) {
                            localStrScore += lastChar;
                        }

                        localScore = parseInt(localScore);
                    }

                    tempHighscore = localScore + localStrScore;

                    if (localScore > 80 && localScore <= 100) {
                        highScoreElement.setAttribute(
                            "class",
                            "list-group-item list-group-item-success"
                        );
                    } else if (localScore > 70 && localScore <= 80) {
                        highScoreElement.setAttribute(
                            "class",
                            "list-group-item list-group-item-info"
                        );
                    } else if (localScore > 60 && localScore <= 70) {
                        highScoreElement.setAttribute(
                            "class",
                            "list-group-item list-group-item-primary"
                        );
                    } else if (localScore > 50 && localScore <= 60) {
                        highScoreElement.setAttribute(
                            "class",
                            "list-group-item list-group-item-warning"
                        );
                    } else if (localScore <= 50) {
                        highScoreElement.setAttribute(
                            "class",
                            "list-group-item list-group-item-danger"
                        );
                    }

                    highScoresList.append(highScoreElement);
                    tempHighscoresArray.push(tempHighscore);
                    tempHighscoresObject.score = localScore;
                    tempHighscoresObject.scoreStr = localStrScore;
                    tempHighscoresObjectsArray.push(tempHighscoresObject);
                    tempLocalSCoreArray.push(localScore);
                    localScore = 0;
                    localStrScore = "";
                    tempHighscoresObject = {};
                }
            }

            function clearHighscores() {
                localHighscoresArray = [];
                localStorage.setItem("highscore", localHighscoresArray);
                loadHighScores();
            }

        </script>
    </body>
</html>