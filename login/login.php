<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include '../dependencies.html'; ?>
    <title>Login</title>
</head>
<body>
    <?php include '../navbar.html'; ?>

    <div class="container">
        <form>
            <div class="form-group">
                <label for="loginField">Login</label>
                <input type="text" class="form-control" id="loginField" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="passwordField">Password</label>
                <input type="password" class="form-control" id="passwordField">
            </div>
            <button type="button" class="btn btn-primary" id="signInButton">Sign In</button>
        </form>
    </div>


    <script>
        let loginField=document.getElementById("loginField");
        let passwordField=document.getElementById("passwordField");
        let signInButton= document.getElementById("signInButton");

        signInButton.addEventListener("click", function () {
            signIn();
        })
        function signIn() {
            let login=loginField.value;
            let password=passwordField.value;
            let credentials = {login: login, password: password};
            console.log(JSON.stringify(credentials));
            let xhr = new XMLHttpRequest();
            xhr.responseType="json";
            xhr.withCredentials=true;
            xhr.onload=function () {
                console.log(xhr.response);
            };
            xhr.open("post", "http://127.0.0.1:8000/login", true);
            xhr.send(JSON.stringify(credentials));
        }
    </script>
</body>
</html>
