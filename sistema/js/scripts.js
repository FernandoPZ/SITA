//Previsualiza las imagenes subidas
function archivo(evt) {
    var foto = evt.target.files; // Espacio donde se sube la imagen
    for (var i = 0, f; f = foto[i]; i++) { // Obtenemos la imagen del campo "foto"
    if (!f.type.match('image.*')) { //Solo admitimos imágenes.
        continue;
    }
    var reader = new FileReader();
    reader.onload = (function(theFile) {
        return function(e) {
        document.getElementById("previsual").innerHTML = ['<img class="img-rounded" width="245" height="245" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join(''); // Insertamos la imagen
        };
    })(f);
    reader.readAsDataURL(f); // ???
    }
}
document.getElementById('foto').addEventListener('change', archivo, false); // Llama elementos para identificar

/*
[Scripts en JavaScript]
Ultima modificacion -- [13/07/2022 (11:48 hrs)]
*/