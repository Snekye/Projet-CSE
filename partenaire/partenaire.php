<?php
//include("pagination.php");

// responsive
if($page>5){
    echo("<style>
        .conteneurPaginationPartenaire{
        width: 40%;
        position: absolute;
        left: 50%;
        transform: translate(-50%,-50%);
    }
    </style>");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projet cse</title>
</head>
<body>
    <section id="page-Partenaire">
        <div class="textePartenaire">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Nihil debitis omnis sunt cum vel ipsam beatae cupiditate magni dolor blanditiis voluptate placeat neque vitae, 
                repudiandae quam, enim esse culpa minima?Lorem, ipsum dolor sit amet consectetur adipisicing elit. Odio, dignissimos alias aperiam nemo possimus repudiandae, a dolorem aliquam labore, earum aut. Commodi eum voluptas inventore ex minus amet! Necessitatibus, ex.
            </p>
        </div>
        <div class="modalPartenaire">
            <div class="contenaire">
                <div id="fermerModalPartenaire" onclick="fermerModal()">
                    <p>&times;</p>
                </div>
            </div>
            <div class="partenaire">
                <div class="logoPartenaire">
                    <a href="#" >
                        <img src="image/35-355558_vi-logo-instagram-format-png.png" alt="nom du partenaire">
                    </a>
                </div>
                <div class="titrePartenaire2">
                    <h2>instagram</h2>
                </div>
            </div>
            <div class="descriptionPartenaire">
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem modi vitae aperiam at accusamus! Sint labore voluptate quae temporibus quia, aspernatur voluptatem expedita quibusdam saepe suscipit inventore ipsum quasi. A et sequi explicabo. Architecto assumenda obcaecati earum fuga officiis quaerat doloremque cumque eos minus, eius error eligendi perspiciatis sequi quo!
                    tur adipisicing elit. Nemo quos explicabo pariatur delectus animi, consequuntur quam quisquam laboriosam nisi corrupti quod, obcaecati distinctio dicta dolore neque assumenda rem, odio sit?
                </p>
            </div>
        </div>
        <div class="contenaire">
            <div class="partenaire">
                <div class="logoPartenaire">
                    <!-- lien vers le site du partenaire -->
                    <a href="https://www.instagram.com" target="_blank">
                        <img src="image/35-355558_vi-logo-instagram-format-png.png" alt="nom du partenaire">
                    </a>
                </div>
                <div class="titrePartenaire" onclick="ouvrirModal()">
                    <!-- ouverture de la modal -->
                    <h2>instagram</h2>
                </div>
            </div>
        </div>
        <div class="nbPaginationPartenaire">
            <?php for($i=1;$i<=$nbr_de_pages;$i++)
                echo('<div class="conteneurPaginationPartenaire">
                    <div class="pagePartenaire">
                        <p>');
                        if($page!=$i){
                        echo "<a href='?page=$i'>$i</a>&nbsp;";
                        }else{
                        echo "<a>$i;</a>&nbsp;";
                        }
                        echo('</p>
                    </div>
                </div>');
            ?>
        </div>
    </section>
    <script src="main.js"></script>
</body>
<footer>
</footer>
</html>
