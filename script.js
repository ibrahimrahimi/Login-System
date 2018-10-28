function showPass() {
    var x = document.getElementsByClassName("password");
    var names = '';
    for(var i = 0; i<x.length; i++){
        if(x[i].type === "password"){
            x[i].type = "text";
        }else {
            x[i].type = "password";
        }
    }
    
}