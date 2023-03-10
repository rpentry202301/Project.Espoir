function formSwitch() {
    check = document.getElementsByName("maker");
    if (check[0].checked) {
        document.getElementById("registerForm").style.display = "";
        document.getElementById("editForm").style.display = "none";
    } else if (check[1].checked) {
        document.getElementById("registerForm").style.display = "none";
        document.getElementById("editForm").style.display = "";
    } else {
        document.getElementById("registerForm").style.display = "none";
        document.getElementById("editForm").style.display = "none";
    }
}
window.addEventListener("load", formSwitch());
