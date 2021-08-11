function openLogin() {
    document.getElementById('overlay').style.display = "block";
    document.getElementById('logintable').style.display = "table";
    document.getElementById('registertable').style.display = "none";
}

function closeLogin() {
    document.getElementById('overlay').style.display = "none";
}

function changeToSignup() {
    document.getElementById('registertable').style.display = "table";
    document.getElementById('logintable').style.display = "none";
}

function changeToLogin(){
    document.getElementById('registertable').style.display = "none";
    document.getElementById('logintable').style.display = "table";
}