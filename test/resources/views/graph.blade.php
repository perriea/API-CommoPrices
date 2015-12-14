<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Graph {{ $mat }} - CommoPrices</title>
        <link rel="stylesheet" href="/assets/css/style.css" type="text/css">
        <script src="/assets/js/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="/assets/js/amcharts/serial.js" type="text/javascript"></script>
        <script src="/assets/js/amcharts/themes/dark.js" type="text/javascript"></script>
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/graph.js"></script>
    </head>

    <body style="background-color:#3f3f4f;" onload="main('{{ $mat }}', '')">
        <a style="text-align: right;" href="https://commoprices.com" target="_blank"><img src="/assets/img/logo.png"></a>
        <h1 id="name"></h1>
        <div id="infos">
            <div id="var"></div>
            <div id="start"></div>
            <div id="end"></div>
        </div>
        <br>
        <form id="myForm">
            <div id="rates">
                <input type="radio" id="myRadio1" name="flux" value="i" checked><b>Import</b>
                <input type="radio" id="myRadio2" name="flux" value="e"><b>Export</b>
                <br>
                <select id="country">
                    <option value=''>Mondial</option>
                    <option value="BE">Belgique</option>
                    <option value="BF">Burkina Faso</option>
                    <option value="BG">Bulgarie</option>
                    <option value="BH">Bahreïn</option>
                    <option value="BI">Burundi</option>
                    <option value="BJ">Bénin</option>
                    <option value="CM">Cameroun</option>
                    <option value="CF">Centrafricaine (République)</option>
                    <option value="CL">Chili</option>
                    <option value="CN">Chine</option>
                    <option value="CG">Congo</option>
                    <option value="CI">Côte-d'Ivoire</option>
                    <option value="CK">Cook (îles)</option>
                    <option value="FR">France</option>
                    <option value="IT">Italie</option>
                    <option value="CH">Suisse</option>
                </select>
                <input type="text" id="debut" placeholder="Date debut">
                <input type="text" id="fin" placeholder="Date de fin">
                <input type="button" value="Valider" onclick="params('{{ $mat }}')">
            </div>
            <div id="chartdiv" style="width: 100%; height: 400px;"></div> 
        </form>
        <h6 id="sources"></h6>
    </body>
</html>