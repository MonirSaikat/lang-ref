<!DOCTYPE html>
<html>

<head>
    <title>PHP Function Search</title>
    <style>
        /* Global Styles */
        :root {
            --color-base: #3e8e41;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 1rem;
        }

        /* Container Styles */
        .container {
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Search Form Styles */
        .search-box {
            position: sticky;
            top: 0;
            left: 0;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            border-radius: 10px;
        }

        .search-form {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
        }

        .search-input {
            width: 100%;
            height: 40px;
            padding: 10px;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
            outline-color: var(--color-base);
        }

        .search-button {
            height: 40px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: var(--color-base);
        }

        /* Results Table Styles */
        #results {
            border-collapse: collapse;
            width: 100%;
        }

        #results th,
        #results td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        #results th {
            background-color: #f0f0f0;
        }

        #results tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .method_name {
            color: #095ae3;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="search-box">
        <form class="search-form">
            <input type="text" class="search-input" autofocus id="search-input" placeholder="Search for a function...">
            <button class="search-button" type="submit">Search</button>
        </form>
    </div>

    <div class="container hidden">
        <table id="results">
            <thead>
                <tr>
                    <th>Function Name</th>
                    <th>Parameters</th>
                    <th>Return Type</th>
                    <th>Summary</th>
                </tr>
            </thead>
            <tbody id="results-body"></tbody>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchForm = document.querySelector('.search-form');
            const searchInput = document.querySelector('#search-input');
            const resultsBody = document.querySelector('#results-body');

            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const search = searchInput.value.trim();
                if (search !== '') {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', 'php_functions.php?search=' + encodeURIComponent(search), true);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            const data = JSON.parse(xhr.responseText);

                            if(data.length > 0) document.querySelector('.container').classList.remove('hidden');
                            else document.querySelector('.container').classList.add('hidden');
                            
                            resultsBody.innerHTML = '';
                            data.forEach(function(functionData) {
                                const tableRow = document.createElement('tr');
                                tableRow.innerHTML = `
                                    <td class="method_name"><strong>${functionData.name}</strong></td>
                                    <td>${functionData.params.join(', ')}</td>
                                    <td>${functionData.return_type}</td>
                                    <td>${functionData.summary}</td>
                                `;
                                resultsBody.appendChild(tableRow);
                            });
                        }
                    };
                    xhr.send();
                }
            });
        });
    </script>
</body>

</html>