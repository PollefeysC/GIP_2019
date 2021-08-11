window.onscroll = function() {scrollFunction()};

function scrollFunction() {
if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
    document.getElementById("logo").style.marginTop = "-18px";
    document.getElementById("logo").style.marginBottom = "-18px";
    } else {
    document.getElementById("logo").style.marginTop = "-6px";
    document.getElementById("logo").style.marginBottom = "-6px";
    }
}