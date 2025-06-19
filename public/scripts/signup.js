document.addEventListener('DOMContentLoaded', ()=> {
    var login =  document.getElementById("login");
    var span = document.getElementById('login-regex');
    login.addEventListener("input",(event) =>{
        if (login.value.length<8) {
            span.innerHTML='Login trop court'
            span.style.display="block";
        } else {
            span.innerHTML='';
            span.style.display="none";
            span.style.marginRight="100px";
        }
    })
})
