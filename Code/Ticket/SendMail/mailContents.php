<?php
	$dataPDF = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>' . $eventName . '</title>
    <link href="../style/mpdf.css" rel="stylesheet">
</head>
<body>

<main>
    <div class="leftPart">
        <div class="logo"><img alt="NHLSports" src="' . dirname(ROOT_FOLDER, 1) . "/assets/NHLSports.png." . '"></div>
        <div class="title"><h1>' . $eventName . '</h1></div>
        <div class="date">
            <div>' . $date . '</div>
        </div>
        <div class="locDetails">
            <div class="row"><span>Row:&nbsp;&nbsp;</span>' . $uRow . '</div>
            <div class="col"><span>Column:&nbsp;&nbsp;</span>' . $uColumn . '</div>
            <div class="zone"><span>Zone:&nbsp;&nbsp;</span>' . $zoneID . '</div>
            <div class="location">' . $_SESSION["eventLocation"] . '</div>
        </div>
        <div class="logo">
            <div class="time">' . substr($_SESSION["eventTime"], 0, -3) . '
            	<img alt="NHLSports" src="' . dirname(ROOT_FOLDER, 1) . "/assets/NHLSports.png." . '">
            </div>
        </div>
    </div>
    <div class="rightPart">
        <h1>Name</h1>
        <div class="name"><span>' . $fname . ' ' . $lname . '</span></div>
        <h2>Ticket Nr</h2>
        <div class="ticketID"><span>' . $ticketID . '</span></div>
    </div>
</main>
</body>
</html>
';
