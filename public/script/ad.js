document.addEventListener("DOMContentLoaded", () => {
  var favBtn = document.getElementById('favBtn');
  var favImg = document.getElementById('favImg');
  var signalBtn = document.getElementById('notifBtn');
  var signalImg = document.getElementById('notifImg');

  function sendRequest(url, callback) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", url);
    xmlhttp.setRequestHeader("Content-type", "application/json; charset=utf-8");
    xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xmlhttp.send("");

    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        try {
          var response = JSON.parse(xmlhttp.responseText);
          callback(response);
        } catch (e) {
          console.error("Error parsing response:", e);
          console.error('Status:', xmlhttp.status);
          console.error('Response:', xmlhttp.responseText);
        }
      } else if (xmlhttp.readyState == 4) {
        console.error('Request failed with status:', xmlhttp.status);
        console.error('Response:', xmlhttp.responseText);
      }
    }
  }

  favBtn.addEventListener('click', () => {
    var url = "/dynamhaus/user/updateFavorite/" + window.location.href.split("/").slice(-1).join("/");
    sendRequest(url, (response) => {
      if (response.state === "ok") {
        if (response.favoriteState === 0) {
          favBtn.style.backgroundColor = "rgb(104, 155, 255)";
          favImg.setAttribute('src', '/dynamhaus/public/icons/heart.svg');
          console.log("Favorite added");
        } else if (response.favoriteState === 1) {
          favBtn.style.backgroundColor = "red";
          favImg.setAttribute('src', '/dynamhaus/public/icons/heartWhite.svg');
          console.log("Favorite removed");
        }
      }
    });
  });

  signalBtn.addEventListener('click', () => {
    var url = "/dynamhaus/report/" + window.location.href.split("/").slice(-1).join("/");
    sendRequest(url, (response) => {
      if (response.state === "ok") {
        if (response.reportState === 0) {
          signalImg.setAttribute('src', '/dynamhaus/public/icons/notifInactive.svg');
          console.log("Reported inactive");
        } else if (response.reportState === 1) {
          signalImg.setAttribute('src', '/dynamhaus/public/icons/notifActive.svg');
          console.log("Reported active");
        }
      }
    });
  });

});

