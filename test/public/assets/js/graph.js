var log = "perriea";
    token = "test";
    res = 0;
    prix_max = 0;
    prix_min = 9999999999;
    theme = "dark";


/*
** AJAX
** Effectue les requetes en AJAX afin d'afficher les bonnes donnees
** INPUT : URL
** OUTPUT : JSON
*/
function ajax (url) 
{
    var ajax = new XMLHttpRequest();
    ajax.open('GET', url, false);
    ajax.onreadystatechange = function() {
        var script = ajax.response || ajax.responseText;
        if (ajax.readyState === 4) {
            switch(ajax.status) {
                case 200:
                    console.log("script loaded: ", url);
                break;

                default:
                    console.log("ERROR: script not loaded: ", url);
            }
        }
    };
    ajax.send(null);
    return JSON.parse(ajax.responseText);
}


/*
** CHARTS
** Genere les graphiques
** INPUT : data JSON, prix minimum et max
** OUTPUT : Graphique
*/
function charts (data, prix_min, prix_max) 
{
    var chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",

        "theme": theme,
        "dataDateFormat": "YYYY",
        "dataProvider": data["results"],
        "valueAxes": [{
            "maximum": prix_max,
            "minimum": prix_min,
            "axisAlpha": 0,            
        }],
        "graphs": [{
            "bullet": "round",
            "dashLength": 4,
            "valueField": "prix"
        }],
        "chartCursor": {
            "cursorAlpha": 0
        },
        "categoryField": "annee",
    });
}


function affichage (data, variation) {
    if (variation["variation"] > 0)
        document.getElementById('var').innerHTML = "<h1>" + data["info"]["name_fr"] + "<img src='/assets/img/high.png'> " + variation["variation"] + "%</h1>";
    else
        document.getElementById('var').innerHTML = "<h1>" + data["info"]["name_fr"] + "<img src='/assets/img/low.png'> " + variation["variation"] + "%</h1>";

    document.getElementById('start').innerHTML = "<h4>Prix départ : " + variation["previous price"] + "€</h4>";
    document.getElementById('end').innerHTML = "<h4>Prix actuel : " + variation["current price"] + "€</h4>";
    
    document.getElementById('sources').innerHTML = "Source : " + data["info"]["source_fr"];
}


/*
** MAIN
** Methode de lancement + lancement du chargement des requete de l'API variation & show
** INPUT : Matiere + parametres
** OUTPUT : none
*/
function main (mat, params) 
{
    var connect = this.ajax("/api/auth/" + log + "/" + token + "/");
    if (connect["auth"] === "ok")
    {
        var data = this.ajax("/api/show/" + mat + params);
        if (data["results"].length > 0) 
        {
            var variation = this.ajax("/api/var/" + mat + params);
            this.affichage(data, variation);
            for (var i = 0; i < data["results"].length; i++) 
            {
                if (data["results"][i]["prix"] > prix_max) 
                    prix_max = parseInt(data["results"][i]["prix"]) + 1000;
                if (data["results"][i]["prix"] < prix_min)
                {
                    prix_min = parseInt(data["results"][i]["prix"]) - 1000;
                    if (prix_min < 0) 
                        prix_min = 0;
                }        
            }    
            this.charts(data, prix_min, prix_max);
            this.ajax("/api/logout");
        }
        else
            alert("Erreur pas de resultats !")
    }
    else
        alert("Erreur d'auth !");
}


/*
** PARAMS
** Genere la bonne string pour les parametres
** INPUT : Matiere
** OUTPUT : none
*/
function params (mat) 
{
    var params = "?";

    if (document.getElementById('myRadio1').checked)
        flux = document.getElementById('myRadio1').value;
    else
        flux = document.getElementById('myRadio2').value;
    var country = document.getElementById('country').value;
    var start = document.getElementById('debut').value; 
    var end = document.getElementById('fin').value; 

    if (flux !== '') 
        params = params + "flux=" + flux + "&";
    if (country !== '') 
        params = params + "country=" + country + "&";
    if (start != '') 
        params = params + "start=" + start + "&";
    if (end != '') 
        params = params + "end=" + end + "&";
    params = params.substring(0, params.length - 1);
    this.main(mat, params);
}