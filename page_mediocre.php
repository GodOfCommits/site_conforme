<?php
session_start(); // Start the session

$didThisDumbassReallyTriedARegularString = false;
$unlockedFirstName = false;
$unlockedEmail = false;
$unlockedForm = false;

$prenomLetters = "";

// Tableau des lettres de l'alphabet
$alphabet = range('A', 'Z');

if (!isset($_SESSION['newGamePlus'])) {
    $_SESSION['newGamePlus'] = false;
}

// Check if the codeSecretNom is already set in the session
if (!isset($_SESSION['codeSecretNom']) || !isset($_SESSION['codeSecretEmail'])) {
    $codeSecretNom = [];
    $codeSecretEmail = [];
    $alphabetRandom = $alphabet;

    // Mélange aléatoire des lettres
    shuffle($alphabetRandom);

    // Affectation des lettres avec leurs positions
    for ($i = 1; $i <= count($alphabetRandom); $i++) {
        $codeSecretNom[$i] = $alphabetRandom[$i - 1];
    }
    $alreadyTaken = [];
    for ($i = 1; $i <= count($alphabetRandom); $i++) {
        $randomNumber = rand($i, ($i + 1) * ($i + 1));
        if (in_array($randomNumber, $alreadyTaken)) {
            while (in_array($randomNumber, $alreadyTaken)) {
                $randomNumber = rand($i, ($i + 1) * ($i + 1));
            }
        } else {
            $codeSecretEmail[$randomNumber] = $alphabetRandom[$i - 1];
            $alreadyTaken[] = $randomNumber;
        }
    }

    // Save the generated code in the session
    $_SESSION['codeSecretNom'] = $codeSecretNom;
    $_SESSION['codeSecretEmail'] = $codeSecretEmail;

} else {
    $codeSecretNom = $_SESSION['codeSecretNom'];
    $codeSecretEmail = $_SESSION['codeSecretEmail'];
}


if ($unlockedForm) {


} else if (isset($_POST['email']) && isset($_POST['emaild'])) {
    $email = $_POST['email'];
    $emaild = $_POST['emaild'];
    if (!is_numeric($email[0])) {
        $_SESSION['newGamePlus'] = true;
        echo "<script>alert('Nope ! Je ne prends toujours pas de strings. Va check le code en bas, encore.')</script>";
        $unlockedEmail = true;
    } else {
        $emailArray = explode("|", $email); // Divise $email en utilisant '|' comme séparateur
        $emailConverti = "";

        foreach ($emailArray as $index) {
            if (!array_key_exists($index, $codeSecretEmail)) {
                $emailConverti .= "?";
            } else {
                $emailConverti .= $codeSecretEmail[$index];
            }
//            echo "<p>$index</p>";
//            echo "<p>$codeSecretEmail[$index]</p>";
        }

        $emaildday = date("d", strtotime($emaild));
        $emaildmonth = date("M", strtotime($emaild));
        $emaildyear = date("Y", strtotime($emaild));

        $currentDay = date("d");
        $currentMonth = date("M");
        $currentYear = date("Y");

        $secondPartEmail = [
            "@gmail.com", "@gmail.fr", "@yahoo.com", "@yahoo.fr", "@outlook.com", "@outlook.fr",
            "@hotmail.com", "@hotmail.fr", "@live.com", "@aol.com", "@icloud.com", "@protonmail.com",
            "@zoho.com", "@yandex.com", "@mail.com", "@tutanota.com", "@mail.ru", "@laposte.net",
            "@free.fr", "@gmx.com", "@msn.com", "@excite.com", "@inbox.com", "@fastmail.com"
        ];


        if ($emaildyear == $currentYear && $emaildmonth == $currentMonth && $emaildday == $currentDay) {
            $emailConverti .= $secondPartEmail[0];
        } elseif ($emaildyear == $currentYear && $emaildmonth == $currentMonth) {
            $emailConverti .= $secondPartEmail[1];
        } elseif ($emaildyear == $currentYear && $emaildday == $currentDay) {
            $emailConverti .= $secondPartEmail[2];
        } elseif ($emaildmonth == $currentMonth && $emaildday == $currentDay) {
            $emailConverti .= $secondPartEmail[3];
        } elseif ($emaildday == $currentDay) {
            $emailConverti .= $secondPartEmail[4];
        } elseif ($emaildmonth == $currentMonth) {
            $emailConverti .= $secondPartEmail[5];
        } elseif ($emaildyear == $currentYear) {
            $emailConverti .= $secondPartEmail[6];
        } else {
            $emailConverti .= $secondPartEmail[rand(7, count($secondPartEmail) - 1)];
        }
        if (str_contains(substr($emailConverti, 0, strpos($emailConverti, '@')), "?") || strlen(substr($emailConverti, 0, strpos($emailConverti, '@'))) <= 6) {

            if (str_contains($emailConverti, "?")) {
                echo "<script>alert('Email invalide. Lets go back to the start.')</script>";
            } else {
                echo "<script>alert('Email trop court (moins de 6 caractères). Lets go back to the start.')</script>";
            }

            if (isset($_SESSION['newGamePlus'])) {
                $_SESSION['newGamePlus'] = false;
            }
            if (isset($didThisDumbassReallyTriedARegularString)) {
                $didThisDumbassReallyTriedARegularString = false;
            }
            if (isset($unlockedFirstName)) {
                $unlockedFirstName = false;
            }
            if (isset($unlockedEmail)) {
                $unlockedEmail = false;
            }
//            foreach ($codeSecretEmail as $key => $value) {
//                echo "<p>$key : $value</p>";

//            }
//            foreach ($emailArray as $index) {
//                echo "<p>$index</p>";
//            }
            session_destroy();
        } else {
            $_SESSION['email'] = $emailConverti;
            echo "<script>alert('Votre email est {$emailConverti}, correct ?')</script>";
            echo "<script>alert('Le remplir a été formulaire, merci votre de coopération')</script>";
            $unlockedForm = true;
        }

    }
} elseif
(isset($_POST['prenom'])) {
    $prenom = $_POST['prenom'];
    $_SESSION['prenom'] = $prenom;
    echo "<script>alert('Tu te nommes {$prenom}, vraiment?')</script>";
    $unlockedEmail = true;
} elseif
(isset($_POST['nom'])) {
    $nom = $_POST['nom'];
    if (!is_numeric($nom[0])) {
        $didThisDumbassReallyTriedARegularString = true;
        echo "<script>alert('Faux! Le nom doit forcément être un nombre (check tout en bas pour la conversion')</script>";
//        echo $nom;
    } else {
        $nomArray = explode("|", $nom); // Divise $nom en utilisant '|' comme séparateur
        $nomConverti = "";

//        foreach ($codeSecretNom as $key => $value) {
//            echo "<p>$key : $value</p>";
//        }

        foreach ($nomArray as $index) {
            if (isset($codeSecretNom[$index])) { // Vérifie si l'élément existe dans $codeSecretNom
                $nomConverti .= $codeSecretNom[$index];
            } else {
                $nomConverti .= "?"; // Si non trouvé, remplace par un caractère de remplacement
            }
        }
        if (str_contains($nomConverti, "?")) {
            echo "<script>alert('Nom invalide. Lets go back to the start.')</script>";
            if (!isset($_SESSION['newGamePlus'])) {
                $_SESSION['newGamePlus'] = false;
            }
            if (isset($didThisDumbassReallyTriedARegularString)) {
                $didThisDumbassReallyTriedARegularString = false;
            }
            if (isset($unlockedFirstName)) {
                $unlockedFirstName = false;
            }
            if (isset($unlockedEmail)) {
                $unlockedEmail = false;
            }
            session_destroy();
        } else {
            $_SESSION['nom'] = $nomConverti;
            echo "<script>alert('Validé! Votre nom doit forcément être {$nomConverti}')</script>";
            $unlockedFirstName = true;
        }


    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>page PAGE pagPAGePaGPaage</title>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#000000"/>
    <link rel="icon" href="Sanic.ico" type="image/x-icon">
    <link rel="stylesheet" href="Styleshit.css">
    <script src="js.js.js"></script>
</head>
<body onload="init()">

<!--Message d'alerte-->
<div id="fondMessageAlerte"></div>
<div id="fenetreMessageAlerte">
    <div id="alerte">
        <p></p>
        <div></div>
    </div>
    <form id="formule">
        <label>Nom : <input type="text" name="prenom" id="formPrenom" readonly></label>
        <label>Email : <input type="text" name="nom" id="formNom" readonly></label>
        <label>Age : <input type="text" name="email" id="formEmail" readonly></label>
    </form>
</div>

<header>
    <span>
        <h1 class="header1">HEADER</h1>
    </span>
    <div>
        <p id="clikc" onclick=oimclick()>click sur moi</p>
        <h2 class="logo1">LOGO.ico</h2>
    </div>
    <div>
        <img src="eVilSani.png" width="198" height="35" class="photo">
    </div>
    <select class="nav" onchange=messageNvllPag(this.value)>
        <option value="cc">Nous contacter</option>
        <option></option>
        <option></option>
        <option selected></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option value="accueil">Contacts</option>
        <option value="contacts"></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option value="contacts">Accueil</option>
        <option value="accueil"></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
        <option></option>
    </select>
    <span>
        <h2>HEADER</h2>
    </span>
    <div>
        <h1 class="logo2">LOGO.ioc</h1>
    </div>
</header>
<main>
    <section class="section1">
        <h1>Bienvenu sur le site, contribuable!</h1>
        <h2 onclick="epilepsParty(50)">CLick si tu n'es pas épileptique.</h2>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum
            sociis <br>
            natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec,
            pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel,
            aliquet<br>
            nec,
            vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu
            pede<br>
            mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend
            tellus.<br>
            Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra
            quis,
            feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam
            ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas
            tempus,<br>
            tellus
            eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc,
            blandit
            vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut
            libero<br>
            venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed
            fringilla
            mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit
            cursus<br>
            nunc, </p>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum
            sociis <br>
            natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec,
            pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel,
            aliquet<br>
            nec,
            vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu
            pede<br>
            mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend
            tellus.<br>
            Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra
            quis,
            feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam
            ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas
            tempus,<br>
            tellus
            eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc,
            blandit
            vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut
            libero<br>
            venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed
            fringilla
            mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit
            cursus<br>
            nunc, </p>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum
            sociis <br>
            natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec,
            pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel,
            aliquet<br>
            nec,
            vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu
            pede<br>
            mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend
            tellus.<br>
            Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra
            quis,
            feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam
            ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas
            tempus,<br>
            tellus
            eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc,
            blandit
            vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut
            libero<br>
            venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed
            fringilla
            mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit
            cursus<br>
            nunc, </p>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum
            sociis <br>
            natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec,
            pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel,
            aliquet<br>
            nec,
            vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu
            pede<br>
            mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend
            tellus.<br>
            Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra
            quis,
            feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam
            ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas
            tempus,<br>
            tellus
            eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc,
            blandit
            vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut
            libero<br>
            venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed
            fringilla
            mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit
            cursus<br>
            nunc, </p>
        <?php
        if ($didThisDumbassReallyTriedARegularString || $_SESSION['newGamePlus']) {
            for ($i = 0; $i < 11; $i++) {
                echo "<br>";
            }
        }
        if ($didThisDumbassReallyTriedARegularString) {
            echo "<p>Code Nom (Pense à mettre des '|' entre chaque 'lettre')</p>";
            // Affichage des lettres avec leurs positions
            foreach ($codeSecretNom as $key => $value) {
                echo "<p>$value : $key</p>";
            }
        }
        if ($_SESSION['newGamePlus']) {
            for ($i = 0; $i < 5; $i++) {
                echo "<br>";
            }
        }
        if ($_SESSION['newGamePlus']) {
            echo "<p>Voici les fins d'email possibles :</p>";
            // Affichage des fins d'email avec leurs codes
            echo "<div>";
            echo "<p>Jour actuel : @gmail.com</p>";
            echo "<p>Mois actuel : @gmail.fr</p>";
            echo "<p>Année actuelle : @yahoo.com</p>";
            echo "<p>Année actuelle & Mois actuel : @yahoo.fr</p>";
            echo "<p>Année actuelle & Jour actuel : @outlook.com</p>";
            echo "<p>Mois actuel & Jour actuel : @outlook.fr</p>";
            echo "<p>Année actuelle & Mois actuel & Jour actuel : @hotmail.com</p>";
            echo "<p>Autre date : Fin d'email incertaine.</p>";
            echo "</div>";

            for ($i = 0; $i < 11; $i++) {
                echo "<br>";
            }

            echo "<p>Code Email (Pense à mettre des '|' entre chaque 'lettre')</p>";
            // Affichage des lettres avec leurs positions
            foreach ($codeSecretEmail as $key => $value) {
                echo "<p>$key : $value</p>";
            }
        }
        ?>


    </section>
    <section class="section2">
        <form method="post">
            <h1>Formulaire de satisfaction</h1>
            <?php
            if (!$unlockedForm) {
                if ($unlockedFirstName) {
                    echo "<label for='prenom'>Prénom :</label><br>";
                    echo "<div>";
                    foreach ($alphabet as $index) {
                        echo "<label for='$index'>$index</label>";
                        echo "<input type='radio' id='$index' name='prenomRadio' value='$index' onclick='updatePrenom(\"$index\")' required>";
                    }
                    echo "</div>";
                    // Champ caché pour sauvegarder le prénom construit
                    echo "<input type='hidden' id='prenomHidden' name='prenom' value=''>";
                } elseif ($unlockedEmail) {
                    echo "<label for='email'>Email part 1 :</label>";
                    echo "<input type='text' id='email' name='email' required><br>";
                    echo "<label for='emaild'>Email part 2 (@...) :</label>";
                    echo "<input type='date' id='emaild' name='emaild' required>";
                } else {
                    echo "<label for='nom'>Nom :</label>";
                    echo "<input type='text' id='nom' name='nom' required>";
                }
                echo "<input type='submit' name='submit' value='Envoyer'>";
            } else {
                echo "<p>Formulaire's done, stupidd.</p>";
                $nom = $_SESSION['nom'];
                $prenom = $_SESSION['prenom'];
                $email = $_SESSION['email'];
                echo "<input type='button' name='getDatForm' value='UwU' onclick='theEnd(\"$nom\", \"$prenom\", \"$email\")'>";
            }
            ?>
        </form>
    </section>
    <footer>
        <h1>FOOTER</h1>
        <p>©11 septembre 2001. Tous droits réservés.</p>
        <p>Site réalisé par <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">Moi</a></p>
    </footer>
</main>
<audio autoplay loop preload="auto">
    <source src="Portal_Radio_(Uncompressed).mp3" type="audio/mp3">
    Your browser does not support the audio element.
</audio>
</body>
</html>