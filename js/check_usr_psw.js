// Ajouter un event au bouton pour verifier 
// si le formulaire est correctement remplie 


button_submit = document.getElementById("sub");

button_submit.addEventListener("click", function(e) {
    champs1 = document.getElementById('form-login');
    champs2 = document.getElementById('form-psw');
    
    if (champs1.value == "") {
        e.preventDefault();
        champs1.style.borderBottom = `2px solid red `;
    }
    if (champs2.value.length <= 8) {
        e.preventDefault();
        champs2.style.borderBottom = `2px solid red`;
        e.preventDefault();
    }

})
