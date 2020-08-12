<?
function addimage ($photo, $h) {
    list ($h0, $l0, $type) = getimagesize($photo);
    switch($type) {
        case 1: $im0 = ImageCreateFromgif($photo); break;
        case 2: $im0 = ImageCreateFromjpeg($photo); break;
        case 3: $im0 = ImageCreateFrompng($photo); break;
        default: return; break;
    }
    if ($h0 > $l0) {
        $h1 = $h;
        $l1 = floor($l0/$h0*$h1);
    } else {
        $l1 = $h;
        $h1 = floor($h0/$l0*$l1);
    }
    $im1 = ImageCreateTrueColor($l1, $h1);
    imagecopyresampled ($im1, $im0, 0, 0, 0, 0, $l1, $h1, $l0, $h0);
    imagedestroy ($im0);
    ob_start();
    switch($type) {
        case 1: imagegif($im1, null, 75); break;
        case 2: imagejpeg($im1, null, 75); break;
        case 3: imagepng($im1, null, 75); break;
        default: echo ''; break;
    }
    $data = ob_get_contents();
    ob_end_clean();
    imagedestroy ($im1);
    switch($type) {
        case 1: $p .= "PHOTO;ENCODING=BASE64;TYPE=GIF:"; break;
        case 2: $p .= "PHOTO;ENCODING=BASE64;TYPE=JPEG:"; break;
        case 3: $p .= "PHOTO;ENCODING=BASE64;TYPE=PNG:"; break;
    }
    $j = strlen($p);
    $vcard = $p;
    $image = base64_encode($data)."\n";
    for ($i=0; $i<strlen($image); $i++) {
        if(($i+$j-1)%75==0) 
            $vcard.="\r\n ".$image[$i];
        else  
            $vcard.=$image[$i];
    }
    return $vcard;
}

$nom = $_POST['nom'];

if ($nom != "")
{
    $count++;
    $filename = "$nom.vcf";
    $vcard = "";
    
    $prenom = $_POST['prenom'];
    $titre = $_POST['titre'];
    $org = $_POST['org'];
    $cell = $_POST['cell'];
    $home = $_POST['home'];
    $work = $_POST['work'];
    $fax = $_POST['fax'];
    $rue = $_POST['rue'];
    $ville = $_POST['ville'];
    $region = $_POST['region'];
    $zip = $_POST['zip'];
    $pays = $_POST['pays'];
    $mail = $_POST['mail'];
    $url = $_POST['url'];
    $photo = $_FILES['photo']['tmp_name'];
    //$ = $_POST[''];

    $nom = strtoupper($nom[0]).strtolower(substr($nom, 1, strlen($nom)-1));
    $prenom = strtoupper($prenom[0]).strtolower(substr($prenom, 1, strlen($prenom)-1));
    
    $vcard = "BEGIN:VCARD\n"; 
    $vcard .= "VERSION:3.0\n"; 
    $vcard .= "N:$nom;$prenom;;$titre;\n"; 
    $vcard .= "FN:$prenom $nom\n";
    if ($org != "")        {$vcard .= "ORG:$org\n";}
    if ($cell != "")    {$vcard .= "TEL;TYPE=cell:$cell\n";}
    if ($home != "")    {$vcard .= "TEL;TYPE=home:$home\n";}
    if ($work != "")    {$vcard .= "TEL;TYPE=work:$work\n";}
    if ($fax != "")        {$vcard .= "TEL;TYPE=fax:$fax\n";}
    if ($rue != "")     {$vcard .= "ADR;TYPE=dom,home,postal:;;$rue;$ville;$regions;$zip;$pays\n";}
    if ($mail != "")    {$vcard .= "EMAIL;TYPE=internet,pref:$mail\n";}
    if ($url != "")     {$vcard .= "URL:$url\n";}
    if ($photo != "")    {$vcard .= addimage($photo, 64);}
    //if ($ != "") {$vcard .= "\n";}
    $vcard .= "NOTE:Generated with vCard online generator by Daniel Mihalcea.\n";
    $vcard .= "END:VCARD\n";

    Header("Content-Disposition: attachment; filename=$filename");
    Header("Content-Length: ".strlen($vcard));
    Header("Connection: close");
    Header("Content-Type: text/x-vCard; charset=utf-8; name=$filename");
    //echo "<pre>";
    echo $vcard;

} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>G&eacute;n&eacute;rateur vCard enLigne</title>
<link href="vcard.css" rel="stylesheet" type="text/css" />
<style  type="text/css">
<!--
div#page {
    width: 120mm;
}
div#gauche {
    float: left;
    width: 50mm;
}
div#centre {
    float: left;
    width: 0mm;
}
div#droite {
    float: left;
    width: 50mm;
}
div#info {
    float: left;
    width: 64px;
    height: 64px;
}
div#id1 {
    float: right;
    height: 64px;
    width: 64px;
    text-align: right;
}
div#id2 {
    height: 64px;
}
div#soc1 {
    height: 24px;
    width: auto;
    text-align: right;
}
div#soc2 {
    height: 24px;
}
div#tel1 {
    height: 96px;
    width: auto;
    text-align: right;
}
div#tel2 {
    height: 96px;
}
div#adr1 {
    height: 128px;
    width: auto;
    text-align: right;
}
div#adr2 {
    height: 128px;
}
div#mel1 {
    height: 24px;
    width: auto;
    text-align: right;
}
div#mel2 {
    height: 24px;
}
div#web1 {
    height: 24px;
    width: auto;
    text-align: right;
}
div#web2 {
    height: 24px;
}
div#pic1 {
    height: 24px;
    width: auto;
    text-align: right;
}
div#pic2 {
    height: 24px;
}
div#gnr1 {
    height: 24px;
    width: auto;
    text-align: right;
}
div#gnr2 {
    height: 24px;
}
div#copy {
    font-family: Verdana, Geneva, sans-serif;
    font-size: 12px;
    text-align: center;
}

h1 {
    margin: 8px;
    text-align: center;
}
input.champ {
    font-family: Arial, Helvetica, sans-serif;
    width: 128px;
    uheight: 14px;
}

input:focus {
    background-color: #0CF;
}
.descr {
    width: auto;
    text-align: justify;
}

div {
    uborder: dotted;
    border-width: thin;
    upadding: 0px;
    margin: 2px;
}
-->
</style>
</head>
<body>
<div id="page">
<h1>G&eacute;n&eacute;rateur vCard en Ligne</h1>
<div class="descr">
Remplissez le formulaire pour générer automatiquement une carte de visite au format vCard(.VCF), aucun champ à part le nom n'est obligatoire. Vous pouvez ajouter une photo JPEG, GIF ou PNG elle sera automatiquement redimensionnée.
</div>
<form method="post" enctype="multipart/form-data" action="">
<div id="gauche">
    <div id="info">
        <input type="radio" name="titre" id="mr" value="Mr"/><label for="mr">Mr</label><br/>
        <input type="radio" name="titre" id="mme" value="Mme"/><label for="mme">Mme</label><br/>
        <input type="radio" name="titre" id="mlle" value="Mlle"/><label for="mlle">Mlle</label><br/>
    </div>
    <div id="id1">
        Nom<br/>
        Pr&eacute;nom<br/>
    </div>
    <div style="clear:both;"></div>
    <div id="soc1">
        Soci&eacute;t&eacute;
    </div>
    <div id="tel1">
        Téléphone<br/>
        Portable<br/>
        Domicile<br/>
        Travail<br/>
        Fax
    </div>
    <div id="adr1">
        Adresse<br/>
        rue<br/>
        ville<br/>
        région<br/>
        code postal<br/>
        pays<br/>
    </div>
    <div id="mel1">
        e-mail
    </div>
    <div id="web1">
        web
    </div>
    <div id="pic1">
        photo
    </div>
    <div id="gnr1">
        &nbsp;
    </div>
</div>
<div id="centre">
<img src="vl.png" width="2" height="430">
</div>
<div id="droite">
    <div id="id2">
        &nbsp;<input type="text" name="nom" id="nom" class="champ"/><br/>
        &nbsp;<input type="text" name="prenom" id="prenom" class="champ"/><br/>
    </div>
    <div></div>
    <div id="soc2">
        &nbsp;<input type="text" name="org" class="champ"/>
    </div>
    <div id="tel2">
        &nbsp;<br/>
        &nbsp;<input type="text" name="cell" class="champ"/><br/>
        &nbsp;<input type="text" name="home" class="champ"/><br/>
        &nbsp;<input type="text" name="work" class="champ"/><br/>
        &nbsp;<input type="text" name="fax" class="champ"/>
    </div>
    <div id="adr2">
        &nbsp;<br/>
        &nbsp;<input type="text" name="rue" class="champ"/><br/>
        &nbsp;<input type="text" name="ville" class="champ"/><br/>
        &nbsp;<input type="text" name="region" class="champ"/><br/>
        &nbsp;<input type="text" name="zip" class="champ"/><br/>
        &nbsp;<input type="text" name="pays" class="champ"/><br/>
    </div>
    <div id="mel2">
        &nbsp;<input type="text" name="mail" class="champ"/>
    </div>
    <div id="web2">
        &nbsp;<input type="text" name="url" class="champ"/>
    </div>
    <div id="pic2">
        &nbsp;<input type="file" name="photo" class="champ" id="photo" />
    </div>
    <div id="gnr2">
        &nbsp;<input type="submit" value="G&eacute;nerer"/>
    </div>
</div>
<div style="clear:both;"></div>


</form>
<div id="copy">
vCard online generator - &copy; 2010 - Daniel Mihalcea
</div>
</div>
</body>
</html>
<?
}
?>
