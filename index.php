<?php
$servername = "192.168.150.240";
$username = "semabox";
$password = "Mspr_epsi1!";
$dbname = "semabox";
?>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SemaLynx</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script src="modules/jquery-3.6.3.min.js"></script>
    </head>
    <body>
        <div id="app">
            <nav class="navbar">
                <section class="content_semabox">
                    <div class="brand">
                        <img src="images/cube.png" alt="logo" width="50px" class="logo">
                        <span class="brand-name">SemaLynx</span>
                    </div>
                </section>
<?php
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//select all the information from the table "box"
$sql = "SELECT * FROM box";
$result = $conn->query($sql);

//print the results
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
?>
                <a href="?uid=<?php echo $row['sema_id']; ?>">
                    <div class="sema">
                        <div class="container-photo-titre">
                            <img src="images/web.png" alt="logo" class="logo2">
                            <h2 class="title"> : <?php echo $row['sema_hostname']; ?></h2>
                        </div>
                        
                        <div class="container">
                            <div class="container-title">
                                <h3>Information de la Semabox</h3>
                            </div>
                            <div class="container-body">
                                <p>- IP : <?php echo $row['sema_ip']; ?></p>
                                <p>- IP Public : <?php echo $row['sema_ip_public']; ?></p>
                                <p>- DNS : <?php echo $row['sema_dns']; ?></p>
                                <p>- UID : <?php echo $row['sema_id']; ?></p>               
                            </div>
                        </div>
                        <p class="version">Version Semabox : <?php echo $row['sema_version']; ?></p> 
                    </div>
                </a>
<?php
            }
    } else {
?>
        <p class="zero-resultat">Aucun résultat trouvé</p>
<?php
    }
?>
            </nav>
<?php
    if (isset($_GET['uid'])) {
        $sql2 = "SELECT * FROM box WHERE sema_id = '".$_GET['uid']."'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            $rows = $result2->fetch_assoc();
            $ippublic = $rows['sema_ip_public'];
            $host = $rows['sema_dns'];
            $socket = @fsockopen($host, 80, $errorNo, $errorStr, 5);
            if ($socket) {
                fclose($socket);
?>
            <div class="semabox">
                <div class="haut">
                    <div class="materiel-body-container">
                        <div class="title-materiel-body-container">
                            <img src="images/computer.svg" alt="logo2" class="logo-information">
                            <h1>Information Système</h1>
                        </div>
                        <div class="materiel-body">
<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $host."/api/materiel_server.py",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $data = json_decode(json_decode($response)->result_script_json);
}
?>
                            <h3>- OS : <?php echo $data->os_name ?> 🖥️</h3>
                            <h3>- Nombre de Coeurs CPU : <?php echo $data->num_cpus ?> 🫀</h3>
                            <h3>- Utilisation du CPU : <?php echo $data->cpu_utilization ?> %</h3>
                            <h3>- Taille RAM : <?php echo $data->ram_size_go ?> Go</h3>
                            <h3>- Nombre de Disques : <?php echo $data->num_disks ?> 💾</h3>
                            <h3>- L'Espace d'un disque : <?php echo $data->disks ?> Go</h3>
                            <h3>- Serveur allumée depuis <?php echo $data->uptime_hours ?> H ♾️</h3>
                            <h3>- Etat de la Semabox : up ✅</h3>
                        </div>
                    </div>
                    <div class="container-body-speedtest">
                        <div class="container-title-speedtest">
                            <h1>Speedtest</h1>
                        </div>
                        <div class="container-text1-speedtest">
                            <h2>IP Public : <?php echo $ippublic ?></h2>
                        </div>
                        <div class="container-block-speedtest">
                            <div class="container-text2-speedtest">
                                <h3 id="ping-speedtest">- Ping : aucun speedtest </h3>
                            </div>
                            <div class="container-text3-speedtest">
                                <h3 id="down-speedtest">- Download : aucun speedtest</h3>
                            </div>
                            <div class="container-text4-speedtest">
                                <h3 id="up-speedtest">- Upload : aucun speedtest</h3>
                            </div>
                        </div>
                        <div class="Bouttom-speedtest">
                            <form class="form1">
                                <button id="buttom-body-go-speedtest" class="buttom-body" type="submit" onclick="return speedtestGo('<?php echo $host ?>')">Go</button>
                                <button class="buttom-body" type="submit" onclick="return speedtestReset()">Reset</button>
                            </form>
                        </div>
                    </div>
                    <div class="container-body-red">
                        <div class="container-title-red">
                            <h1>Etat</h1>
                        </div>
                        <div class="container-red">
                            <div class="container-text1-red">
                                <h2 id="state-restart">up ✅</h2>
                            </div>
                            <div class="Bouttom-red">
                                <form class="form3">
                                    <button class="buttom-body-red" name="go" type="submit" onclick="return rebootGO('<?php echo $host ?>')">Redemarrage</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-body-scan">
                    <div class="container-title-scan">
                        <h1>Scan Nmap</h1>
                    </div>
                    <table class="tableau-scan" id="tableauDeScan">
                        <tr>
                            <th>IP</th>
                            <td>Aucun scan</td>
                        </tr>
                        <tr>
                            <th>Hostname</th>
                            <td>Aucun scan</td>
                        </tr>
                        <tr>
                            <th>Etat</th>
                            <td>Aucun scan</td>
                        </tr>
                    </table>
                    <div id="tableau_port">
                    </div>
                    <form class="form2">
                        <button class="buttom-body-scan" name="scan" type="submit" onclick="return machinesScann('<?php echo $host ?>')">Listage des machines up</button>
                        <button class="buttom-body-scan" name="scan" type="submit" onclick="return machinesScannSelected('<?php echo $host ?>')">Scan des machines selectionner</button>
                        <button class="buttom-body-scan" name="scan" type="submit" onclick="return machinesScannAll('<?php echo $host ?>')">Scan de toutes les machines</button>
                        <button class="buttom-body-scan" name="reset" type="submit" onclick="return machinesReset()">Reset</button>
                    </form>
                </div>
            </div> 
<?php
} else {
?>
            <div class="semabox">
                <div class="haut-down">
                    <div class="container-body-red-down">
                        <div class="container-title-red">
                            <h1>Etat</h1>
                        </div>
                        <div class="container-red">
                            <div class="container-text1-red">
                                <h2>down ❌</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
}
?> 
<?php
        } else {
?>
            <p class="zero-resultat">Aucun résultat trouvé</p>
<?php
        }
    } else {
?>
        <p class="zero-resultat">Aucun résultat trouvé</p>
<?php
    }
?>
        </div>
        <script htype="text/javascript">
            function speedtestGo(host){
                $.ajax({
                    type: "POST",
                    url: "modules/server_speedtest.php",
                    data: {Host: host},
                    success: function(response){
                        const obj = JSON.parse(response);
                        document.getElementById("ping-speedtest").innerHTML = "- Ping : " + obj.ping + " ms";
                        document.getElementById("down-speedtest").innerHTML = "- Download : " + obj.download_speed + " mb/s";
                        document.getElementById("up-speedtest").innerHTML = "- upload_speed : " + obj.upload_speed + " mb/s";
                    }
                });
                return false;
            }

            function speedtestReset(){
                document.getElementById("ping-speedtest").innerHTML = "- Ping : Valeur reset";
                document.getElementById("down-speedtest").innerHTML = "- Download : Valeur reset";
                document.getElementById("up-speedtest").innerHTML = "- upload_speed : Valeur reset";
                return false;
            }

            function rebootGO(host){
                $.ajax({
                    type: "POST",
                    url: "modules/restart_server.php",
                    data: {Host: host},
                    success: function(response){
                        const obj = JSON.parse(response);
                        if(obj.message == 'ok'){
                            document.getElementById("state-restart").innerHTML = 'Redémarrage en cours 🔄';
                        }
                    }
                });
                return false;
            }

            function machinesScann(host){
                $.ajax({
                    type: "POST",
                    url: "modules/scan_other_servers.php",
                    data: {Host: host},
                    success: function(response){
                        const obj = JSON.parse(response);
                        var texthost = "<tr><th>IP</th>";
                        var texthostname = "<tr><th>Hostname</th>";
                        var textstate = "<tr><th>Etat</th>";
                        for(var keys in obj){
                            texthost = texthost + "<td class='" + obj[keys]['host'] + " host' onclick=\"return SelectHost('" + obj[keys]['host'] + "')\">" + obj[keys]['host'] + "</td>";
                            texthostname = texthostname + "<td class='" + obj[keys]['host'] + " hostname' onclick=\"return SelectHost('" + obj[keys]['host'] + "')\">" + obj[keys]['hostname'] + "</td>";
                            textstate = textstate + "<td class='" + obj[keys]['host'] + " state' onclick=\"return SelectHost('" + obj[keys]['host'] + "')\">" + obj[keys]['state'] + "</td>";
                        }
                        texthost = texthost + "</tr>";
                        texthostname = texthostname + "</tr>";
                        textstate = textstate + "</tr>";

                        document.getElementById("tableauDeScan").innerHTML = texthost + texthostname + textstate;
                    }
                });
                return false;
            }

            function SelectHost(classIp) {
                var elem = document.getElementsByClassName(classIp);
                for (var i = 0; i < elem.length; i++) {
                    if(elem.item(i).classList.contains("selected")) {
                        elem.item(i).classList.remove("selected");
                    } else {
                        elem.item(i).classList.add("selected");
                    }
                }
                return false;
            }

            function machinesScannSelected(host) {
                var elem = document.getElementsByClassName("host selected");
                for (var i = 0; i < elem.length; i++) {
                    var target = elem.item(i).innerHTML
                    $.ajax({
                        type: "POST",
                        url: "modules/scan_port_other_servers.php",
                        data: {Host: host, Target: elem.item(i).innerHTML},
                        success: function(response){
                            var textPort = "<tr><th>Port</th>";
                            var textState = "<tr><th>Status</th>";
                            var textService = "<tr><th>Service*</th>";
                            const obj = JSON.parse(response);
                            for(var keys in obj){
                            textPort = textPort + "<td>" + obj[keys]['port'] + "</td>";
                            textState = textState + "<td>" + obj[keys]['state'] + "</td>";
                            textService = textService + "<td>" + obj[keys]['service'] + "</td>";
                            }
                            textPort = textPort + "</tr>";
                            textState = textState + "</tr>";
                            textService = textService + "</tr>";
                            document.getElementById("tableau_port").innerHTML = document.getElementById("tableau_port").innerHTML + "<table><caption>" + target + "</caption>" + textPort + textState + textService + "</table>";
                        }
                    });
                }
                return false;
            }

            function machinesReset(){
                document.getElementById("tableau_port").innerHTML = ""; 
                document.getElementById("tableauDeScan").innerHTML = "<table class='tableau-scan' id='tableauDeScan'><tr><th>IP</th><td>Reset scan</td></tr><tr><th>Hostname</th><td>Reset scan</td></tr><tr><th>Etat</th><td>Reset scan</td> </tr></table>";
                return false;
            }

            function machinesScannAll(host){
                var elem = document.getElementsByClassName("host");
                for (var i = 0; i < elem.length; i++) {
                    var target = elem.item(i).innerHTML
                    $.ajax({
                        type: "POST",
                        url: "modules/scan_port_other_servers.php",
                        data: {Host: host, Target: elem.item(i).innerHTML},
                        success: function(response){
                            var textPort = "<tr><th>Port</th>";
                            var textState = "<tr><th>Status</th>";
                            var textService = "<tr><th>Service*</th>";
                            const obj = JSON.parse(response);
                            console.log(target);
                            if(obj['message'] != "Aucun Port ouvert"){
                                for(var keys in obj){
                                textPort = textPort + "<td>" + obj[keys]['port'] + "</td>";
                                textState = textState + "<td>" + obj[keys]['state'] + "</td>";
                                textService = textService + "<td>" + obj[keys]['service'] + "</td>";
                                }
                                textPort = textPort + "</tr>";
                                textState = textState + "</tr>";
                                textService = textService + "</tr>";
                                document.getElementById("tableau_port").innerHTML = document.getElementById("tableau_port").innerHTML + "<table><caption>" + target + "</caption>" + textPort + textState + textService + "</table>";
                            } else {
                                document.getElementById("tableau_port").innerHTML = document.getElementById("tableau_port").innerHTML + target + " : Aucun port ouvert </br>";
                            }
                        }
                    });
                }
                return false;
            }

            if(document.getElementById("buttom-body-go-speedtest")) {
                document.getElementById("buttom-body-go-speedtest").click();
            }
        </script>
    </body>
</html>