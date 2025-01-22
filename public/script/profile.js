document.addEventListener("DOMContentLoaded", () => {
    var nomInput = document.getElementById('nom');
    var prenomInput = document.getElementById('prenom');
   
    var nomBtn = document.getElementById('nomBtn');
    var prenomBtn = document.getElementById('prenomBtn');
   
    console.log(prenomInput);
    console.log(nomInput);
    console.log(nomBtn);
    console.log(prenomBtn);
   
    
    function toggleInput(input) {
     input.disabled = false;
    }
   
    nomBtn.addEventListener('click', () => {
      toggleInput(nomInput);
    });
   
    prenomBtn.addEventListener('click', () => {
      toggleInput(prenomInput);
    });
  });
  
  
  var formAccount = document.getElementById("account-form");
  console.log(formAccount)
  formAccount.addEventListener('submit', (event) => { 
  event.preventDefault();
  console.log('aaa')
  var nom = document.getElementById('nom').value
  var prenom = document.getElementById('prenom').value
  var email = document.getElementById('email').value
  var userData = {
    lastName: nom,
    firstName: prenom,
    email: email,
    avatarUrl: null
  };
  console.log('clicked')
  
  xmlhttp = new XMLHttpRequest();
                  xmlhttp.open("POST", "/dynamhaus/profile", true);
                  xmlhttp.setRequestHeader("Content-type", "application/json; charset=utf-8");
                  xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                  xmlhttp.send(JSON.stringify(userData));
  
                  xmlhttp.onreadystatechange = function () {
                      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                          console.log(xmlhttp.responseText);
                          userCreated = JSON.parse(xmlhttp.responseText).state;
                          console.log(userCreated);
                          if (userCreated === "ok") {
                              console.log('User informations modified');
              alert('Les informations ont bien été modifiées')
                          } else {
                              console.log('User does not exist or Error occured');
                          }
                      } else {
                          console.error('Error creating user');
                          console.error('Status:', xmlhttp.status);
                          console.error('Response:', xmlhttp.responseText);
                      }
                  }
  });
