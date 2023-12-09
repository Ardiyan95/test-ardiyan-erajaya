@include('layouts/header')

<div class="container">
    <header class="col text-center p-4">
        <h2>Quiz</h2>
    </header>
    <section class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="staticBackdropLabel">Highscores</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="highScoresList"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="clearHighscoresBtn">Clear Highscores</button>
                </div>
            </div>
        </div>
    </section>
    
    <section class="card" style="width: 60%; margin: 0 auto;">
        <section class="card-header pt-0 pb-0" style="background-color: #248fa1; color: #ffffff;">
            <div class="row row-cols-12">
                <div class="col text-center">
                    <p class="mb-0" id="timeP">Available Time 
                        <strong><span id="timeSpan"></span></strong>
                    </p>
                </div>
            </div>
        </section>

        <section class="card-body" style="border: solid 5px #248fa1;">
            <section class="card bg-dark text-white" id="introduction" style="height: 350px;">
                <div class="card-img-overlay text-center mt-3">
                    <h3 class="card-title">Selamat datang di Quiz kami</h3>
                    <hr/ style="border-color: #ffffff;">
                    <p class="card-text"> Kerjakan soal-soal yang telah kami sediakan dengan benar!</p>
                    <p class="card-text"> Anda memiliki waktu 15 Menit untuk menjawab soal yang telah kami sediakan</p>
                    <h3 class="card-text"> Good Luck!</h3>
                </div>
            </section>
            <a href="#" class="btn btn-primary" id="startBtn">Start Quiz</a>
            <section id="quiz">
                <h6 id="question">Question 1 xxx xxxx xxx xxx xxx xxx</h6>
                <div class="row row-cols-1 row-cols-md-12">
                    <div class="col">
                        <div class="list-group mb-12" id="answers"></div>
                    </div>
                </div>
            </section>

            <section id="allDone">
                <div class="alert alert-success mt-0 mb-0">
                    <h4 class="alert-heading">Selamat anda telah menyelesaiakan Quiz!</h4>
                    <hr />
                    <h5 class="mb-0">Score anda : <span id="finalScore">xx</span></h5>
                    <hr />
                    <form class="form-inline" style="display: none;">
                        <input class="form-control mr-2" type="text" id="initials"
                            placeholder="Enter your initials" />
                        <button type="submit" class="btn btn-info" id="submit">
                            Submit
                        </button>
                    </form>
                </div>
            </section>
        </section>
        
        <div class="card-footer text-muted p-0" style="background-color: #1f7d8d;">
            <div class="progress" style="height: 100%; background-color: #1f7d8d;">
                <div class="progress-bar bg-info progress-bar-striped progress-bar-animated"
                    style="width: 0%; height: 100%;"></div>
            </div>
            <div class="alert alert-success mt-0 mb-0 pt-0 pb-0" id="assess-ft">
                <strong></strong>
            </div>
        </div>
    </section>
</div>

@include('layouts/footer')