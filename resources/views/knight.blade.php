<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        form {
            background: #f4f4f4;
            padding: 20px;
            display: inline-block;
            border-radius: 10px;
        }
        input {
            width: 50px;
            text-align: center;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }
        pre {
            text-align: left;
            display: inline-block;
            background: #e8e8e8;
            padding: 10px;
            border-radius: 5px;
        }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chess Knight Path Finder</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        async function findKnightPath(event) {
            event.preventDefault();

            let startX = document.getElementById("start_x").value;
            let startY = document.getElementById("start_y").value;
            let endX = document.getElementById("end_x").value;
            let endY = document.getElementById("end_y").value;

            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            try {
                let response = await fetch("/knight-path", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({
                        start: [parseInt(startX), parseInt(startY)],
                        end: [parseInt(endX), parseInt(endY)]
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                let result = await response.json();

                // Convert path array to a readable list
                let pathText = result.path.map(p => `(${p[0]}, ${p[1]})`).join(" ➝ ");

                document.getElementById("result").innerHTML = `
                <strong>Start:</strong> (${result.start[0]}, ${result.start[1]})<br>
                <strong>End:</strong> (${result.end[0]}, ${result.end[1]})<br>
                <strong>Moves:</strong> ${result.steps}<br>
                <strong>Path:</strong> ${pathText}
            `;

            } catch (error) {
                document.getElementById("result").innerText = "Error: " + error.message;
                console.error("Fetch error:", error);
            }
        }
    </script>
</head>
<body>
<h1>Chess Knight Path Finder</h1>
<form onsubmit="findKnightPath(event)">
    @csrf
    <label>Start Position:</label>
    <input type="number" id="start_x" min="0" max="7" placeholder="X (0-7)" required>
    <input type="number" id="start_y" min="0" max="7" placeholder="Y (0-7)" required><br><br>

    <label>End Position:</label>
    <input type="number" id="end_x" min="0" max="7" placeholder="X (0-7)" required>
    <input type="number" id="end_y" min="0" max="7" placeholder="Y (0-7)" required><br><br>

    <button type="submit">Find Path</button>
</form>

<h2>Result:</h2>
<pre id="result"></pre>

</body>
</html>
