// Variable pour stocker le prénom
let prenom = "";

let headerCouleurs;
let cavaOrNoCava;
let cavaChecker;


function messageNvllPag(valueOption) {
    if (valueOption === "cc") {
        alert(":\n)");
    } else {
        alert(`${valueOption}Bienvenue su${valueOption}r la page !${valueOption}`);
    }
}

function oimclick() {
    let click = document.querySelector("#clikc");
    click.setAttribute("hidden", true);
}

// Fonction appelée à chaque clic sur un bouton radio
function updatePrenom(letter) {
    prenom += letter; // Ajoute la lettre au prénom
    document.getElementById("prenomHidden").value = prenom; // Met à jour le champ caché
}


function chanceDeCouleurHeader() {
    let header = document.querySelector("body").querySelector("header");
    //console.log(header.style.backgroundColor);
    let color = ["red", "blue", "#00ff23", "yellow", "#d900ff", "black", "white"];
    header.style.backgroundColor = color[Math.floor(Math.random() * color.length)];
}


function cava() {
    let chanceToGo = Math.floor(Math.random() * 100);
    if (chanceToGo <= 10) {
        anAlert("Cava ?");
    }
}


function anAlert(message) {
    clearInterval(cavaOrNoCava);
    cavaOrNoCava = true;

    document.getElementById('fenetreMessageAlerte').style.display = 'flex';
    let randomTop = Math.floor(Math.random() * 75);
    let randomLeft = Math.floor(Math.random() * 75);
    document.getElementById('fenetreMessageAlerte').style.top = randomTop + "%";
    document.getElementById('fenetreMessageAlerte').style.left = randomLeft + "%";
    document.getElementById('fondMessageAlerte').style.display = 'block';
    let focusedElement = document.activeElement;
    if (focusedElement && focusedElement !== document.body) {
        focusedElement.blur();
    }

    let alert = document.getElementById('fenetreMessageAlerte').querySelector('div');
    let p = alert.querySelector('p')
    let div = alert.querySelector('div')
    let button1 = document.createElement('button');
    let button2 = document.createElement('button');
    button1.style.marginRight = "10px";
    button1.style.marginLeft = "10px";
    button2.style.marginRight = "10px";
    button2.style.marginLeft = "10px";
    p.textContent = message;

    while (div.children.length > 0) {
        div.removeChild(div.children[0]);
    }

    if (message === "Cava ?") {
        button1.textContent = 'Ok';
        button1.addEventListener('click', anAlert.bind(null, "T sur cava ?"));
        button2.textContent = 'Non';
        button2.addEventListener('click', anAlert.bind(null, "Pk ?"));
        div.appendChild(button1);
        div.appendChild(button2);
    } else if (message === "T sur cava ?") {
        button1.textContent = 'Ok';
        button1.addEventListener('click', closeAlert);
        button2.textContent = 'Ok';
        button2.addEventListener('click', closeAlert);
        div.appendChild(button1);
        div.appendChild(button2);
    } else if (message === "Pk ?") {
        button1.textContent = 'Ok';
        button1.addEventListener('click', closeAlert);
        button2.textContent = 'Jsp';
        button2.addEventListener('click', closeAlert);
        div.appendChild(button1);
        div.appendChild(button2);
    }
}

function theEnd(nom, prenom, email) {
    clearInterval(cavaOrNoCava);
    cavaOrNoCava = true;
    document.getElementById('alerte').style.display = 'none';
    document.getElementById('fondMessageAlerte').style.display = 'block';
    let fenetreStyle = document.getElementById('fenetreMessageAlerte').style;
    fenetreStyle.display = 'flex';
    fenetreStyle.width = '25%';
    fenetreStyle.height = '25%';
    fenetreStyle.backgroundImage = "url('gg.PNG')";

    document.getElementById('formule').style.display = 'flex';

    document.getElementById('formNom').value = nom;
    document.getElementById('formPrenom').value = prenom;
    document.getElementById('formEmail').value = email;
}


function closeAlert() {
    document.getElementById('fenetreMessageAlerte').style.display = 'none';
    document.getElementById('fondMessageAlerte').style.display = 'none';
    cavaOrNoCava = null;
}

function epilepsParty(timeout) {
    clearInterval(headerCouleurs);
    headerCouleurs = setInterval(chanceDeCouleurHeader, timeout);
}

function checkCavaAlert() {
    if (cavaOrNoCava === null) {
        cavaOrNoCava = setInterval(cava, 1000);
    }
}

function init() {
    cavaOrNoCava = null;
    headerCouleurs = setInterval(chanceDeCouleurHeader, 1000);
    cavaChecker = setInterval(checkCavaAlert, 1000);
    const audio = document.querySelector('audio');
    audio.play();
}