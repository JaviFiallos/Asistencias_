<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Vista/Estilos/login.css">
    <link rel="shortcut icon" href="./Utiles/Imagenes/favicon.png" type="image/x-icon">
    <title>Inicio de Sesión</title>
</head>
<body>
    
<div class="container">
    <div class="illustration">
        <img src="./Utiles/Imagenes/imagenVioleta.png" alt="Illustration" />
    </div>
    <div class="login-form">
        <h2>Sign In</h2>
        <div class="formWrapper">
            <form action="login.php" method="post">
                <div class="input-group">
                    <label for="cedula">Cedula :</label>
                    <div class="input-wrapper">
                        <i class="icon fas fa-user"></i>
                        <input
                            type="text"
                            id="cedula"
                            name="cedula"
                            placeholder="Enter your cedula"
                            required
                        />
                    </div>
                </div>
                <div class="input-group">
                    <label for="password">Password :</label>
                    <div class="input-wrapper">
                        <i class="icon fas fa-lock"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        />
                    </div>
                </div>
                <button type="submit" class="sign-in-btn">Sign In</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
