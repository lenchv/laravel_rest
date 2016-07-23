<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
            ul > li {
                margin: 10px 0;
                text-align: left;
            }
            ul > li>span {
                color: #42A5F5;
            }
            ul > li:hover {
                cursor: pointer;
                text-decoration: underline;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.1.0.js" integrity="sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1>Результат в консоли</h1>
                <h2>Книги</h2>
                <ul>
                    <li id="book_list"><span>Список книг</span></li>
                    <li id="book_create"><span>Создать книгу</span><br />
                        <input type="text" name="title" placeholder="title"><br>
                        <input type="text" name="author" placeholder="author"><br>
                        <input type="text" name="year" placeholder="year"><br>
                        <input type="text" name="genre" placeholder="genre"><br>
                    </li>
                    <li id="book_delete"><span>Списать книгу с ид</span>: <input type="text"></li>
                    <li id="book_about"><span>Информация о книге с ид</span>:  <input type="text"></li>
                </ul>
                <h2>Пользователь</h2>
                <ul>
                    <li id="user_book_list"><span>Список книг пользователя с ид</span>: <input type="text"></li>
                    <li id="user_book_delete"><span>Удалить запись пользователя в библиотеке с ид</span>: <input type="text"></li>
                    <li id="user_book_create"><span>Выдать книгу пользователю</span><br />
                        <input type="text" name="user_id" placeholder="user_id"><br>
                        <input type="text" name="book_id" placeholder="book_id"><br>
                    </li>
                    <li id="user_about"><span>Информация о пользователе с ид</span>:  <input type="text"></li>
                </ul>
            </div>
        </div>

        <script>
            var JsonRpc = function (method, params, id) {
                this.jsonrpc = "2.0";
                this.method = method; 
                this.params = params; 
                this.id = id;
            }
            $("input[type=text]").on("click", function(e) {
                e.stopPropagation();
            })
            $("#book_list").on("click", function () {
                send(new JsonRpc("books", "", ""), "GET");
            });
            $("#book_about").on("click", function (e) {
                send(new JsonRpc("books", "", $(this).find("input[type=text]").val()), "GET");
            });
            $("#book_delete").on("click", function (e) {
                send(new JsonRpc("books", "", $(this).find("input[type=text]").val()), "DELETE");
            });

            $("#book_create").on("click", function (e) {
                var params = {
                    title : $(this).find("input[name=title]").val(),
                    author : $(this).find("input[name=author]").val(),
                    year : $(this).find("input[name=year]").val(),
                    genre : $(this).find("input[name=genre]").val()
                };
                send(new JsonRpc("books", params, ""), "post");
            });

            $("#user_book_list").on("click", function () {
                send(new JsonRpc("userbooks", "", $(this).find("input[type=text]").val()), "GET");
            });
            $("#user_book_delete").on("click", function (e) {
                send(new JsonRpc("userbooks", "", $(this).find("input[type=text]").val()), "DELETE");
            });
            $("#user_book_create").on("click", function (e) {
                var params = {
                    user_id : $(this).find("input[name=user_id]").val(),
                    book_id : $(this).find("input[name=book_id]").val()
                };
                send(new JsonRpc("userbooks", params, ""), "post");
            });

            $("#user_about").on("click", function () {
                send(new JsonRpc("users", "", $(this).find("input[type=text]").val()), "GET");
            });

            var send = function (package, method) {
                package._token = '{{ csrf_token() }}';
                var url = "http://localhost:8000/" + package.method;
                url += (!!package.id) ? "/" + package.id : "";
                $.ajax({
                    url: url,
                    method: method,
                    data: JSON.stringify(package),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (err) {
                        console.error(err.responseJSON);
                    }
                });
            };
        </script>
    </body>
</html>
