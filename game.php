<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

// here i have embedded Quiz data in the same game PHP file without creating a new json file
$quizData = [
    "quiz" => [
        [
            "id" => 1,
            "image" => "https://www.sanfoh.com/uob/banana/data/tf6d1b06e6bf0979eef07b010f6n25.png", 
            "equation" => [0, 1, 2, 3, 4, 9, 6, 7, 8],
            "answer" => 5
        ],
        [
            "id" => 2,
            "image" => "https://www.sanfoh.com/uob/banana/data/t1023c22283cc8445d5c0d348e9n2.png", 
            "equation" => [0, 1, 3, 4, 5, 6, 7, 8, 9],
            "answer" => 2
        ],
        [
            "id" => 3,
            "image" => "https://www.sanfoh.com/uob/banana/data/t1539acf2dc756aae70594758e7n97.png", 
            "equation" => [1, 2, 3, 4, 5, 6, 8, 9,0],
            "answer" => 7
        ],
        [
            "id" => 4,
            "image" => "https://www.sanfoh.com/uob/banana/data/t441d7c40caebab95af0dfd8b97n94.png", 
            "equation" => [0, 1, 2, 3, 5, 9, 6, 7, 8],
            "answer" => 4
        ],
        [
            "id" => 5,
            "image" => "https://www.sanfoh.com/uob/banana/data/t99af3124109da797073e3484a3n81.png", 
            "equation" => [0, 2, 3, 4, 5, 6, 7, 8, 9],
            "answer" => 1
        ],
        [
            "id" => 6,
            "image" =>  "https://www.sanfoh.com/uob/banana/data/t1342e6bcc217c658dbae77b820n66.png",
            "equation" => [1, 2, 3, 4, 5, 7, 8, 9,0],
            "answer" => 6
        ],
        [
            "id" => 7,
            "image" =>  "https://www.sanfoh.com/uob/banana/data/t43b2df17f2ac03a439478c605en0.png",
            "equation" => [1, 2, 3, 4, 5, 7, 8, 9,6],
            "answer" => 0
        ],
        [
            "id" => 8,
            "image" =>  "https://www.sanfoh.com/uob/banana/data/t58beac222e7adb19012264c235n78.png", 
            "equation" => [1, 2, 3, 4, 5, 7, 0, 9,6],
            "answer" => 8
        ],
        [
            "id" => 9,
            "image" =>  "https://www.sanfoh.com/uob/banana/data/td6e00bc0e65772405c16bf5134n79.png",
            "equation" => [1, 2, 3, 4, 5, 7, 0, 8,6],
            "answer" => 9
        ],
        [
            "id" => 0,
            "image" =>   "https://www.sanfoh.com/uob/banana/data/tf5ee98cd2d0f07cf40ebb965d2n103.png",
            "equation" => [1, 2, 8, 4, 5, 7, 0, 9,6],
            "answer" => 3
        ],
    ]
];
    //I have added this shuffle function to Shuffle the quiz array to randomize the order of 
    // questions/images

    shuffle($quizData['quiz']);

    //I have used This code to Send quiz data to JavaScript
    echo "<script>let quizData = " . json_encode($quizData['quiz']) . ";</script>";
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Banana Shuffle</title>
        <link rel="stylesheet" href="game.css">
    </head>
    <body>
    <div class="quiz-container">
        <h1>Banana Shuffle</h1>
        <h3>Solve all the Equations. You only got 3 Minutes, Hurry Up!!</h3>
        
        <div class="question">
            <img id="quizImage" src="" alt="Quiz Image">
        </div>
        <input type="text" id="answer" placeholder="Enter your answer">
        <button id="submit">Submit</button>
        <img src="images/quitbtn.png" id="quitButton" alt="Quit">
        <img src="images/refreshbtn.png" id="refreshButton" alt="Refresh">
        <div id="result"></div>
        <div id="score">Score: 0</div>
        <div id="timer">03:00</div>
        <div id="popup" class="popup hidden"></div>
    </div>

    <script>
        let currentQuestionIndex = 0;
        let score = 0;

        // Here is the JS Timer functionality 
        let seconds = 180;     //timer is set for 3 minutes, this 3 minutes is to solve all the 10 puzzles
        let timer = setInterval(function () {
            seconds--;
            let mins = Math.floor(seconds / 60);
            let secs = seconds % 60;
            document.getElementById("timer").textContent =
                (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;

            if (seconds <= 0) {
                clearInterval(timer);
                alert("Time's up! Game over.");
                document.getElementById("answer").disabled = true;
                document.getElementById("submit").disabled = true;
            }
        }, 1000);

        //I have Used this function to Display the first question
        function loadQuestion() {
            const question = quizData[currentQuestionIndex];
            document.getElementById("quizImage").src = question.image;
            document.getElementById("answer").value = ""; // Clear previous input
            document.getElementById("result").textContent = ""; // Clear result message
        }
        loadQuestion();

        // Submit answer functionality (here i have made function for that when a user enter the 
        // correct answer the score will increase by 10 and another new puzzle image will appear)

        document.getElementById("submit").addEventListener("click", function () {
            const userAnswer = document.getElementById("answer").value.trim();
            const correctAnswer = quizData[currentQuestionIndex].answer;

            if (userAnswer == correctAnswer) {
                document.getElementById("result").textContent = "Correct!";
                score += 10;
                document.getElementById("score").textContent = "Score: " + score;

                currentQuestionIndex++;
                if (currentQuestionIndex < quizData.length) {
                    loadQuestion();
                } else {
                    alert("You've completed all questions! Final Score: " + score);
                }
            } else {
                showAlert();
            }
            });

       //This is the Custom alert when the user enter the incorrect answer
            function showAlert() {

        // Disable input and submit button (This function is used to disable the text box and the submit 
        // button when the user enter an incorrect answer)
            document.getElementById("answer").disabled = true;
            document.getElementById("submit").disabled = true;

            const popup = document.getElementById("popup");
            popup.innerHTML = `
                <div class="alert">
                    <p>Answer is wrong!</p>
                    <button onclick="reloadPage()">Try Again</button>
                </div>
            `;
            popup.classList.remove("hidden");
             }

            // Reload the page for "Try Again"
            function reloadPage() {
                document.getElementById("popup").classList.add("hidden");
                location.reload();
            }


        // Refresh button functionality
        document.getElementById("refreshButton").addEventListener("click", function () {
            location.reload();
        });

        // Quit button functionality
        document.getElementById("quitButton").addEventListener("click", function () {
            window.location.href = "home.php";
        });
    </script>
</body>
</html>
