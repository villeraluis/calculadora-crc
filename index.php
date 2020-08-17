<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Lasiguiente linea agrega los estilos css de Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Calculadora crc</title>
</head>

<body>


    <div class="container-fluid text-center">
        <h2 class="mt-5">Calculadora crc </h2>


        <a id="carga" type="button" class="btn btn-success btn-lg " data-toggle="modal" href="#exampleModalCenter">
            Iniciar Calculadora
        </a>

    </div>




    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade text-center" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content text-center">
                <div class="  text-center ">
                    <button type="button " class="close text-left p3" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLongTitle">Calculadora Error CRC</h5>

                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"> Datos Enviados</label>
                            <input type="text" onkeypress="if ( ( String.fromCharCode(event.keyCode) !=0) && 
                            ( String.fromCharCode(event.keyCode) !=1)) return false;" class="form-control text-center" id="datos">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Generador</label>
                            <input type="text" onkeypress="if ( ( String.fromCharCode(event.keyCode) !=0) && 
                            ( String.fromCharCode(event.keyCode) !=1)) return false;" class="form-control text-center" id="generador">
                        </div>
                    </form>

                    <button type="button" class="btn btn-success col-6 m-2" onclick=" calcular()">Calcular crc</button>
                    <!-- <button type="button" class="btn btn-primary col-6">Verificar</button>-->



                    <div class=" text-center">
                        <label for="message-text" class="col-form-label">Resultados</label>
                        <textarea class="form-control text-center" id="resultado" style="margin-top: 0px; margin-bottom: 0px; height: 250px;"></textarea>


                    </div>
                </div>
            </div>


            <!-- las siguientes lineas contienen los cdn de botstrap para ejecutar su javascript -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
<script>
    $(document).ready(function() {
        $('#exampleModalCenter').modal('toggle')
    });


    function calcular() {

        datos = (document.getElementById("datos").value);
        generador = (document.getElementById("generador").value);



        resultado = divicion(datos, generador);

        var convertido = convertirHexa(datos + resultado);

        if (datos != null || generador != null) {
            document.getElementById('resultado').value = "El valor del CRC es : " + resultado +
                "\n La trama total a enviar es: " +
                datos + resultado + "\n El numero en hexadecimal es :  " + convertido;
        } else {
            document.getElementById('resultado').value = "No hay datos";
        }

    };


    //resta o suma en aritmetica modulo 2 de dos numeros
    function resta(n1, n2) {

        var nu1 = n1.split("");
        var nu2 = n2.split("");

        var resulta = [];
        for (var i = 0; i < n1.length; i++) {

            var num1 = parseInt(nu1[i]);
            var num2 = parseInt(nu2[i]);
            resulta[i] = (num1 ^ num2);

        }
        return resulta.join('');
    };

    // divicion de dos binarios.

    //el algoritmo seria.
    // agragarle los ceros necesarios al final.

    //dividir en divisor y sacar los primeros bits de manera que dividendo y divisor tengan misma cantidad.
    //hacer la resta en modulo 2.
    //revisar el resultado y tomar solo desde donde se encuentra un 1 hacia la derecha.
    //tomar eso bits y añadirlos a la acbezera del arrglo donde quedo en resto de bits del dividendo.
    //revisar si no empieza por cero de ser asi eliminar hasta donde encuentre le primer 1
    // repetir hasta que la longitud del divisor sea igual al dividendo.


    //guardar el resultado de la ultima resta ese es el crc. solo habria que tomar las ultimas cifras que sel le agregaron al principio.

    function divicion(n1, n2) {

        var nu1 = n1.split("");
        var nu2 = n2.split("");
        var resulta = [];
        var tempon1 = [];
        var restotemp = [];
        var contador;
        tempon1 = nu1;
        var ceros = [];

        //un pequeño ciclo para agrgar los ceros al final
        for (var i = 0; i < nu2.length - 1; i++) {
            ceros[i] = 0;
        }
        nu1 = nu1.concat(ceros);

        // window.alert("nuevo nu1   "+nu1)
        /////////////////

        while (nu1.length >= nu2.length) {
            var minuendo = nu1.splice(0, nu2.length);
            var sustraendo = nu2;
            restotemp = resta(minuendo.join(''), sustraendo.join(''));
            //window.alert("esto vale resto   " + restotemp);
            //window.alert("esto vale minuendo   " + minuendo + " y sustraendo  -- " + sustraendo);
            contador = 0;
            for (var i = 0; i <= restotemp.length; i++) {
                if (restotemp[i] == 1) {
                    contador = i;
                    break;
                }
                if (restotemp.length == i) {
                    contador = i;
                    break;
                }
            }
            //window.alert("esto vale contador   " + contador);
            restotemp = restotemp.split('');
            // window.alert("esto vale resto despues del split   " + restotemp);
            if (nu1.length >= nu2.length) {
                restotemp.splice(0, contador);
                //window.alert("esto vale resto despues del splice   " + restotemp);
            }

            tempon1 = restotemp.concat(nu1);
            // window.alert("esto vale nuevo dividendo tempon1 " + tempon1);
            restotemp = [];
            nu1 = tempon1;
            // window.alert("esto vale nuevo dividendo nu1  " + nu1);
            var contador2 = 0;
            for (var i = 0; i <= nu1.length; i++) {
                if (nu1[i] == 1) {
                    contador2 = i;
                    break;
                }
                if (nu1.length == i) {
                    contador2 = i;
                    break;
                }
            }

            //window.alert(" esto vale nu1 " +nu1);
            if (nu1.length == nu2.length) {
                nu1.splice(0, 1);
                resulta = nu1.join('');
                // window.alert("esto resultado dentrodel if  " + resulta);
                break;
            }
            // window.alert("esto vale nu1 lengh " + nu1.length + " el lenh de bnu2   "+ nu2.length+ " "+nu1);
            if (nu1.length >= nu2.length) {
                nu1.splice(0, contador2);
            }

        }

        if (resulta == "") {
            resulta = ceros.join('');
        }


        return resulta;


    }

    /////////////////////////////////

    function convertirHexa(bin) {
        var nuevoBin = bin.split("");
        //window.alert("este es el valorde nuevo Bin al inicio" + nuevoBin)

        var tempo;
        var acumulador="";

        while (nuevoBin.length > 0) {
            // window.alert("este es el valorde nuevo Bin lenght" + nuevoBin.length)

            if (nuevoBin.length > 4) {
                tempo = nuevoBin.splice(nuevoBin.length - 4, 4);
                acumulador = acumulador+ BinarioHexa(tempo);
                // window.alert("este es elalor valorde temp" + tempo)
                //window.alert("este es el valorde acumulador" + acumulador)

            }
            if (nuevoBin.length <= 4) {

                tempo = nuevoBin.splice(0, nuevoBin.length);
                //  window.alert("este es el ultimo valor valorde temp" + tempo)
                acumulador = acumulador+BinarioHexa(tempo);

            }
        }


      var tempoFinal= acumulador.split("");
      var orden=0;
      var numeroFinal=[];
     // window.alert("este es el valorde acumulador   "+ tempoFinal.length)

       for(var i=tempoFinal.length-1;i>=0;i--) {
       // window.alert("este es el valorde acumulador   "+ i)
          numeroFinal[orden]=tempoFinal[i];
          orden++;
       }

     var hexaCompleto=numeroFinal.join('');

   //window.alert("este es el valorde acumulador   "+numeroFinal)


         return hexaCompleto;
    }








    function BinarioHexa(num) {
        //window.alert("este es el valorde num " + num)
        var decimal = 0;
        var conta = 0;
        var hexa = "";
        for (var i = num.length - 1; i >= 0; i--) {

            //  window.alert("este es el valorde i= " + i + " y el valor de conta =" + conta)

            if (num[i] == 1) {

                decimal = decimal + Math.pow(2, conta);
                //window.alert("este es el valorde decimal = " + decimal)
            }
            conta++;

        }

        //window.alert("este es el valorde decimal = " + decimal)

        if (decimal <= 0 || decimal <= 9) {

            hexa = decimal;
           // window.alert("menor que 9 este es el valorde deci =  " + decimal + "el valor de haxa es  " + hexa);

        }

        if (decimal > 9) {

            
            switch (decimal) {

                case 10:
                    hexa = "A";
                    break;

                case 11:
                    hexa = "B";
                    break;
                case 12:
                    hexa = "C";
                    break;
                case 13:
                    hexa = "D";
                    break;
                case 14:
                    hexa = "E";
                    break;
                case 15:
                    hexa = "F";
                    break;







            }
            

        }




      
      //window.alert( "final el valor de haxa es  " + hexa);
      //var salida=salida+hexa;
        return hexa;
        

    }
</script>

</html>