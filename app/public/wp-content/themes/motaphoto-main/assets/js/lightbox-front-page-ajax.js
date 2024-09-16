// Script pour la gestion de la Lightbox sur toutes les photos uniqueùent sur la page d'acceuil

/**
 * Variables récupérées / renvoyées
 *
 * nonce : jeton de sécurité
 * ajaxurl : adresse URL de la fonction Ajax dans WP
 *
 * total_posts : tableau de toutes les données des photos correspondantes aux filtres
 * nb_total_posts : nombres de photos à afficher
 * photo_id : indentifiant de la photo à afficher
 *
 */

document.addEventListener("DOMContentLoaded", function () {
    console.log("Script lightbox-front-page-ajax.js lancé !!!");

    // Récupération du tableau de toutes les photos selon les filtres
    let total_posts = "";
    let nb_total_posts = 1;
    let posts_per_page = 1;

    // Intialisation des données pour le filtrage des données dans total_post
    const regex1 = /[(]/g;
    const regex2 = /[)]/g;
    let arrayIntial;

    recupData();

    let id = "";
    let idPhoto = null;
    let idPhotoNext = null;
    let idValue = 10;
    let arrow = "true";

    function recupData() {
        if (document.getElementById("total_posts") !== null) {
            total_posts = document.getElementById("total_posts").value;

            // Supression du début "Array (" et de la fin ")" pour n'avoir que les données du tableau d'origine
            total_posts = total_posts.slice(8, total_posts.length - 3);
        }

        if (document.getElementById("nb_total_posts") !== null) {
            nb_total_posts = document.getElementById("nb_total_posts").value;
        }

        if (document.getElementById("posts_per_page") !== null) {
            posts_per_page = document.getElementById("posts_per_page").value;
        }

        arrayIntial = total_posts;
        arrayFinish = new Array();
        data = new Array();

        recupArrayPhp();
    }

    function recupArrayPhp() {
        // Récupérarion des données qui sont en texte et transfert dans un tableau javascript

        // Parcour des données pour en extraire les éléments de chaque photo
        // et les regroupper dans un seul élément commun
        for (let pas = 0; pas < nb_total_posts; pas++) {
            start = arrayIntial.search(regex1) + 2;
            end = arrayIntial.search(regex2);
            next = end + 1;

            // On extrait les informations de la photo et on les regroupe
            arrayFinish.push(arrayIntial.slice(`${start}`, `${end}`));

            // On retire ces éléments pour le filtrage suivant
            arrayIntial = arrayIntial.slice(`${next}`, -1);
        }
    }

    // Récupérération de la position de la photo dans le tableau
    function recupIdData(arg) {
        // On parcour le tableau à la recherche de l'identifiant de la photo
        for (let i = 0; i < nb_total_posts; i++) {
            data = arrayFinish[i].split("\n");
            let position = data[0].search("ID") + 7;
            if (data[0].slice(`${position}`) == arg) {
                idValue = i;
            }
        }
    }

    // Récupérération de l'identifiant de la photo en fonction de notre position dans la tableau
    function recupIdPhoto(arg) {
        data = arrayFinish[arg].split("\n");
        let position = data[0].search("ID") + 7;
        idPhoto = data[0].slice(`${position}`);
    }

    (function ($) {
        $(document).ready(function () {
            console.log("Document lightbox front-page prêt!!!");

            // Vérifier si les éléments avec la classe openLightbox sont bien présents
            let openLightboxElements = $(".openLightbox");
            console.log("Éléments avec la classe openLightbox trouvés:", openLightboxElements);

            // Gestion de la pagination de la lightbox
            $(".openLightbox").on("click", function (e) {
                e.preventDefault();
                console.log("openLightbox cliqué");

                // Récupération des éléments du DOM enfants
                recupData();

                // On récupère les éléments complémentaires liés à cet élément
                if (!$(this).data("arrow")) {
                    arrow = $(this).data("arrow");
                }
                if (!$(this).data("postid")) {
                    console.log("Identifiant manquant. Récupération du premier de la liste");
                    recupIdPhoto(0);
                } else {
                    idPhoto = $(this).data("postid");
                }
                recupIdData(idPhoto);
                idPhoto="15";
                console.log("photo n° " + idValue + " de la liste - id Photo: " + idPhoto);

                $(".lightbox").removeClass("hidden");
                console.log("Lightbox affichée");

                // On s'assure que le container est vide avant de charger le code
                $("#lightbox__container_content").empty();
                $.changePhoto();
            });

            // Affichage de la photo précédente
            $(".lightbox__prev").click(function (e) {
                e.preventDefault();
                idPhotoNext = idPhoto;
                console.log("Photo précédente");
                if (idValue > 0) {
                    idValue--;
                } else {
                    idValue = nb_total_posts - 1;
                }
                recupIdPhoto(idValue);
                console.log("id: " + idValue + " - id Photo: " + idPhoto);
                $.changePhoto();
            });

            // Affichage de la photo suivante
            $(".lightbox__next").click(function (e) {
                e.preventDefault();
                idPhotoNext = idPhoto;
                console.log("Photo suivante");
                if (idValue < nb_total_posts - 1) {
                    idValue++;
                } else {
                    idValue = 0;
                }
                recupIdPhoto(idValue);
                console.log("id: " + idValue + " - id Photo: " + idPhoto);
                $.changePhoto();
            });

            // Refermer la lightbox au clic sur la croix
            $(".lightbox__close").click(function (e) {
                e.preventDefault();
                $.close();
                console.log("Lightbox fermée");
            });

            /**
             * Récupération des événements au clavier
             * @param {KeyboardEvent} e     */
            $("body").keyup(function (e) {
                e.preventDefault();
                // Refermer la lightbox en faisant échap au clavier
                if (e.key === "Escape") {
                    $.close();
                    console.log("Lightbox fermée avec Échap");
                }
            });

            // Affichage de la photo et des informations demandées
            $.changePhoto = function () {
                // Récupération du jeton de sécurité
                //const nonce = $("#nonce").val();

                // Récupération de l'adresse de la page pour pointer Ajax
                const ajaxurl = $("#ajaxurl").val();

                // On affiche une image de chargement
                $(".lightbox__loader").removeClass("hidden");
                // On cache tout le reste en attendant la réponse
                $("#lightbox__container_content").addClass("hidden");
                $(".lightbox__next").addClass("hidden");
                $(".lightbox__prev").addClass("hidden");

                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    dataType: "html",
                    data: {
                        action: "motaphoto_lightbox",
                        //nonce: nonce,
                        photo_id: idPhoto,
                        categorie_id: 49,
                    },
                    success: function (res) {
                        // On a eu la réponse que c'est bon donc on retire l'image de chargement
                        $("#lightbox__container_content").empty().append(res);
                        // On affiche les informations de la lightbox
                        $(".lightbox__loader").addClass("hidden");
                        $("#lightbox__container_content").removeClass("hidden");
                        console.log("Photo chargée");
                        // On affiche les flèches que si c'était demandé et que l'on a plus d'une photo
                        if (arrow && nb_total_posts > 1) {
                            $(".lightbox__next").removeClass("hidden");
                            $(".lightbox__prev").removeClass("hidden");
                        }
                    },
                    error: function (err) {
                        console.error("Erreur lors du chargement de la photo :", err);
                    }
                });
            };

            // On referme la lightbox au clic sur la croix
            $.close = function () {
                $(".lightbox").addClass("hidden");
                console.log("Lightbox fermée");
            };
        });
    })(jQuery);
});
