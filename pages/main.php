<section style="background: #ffdde1;
  background: -webkit-linear-gradient(-135deg, #ffdde1, #fcc2d7, #f8a3c7);
  background: -o-linear-gradient(-135deg, #ffdde1, #fcc2d7, #f8a3c7);
  background: -moz-linear-gradient(-135deg, #ffdde1, #fcc2d7, #f8a3c7);
  background: linear-gradient(-135deg, #ffdde1, #fcc2d7, #f8a3c7);
  height: 100%; margin: 0; padding: 0; display: flex; 
  flex-direction: column; min-height: 100vh;">

<section class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32"></svg>
        <span class="fs-4">StudyBunny</span>
      </a>

      <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <a href="" onclick="showTimer()" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32"></svg>
        <span class="fs-4">Timer</span>
      </a>
      <a href="" onclick="showTaskList()" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32"></svg>
        <span class="fs-4">TaskList</span>
      </a>
      </div>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="#" class="nav-link">Account</a></li>
        <li class="nav-item"><form onsubmit="logout(); return false;"> <button class="login100-form-btn" type="submit">Logout</button></form></li>
      </ul>
    </header>
</section>


<div class="container">
    <!-- Timer Section -->
    <div class="container text-center mt-5" id="timerSection">
        <img src="images/bunny.png" alt="Bunny">
        <h1 class="mb-4">StudyBunny Timer</h1>
        <div class="btn-group mb-4" role="group" aria-label="Timer Types">
            <button class="btn btn-primary" onclick="setTimer(25)">Regular (25 min)</button>
            <button class="btn btn-success" onclick="setTimer(5)">Short Break (5 min)</button>
            <button class="btn btn-warning" onclick="setTimer(15)">Long Break (15 min)</button>
        </div>

        <div class="display-1" id="timerDisplay">25:00</div>
        
        <div class="mt-4">
        <div class="button-container">
            <!-- Start/Stop Button -->
            <button id="startStopButton" class="btn-carrot" onclick="startStopTimer()">
                <img src="images/carrot.png" alt="Start" id="carrotImage">
                <span id="startText">Start</span>
            </button>

            <!-- Reset Button -->
            <button id="resetBtn" class="btn-carrot" onclick="resetTimer()">
                <img src="images/carrot.png" alt="Reset" id="carrotImageReset">
                <span>Reset</span>
            </button>
        </div>
        </div>
    </div>

    <!-- TaskList Section (Initially Hidden) -->
<div class="container text-center mt-5" id="taskListSection" style="display: none;">
    <h1 class="mb-4">Task List</h1>
    <ul class="list-group">
        <li class="list-group-item">Task 1</li>
        <li class="list-group-item">Task 2</li>
        <li class="list-group-item">Task 3</li>
    </ul>
</div>
</div>

</section>

<script>
    let timerDuration = 25 * 60;
    let timeLeft = timerDuration;
    let timer;
    let isRunning = false;

    function setTimer(minutes) {
        timerDuration = minutes * 60;
        timeLeft = timerDuration;
        updateDisplay();
        stopTimer();
    }

    function updateDisplay() {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        document.getElementById('timerDisplay').textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    function startStopTimer() {
        if (isRunning) {
            stopTimer();
        } else {
            startTimer();
        }
    }

    function startTimer() {
        isRunning = true;
        document.getElementById('startText').textContent = 'Stop';
        document.getElementById('carrotImage').src = 'images/carrot_stop.png'; // Change image when timer starts
        timer = setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                updateDisplay();
            } else {
                stopTimer();
                alert('Time is up!');
            }
        }, 1000);
    }

    function stopTimer() {
        isRunning = false;
        clearInterval(timer);
        document.getElementById('startText').textContent = 'Start';
        document.getElementById('carrotImage').src = 'images/carrot.png'; // Revert image back when timer stops
    }

    function resetTimer() {
        timeLeft = timerDuration;
        updateDisplay();
        stopTimer();
    }

    // View Toggling Logic
    function showTimer() {
        document.getElementById('timerSection').style.display = 'block';
        document.getElementById('taskListSection').style.display = 'none';
    }

    function showTaskList() {
        document.getElementById('taskListSection').style.display = 'block';
        document.getElementById('timerSection').style.display = 'none';
    }

    // Initialize Display
    updateDisplay();

    // Initialize Display
    updateDisplay();
</script>

<style>
    /* New Enlarged carrot button with text inside */
    .btn-carrot {
        width: 100px; /* Increase the size of the carrot button */
        height: 100px; /* Increase the size */
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center; /* Center the text inside */
    }

    .btn-carrot img {
        width: 60px; /* Adjust carrot image size */
        height: auto;
        margin-bottom: 5px; /* Space between image and text */
    }

    .btn-carrot span {
        font-size: 16px;
        color: #000;
    }

    .button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 30px;
    }

    /* Other styles */
    body {
        background-color: rgb(243, 229, 233);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
        font-family: 'Nunito', sans-serif;
        margin: 0;
    }

    .nav-buttons {
        position: absolute;
        top: 10px;
        left: 10px;
        display: flex;
        gap: 10px;
    }

    .nav-buttons button {
        background-color: white;
        border: 1px solid #ccc;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    img {
        max-width: 250px;
    }

    .text {
        font-size: 40px;
        color: #0c0909;
        margin-top: -5px;
    }

    table {
        width: 300px;
        height: 150px;
        margin-top: 10px;
        background-color: white;
        border-radius: 8px;
        text-align: center;
    }

    td {
        padding: 30px;
        border: 1px solid #ddd;
    }
</style>
