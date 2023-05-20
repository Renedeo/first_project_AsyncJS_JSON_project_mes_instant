/**
 * url du fichier à appeler
 * Section de reception des messages
 * Temps d'activation
 */
const url1 = "./php/fichier1.php";
const elem1 = document.getElementById("usr");
var display_delay = 1000;

/**
 * Met à jour les utilisteurs connecté
 */
function fun1() {
  const xhr = new XMLHttpRequest();

  xhr.addEventListener("readystatechange", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        /**
         * A améliorer
         */
        if (xhr.responseText != "") {
            elem1.innerHTML = " " + xhr.responseText;
          const bottom = elem.scrollHeight - elem.offsetHeight;
          elem.scrollTop = bottom;
        }
      } else {
        console.error("Erreur " + xhr.status + " : " + xhr.statusText);
      }
    }
  });

  xhr.open("GET", url1)
  xhr.send();
}

/**
 * Update les derniers connecté
 */
var interval_id1 = setInterval(() => {
  fun1();
}, display_delay);
