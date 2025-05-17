<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Jogo da Cobrinha</title>
    <style>
        canvas {
            background-color: #000;
            display: block;
            margin: 20px auto 10px auto;
        }

        #resetBtn {
            display: block;
            margin: 10px auto;
            padding: 10px 10px;
            background-color:rgb(0, 0, 0);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        #resetBtn:hover {
            background-color:rgb(255, 255, 255);
            color: black;
        }

        #score {
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 18px;
            margin-top: 10px;
            color: #333;
            background: #000;
            color: white;
        }

      #score :hover {
        background: white;
        color: #000;
      }        
    </style>
</head>
<body>

<canvas id="snake" width="400" height="400"></canvas>
<button id="resetBtn">Resetar Jogo</button>
<div id="score">Pontuação: 0</div>

<script>
    const canvas = document.getElementById("snake");
    const context = canvas.getContext("2d");
    const box = 20;

    let game;
    let snake, direction, food, score;

    const scoreDisplay = document.getElementById("score");

    function initGame() {
        snake = [];
        snake[0] = {
            x: 10 * box,
            y: 10 * box
        };
        direction = "right";
        food = {
            x: Math.floor(Math.random() * 20) * box,
            y: Math.floor(Math.random() * 20) * box
        };
        score = 0;
        updateScore();

        if (game) clearInterval(game); // Para o jogo anterior
        game = setInterval(startGame, 100);
    }

    function updateScore() {
        scoreDisplay.innerText = "Pontuação: " + score;
    }

    function drawBackground() {
        context.fillStyle = "black";
        context.fillRect(0, 0, 400, 400);
    }

    function drawSnake() {
        for (let i = 0; i < snake.length; i++) {
            context.fillStyle = (i === 0) ? "lime" : "green";
            context.fillRect(snake[i].x, snake[i].y, box, box);
        }
    }

    function drawFood() {
        context.fillStyle = "red";
        context.fillRect(food.x, food.y, box, box);
    }

    document.addEventListener("keydown", updateDirection);

    function updateDirection(event) {
        if (event.key === "ArrowLeft" && direction !== "right") direction = "left";
        if (event.key === "ArrowUp" && direction !== "down") direction = "up";
        if (event.key === "ArrowRight" && direction !== "left") direction = "right";
        if (event.key === "ArrowDown" && direction !== "up") direction = "down";
    }

    function startGame() {
        if (snake[0].x < 0 || snake[0].x >= 400 || snake[0].y < 0 || snake[0].y >= 400) {
            clearInterval(game);
            alert("Game Over! Pontuação final: " + score);
            return;
        }

        for (let i = 1; i < snake.length; i++) {
            if (snake[0].x === snake[i].x && snake[0].y === snake[i].y) {
                clearInterval(game);
                alert("Game Over! Pontuação final: " + score);
                return;
            }
        }

        drawBackground();
        drawSnake();
        drawFood();

        let snakeX = snake[0].x;
        let snakeY = snake[0].y;

        if (direction === "right") snakeX += box;
        if (direction === "left") snakeX -= box;
        if (direction === "up") snakeY -= box;
        if (direction === "down") snakeY += box;

        if (snakeX === food.x && snakeY === food.y) {
            score++;
            updateScore();
            food.x = Math.floor(Math.random() * 20) * box;
            food.y = Math.floor(Math.random() * 20) * box;
        } else {
            snake.pop();
        }

        let newHead = {
            x: snakeX,
            y: snakeY
        };

        snake.unshift(newHead);
    }

    // Botão de reset
    document.getElementById("resetBtn").addEventListener("click", function () {
        initGame();
    });

    // Inicia o jogo na primeira vez
    initGame();
</script>

</body>
</html>
