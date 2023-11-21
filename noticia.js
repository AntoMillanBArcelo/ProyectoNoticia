window.addEventListener("load", function () {
    const enviar = document.getElementById("enviar");
    const fichero = document.getElementById("fileToUpload");
    
    enviar.onclick=function(ev)
    {
        ev.preventDefault();
        if (fichero.files.length>0) 
        {
            var form = new FormData();
            form.append("fichero", fichero.files[0]);
            form.append("submit", "");
            fetch("fichero.php",{ 
                method:"post", 
                body:form}).then(x=>x.text()).then(texto=>(alert(texto)));
        }  
        else
        {
            alert("Debes de introducir un fichero.");
        }    
    }
})