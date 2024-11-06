function loadfile(event){
    var reader = new FileReader();

    reader.onload = function(){
        document.querySelector("#image").src = reader.result;
    }

    reader.readAsDataURL(event.target.files[0]);
}