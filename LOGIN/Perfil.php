<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
     <title>VaidrollTeamLogin8</title>
     <link rel="stylesheet" href="style.css">	
</head>
<body>

<div class="caja1">
        <div class="botondeintercambiar">
            <div id="btnvai"></div>
             <button type="button" class="botoncambiarcaja" onclick="loginvai()" id="vaibtnlogin">Login</button>
             <button type="button" class="botoncambiarcaja" onclick="registrarvai()" id="vaibtnregistrar">Registrar</button>
		</div>
<form method="post" action="login.php" id="frmlogin" class="grupo-entradas">
<div class="ub1">&#128273; Ingresar usuario</div>
<input type="text" name="txtusuario" placeholder="Ingresar usuario">
<div class="ub1">&#128274; Ingresar password</div>

<input type="password" name="txtpassword" id="txtpassword" placeholder="Ingresar password">

<div class="ub1">
<input type="checkbox" onclick="verpassword()" >Mostrar contraseña
 </div>
<div class="ub1">Rol</div>
<select name="rol">
<option value="0" style="display:none;"><label>Seleccionar</label></option>
<option value="Usuario">Usuario</option>
<option value="Admin">Administrador</option>
</select>

<div align="center">
<input type="submit" value="Ingresar">

<input type="reset" value="Cancelar">
</div>
</form>

<form method="post" action="registrar.php" id="frmregistrar" class="grupo-entradas">
<div class="ub1">&#128273; Ingresar usuario</div>
<input type="text" name="txtusuario2" placeholder="Ingresar usuario">
<div class="ub1">&#128274; Ingresar password</div>

<input type="password" name="txtpassword2" id="txtpassword2" placeholder="Ingresar password">

<div class="ub1">
<input type="checkbox" onclick="verpassword2()" >Mostrar contraseña
 </div>
<div class="ub1">Rol</div>
<select name="rol">
<option value="0" style="display:none;"><label>Seleccionar</label></option>
<option value="Usuario">Usuario</option>
<option value="Admin">Administrador</option>
</select>

<div align="center">
<input type="submit" value="Registrar">

<input type="reset" value="Cancelar">
</div>
</form>
</div>

</body>
<script>
  function verpassword()
  {
      var tipo = document.getElementById("txtpassword");
      if(tipo.type == "password")
	  {
          tipo.type = "text";
      }
	  else 
	  {
          tipo.type = "password";
      } 
  }
    function verpassword2()
  {
      var tipo = document.getElementById("txtpassword2");
      if(tipo.type == "password")
	  {
          tipo.type = "text";
      }
	  else 
	  {
          tipo.type = "password";
      } 
  }
  
    var x = document.getElementById("frmlogin");
    var y = document.getElementById("frmregistrar");
    var z = document.getElementById("btnvai");


        function registrarvai()
		{
			
            x.style.left = "-400px";
            y.style.left = "50px";
            z.style.left = "110px";

	
        }
            function loginvai()
		{
			
            x.style.left = "50px";
            y.style.left = "450px";
            z.style.left = "0";


        }
		

</script>
</html>