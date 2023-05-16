@extends('layouts.app')

@section('content')


<h1> Examination on {{$exam->materi}} </h1>



<div>
        <div id="time" class="sidebar-nav-fixed affix">
            <h1><b>Time <span id="time" style="color: red">0.00</span></b></h1><br>
        </div>

        <legend>Choose the correct answer</legend>
        <form method="post" action="{{route('jawaban.store', compact('question'))}}" class="ansform">
            @foreach($question as $questions)
            <div class="col-md-6 col-lg-8 col-sm-6 col-lg-offset-2">
                {{ csrf_field() }}

                <h3>{{$questions->soal}} ?</h3>
                <div class="col-lg-offset-1">

                    <fieldset>
                        <input type="hidden" readonly name="question" value="{{$questions->soal}}">
                        <input name="answer_{{ $questions->id }}" value="{{ $questions->jawaban_a }}" type="radio">
                        {{ $questions->jawaban_a }} <br>
                        <input name="answer_{{ $questions->id }}" value="{{ $questions->jawaban_b }}" type="radio">
                        {{ $questions->jawaban_b }}<br>
                        <input name="answer_{{ $questions->id }}" value="{{ $questions->jawaban_c }}" type="radio">
                        {{ $questions->jawaban_c }}<br>
                        <input name="answer_{{ $questions->id }}" value="{{ $questions->jawaban_d }}" type="radio">
                        {{ $questions->jawaban_d }}<br>
                        <input type="hidden" readonly name="correct_answer_{{$questions->id}}"
                            value="{{$questions->jawaban}}">
                        <input type="hidden" readonly name="materi" value="{{$exam->materi}}">
                        @auth
                        <input type="hidden" readonly name="student_id" value="{{ Auth::user()->id }}">
                        @endauth
                    </fieldset>



            <!-- <input type="hidden" name="question" value="{{$questions->question}}">
            <input type="hidden" name="true_answer" value="{{$questions->answer}}">
            <input name="answer" value="{{$questions->choice}}" type="radio"> {{$questions->jawaban_a}} <br>
            <input name="answer" value="{{$questions->choice}}" type="radio">{{$questions->jawaban_b}}<br>
            <input name="answer" value="{{$questions->choice}}" type="radio">{{$questions->jawaban_c}}<br>
            <input name="answer" value="{{$questions->jawaban_a}}" type="radio">{{$questions->jawaban_d}}<br> -->

                </div>
            </div>
            @endforeach
            <input type="submit" name="submit" value="submit" class="btn btn-primary" id="submitbtn">
        </form>

        <script type="text/javascript">
    var timeoutHandle;

    function saveAnswer(questionId) {
        var selectedAnswer = document.querySelector('input[name="answer_' + questionId + '"]:checked');
        if (selectedAnswer) {
            var answerKey = 'answer_' + questionId;
            var answerValue = selectedAnswer.value;
            var savedAnswers = localStorage.getItem('saved_answers');
            var answersObj = savedAnswers ? JSON.parse(savedAnswers) : {};
            answersObj[answerKey] = answerValue;
            localStorage.setItem('saved_answers', JSON.stringify(answersObj));
        }
    }

    // Call the saveAnswer() function when a radio button is clicked
    var radioButtons = document.querySelectorAll('input[type="radio"]');
    radioButtons.forEach(function (radioButton) {
        radioButton.addEventListener('click', function () {
            var questionId = this.name.split('_')[1];
            saveAnswer(questionId);
        });
    });

    function countdown(minutes) {
        var seconds = 60;
        var mins = minutes

        function tick() {
            var counter = document.getElementById("time");
            var current_minutes = mins - 1
            seconds--;
            counter.innerHTML =
                current_minutes.toString() + ":" + (seconds < 10 ? "0" : "") + String(seconds);

            if (seconds > 0) {
                timeoutHandle = setTimeout(tick, 1000);
            } else {
                if (mins > 1) {
                    setTimeout(function () {
                        countdown(mins - 1);
                    }, 1000);
                }
            }
        }

        tick();
    }

    countdown(<?php echo $exam->waktu; ?>);

    function showWarning() {
        alert("Only 5 minutes left!");
    }

    // script for disable url 
    var time = '<?php echo $exam->waktu; ?>';
    var realtime = time * 60000;

    setTimeout(function () {
        alert('Waktu sudah habis');
        window.location.href = '/';
    }, realtime);
</script>
        @endsection
