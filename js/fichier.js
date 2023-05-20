/**
 * url du fichier à appeler
 * Section de reception des messages
 * Temps d'affichage de l'update de la page
 * Date d'appel à ce fichier javascript
 * Format de la date d'appel
 */
const url = "./php/fichier.php";
const elem = document.getElementById("receiver");
var display_delay = 1000;
var now = new Date();
format =
  now.getFullYear() +
  "-" +
  (now.getMonth() + 1) +
  "-" +
  now.getDate() +
  " " +
  now.getHours() +
  ":" +
  now.getMinutes() +
  ":" +
  now.getSeconds();

var Rep = ""
var cur_usr = -1
var username = ""
last_message_id = 0
/**
 * Cette fonction s'occupe des différente phases du site tels que
 * ----------------> L'affichage de tous les messages au
 * -------------------- chargement de la page
 *
 * ----------------> L'update des message en affichant les derniers messages
 * ------------------ entré dans la base
 *
 * ----------------> L'envoie des messages à la base de données
 *
 * Tout ceci grace à la fonction xhr (Processus AJAX) communiquant avec
 * le fichier fichier.php
 * @param {boolean} sender Prédicat d'envoie d'un message
 * @param {boolean} update Prédicat de mise à jour des messages9+
 */
function fun_display_all() {
  const xhr = new XMLHttpRequest();

  xhr.addEventListener("readystatechange", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {

          Rep = xhr.responseText;
          var JsonRep = JSON.parse(Rep)
          var user_info = JsonRep['user_info'];
          var user = JsonRep['user'];
          var message_class = document.getElementsByClassName('message')
          console.log(message_class);
          JsonRep['rep'].forEach(mes_info => {
            const mes_user_id = mes_info['id_user']
            const mes_id = mes_info['id_mes']
            const mes_content = mes_info['content']
            const mes_date = mes_info['date']
            const mes_font = user_info[mes_user_id]['font_family']

            // Qui ecrit ?
            var who = 'usr' // moi ou ...
            if (mes_user_id != user) {
              who = 'other' // les autres utilisateurs
            }

            // Identifiant des utilisateurs 
            if (mes_user_id != cur_usr) {
              cur_usr = mes_user_id
              username = user_info[mes_user_id]['username']
              const mes_id_area = document.createElement('p')
              mes_id_area.classList.add('id', 'id-' + who)


              // Identifiant 
              // Ajout de la font family
              var family = document.createElement('span')
              family.className = 'family'
              family.appendChild(document.createTextNode('[' + mes_font + ']'))

              var user_username = document.createElement('span');
              if (mes_user_id != user) {
                user_username.style.fontFamily = mes_font
              }

              user_username.appendChild(document.createTextNode(username))
              mes_id_area.appendChild(user_username);
              mes_id_area.appendChild(document.createTextNode('.'))
              mes_id_area.appendChild(family);
              elem.appendChild(mes_id_area);
            }

            // Division du message
            const mes_div = document.createElement('div')
            mes_div.classList.add('dialog', 'dialog-' + who)

            var mes = document.createElement('p')
            mes.className = 'message'
            mes.appendChild(document.createTextNode(mes_content))

            if (mes_user_id != user) {
              mes.style.fontFamily = mes_font
            }

            mes_div.appendChild(mes)


            //Date 
            const mes_date_area = document.createElement('small')
            mes_date_area.classList.add('date', 'date-' + who)

            var date = document.createTextNode(mes_date)
            mes_date_area.appendChild(date)

            mes_div.appendChild(mes_date_area);
            elem.appendChild(mes_div);
            last_message_id++;
          });
      } else {
        console.error("Erreur " + xhr.status + " : " + xhr.statusText);
      }
    }
  });

  xhr.open("POST", url);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  let post;
  post = "phase=displayall";
  xhr.send(post);
}

function fun_sender() {
  const xhr = new XMLHttpRequest();

  xhr.addEventListener("readystatechange", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // none
      } else {
        console.error("Erreur " + xhr.status + " : " + xhr.statusText);
      }
    }
  });

  xhr.open("POST", url);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  const milliseconde = new Date().getMilliseconds();
  let post;

  const message_test_area = document.getElementById("mes");
  const message = message_test_area.value;
  message_test_area.value = "";

  post = "phase=send&mes=" +
    message +
    "&date=" +
    format +
    "&date_milliseconds=" +
    milliseconde;
  xhr.send(post);
}


/**
 * Afficher les messages dès l'affichage de la fenetre
 */
window.addEventListener("load", function () {
  fun_display_all();
});


/**
 * Envoie du message
 */
const send_but = document.getElementById("send-button");
send_but.addEventListener("click", function (e) {
  fun_sender();
});

// /**
//  * Update les derniers messages
//  */
// let a = 2;
// let b = 2;
// var interval_id = setInterval(() => {
//   fun();
//   b=a
// }, display_delay);

const DisconnectButton = document.getElementById("log-out");

DisconnectButton.addEventListener("click", (e) => {
  e.preventDefault();
  const url = "mon_site_mes.php?disconnect=T";
  window.location.replace(url);
});
