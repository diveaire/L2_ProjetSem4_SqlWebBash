    
    var ns6=document.getElementById&&!document.all
    var ie4=document.all

    var Choix_Mois;
    var Choix_Annee;
    var Date_Actuel = new Date();
    var Mois_Actuel = Date_Actuel.getMonth();
    
    var Jours_par_Mois = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    var Nom_Mois = [
        'Janvier',
        'Février',
        'Mars',
        'Avril',
        'Mai',
        'Juin',
        'Juillet',
        'Août',
        'Septembre',
        'Octobre',
        'Novembre',
        'Decembre'
    ];
    
    var Annee_Actuel = Date_Actuel.getYear();
    if (Annee_Actuel < 1000)
    Annee_Actuel+=1900
    
    
    var Aujourdhui = Date_Actuel.getDate();
    
    function Header(Annee, Mois) {
    
    if (Mois == 1) {
    Jours_par_Mois[1] = ((Annee % 400 == 0) || ((Annee % 4 == 0) && (Annee % 100 !=0))) ? 29 : 28;
    }
    var Header_String = Nom_Mois[Mois] + ' ' + Annee;
    return Header_String;
    }
    
    
    
    function Genere_cal(Annee, Mois) {
    var First_Date = new Date(Annee, Mois, 1);
    var Heading = Header(Annee, Mois);
    var First_Day = First_Date.getDay() ;
    if (((Jours_par_Mois[Mois] == 31) && (First_Day >= 6)) ||
    ((Jours_par_Mois[Mois] == 30) && (First_Day == 7))) {
    var Rows = 6;
    }
    else if ((Jours_par_Mois[Mois] == 28) && (First_Day == 1)) {
    var Rows = 4;
    }
    else {
    var Rows = 5;
    }
    
    var HTML_String = '<table><tr><td valign="top"><table BORDER=4 CELLSPACING=1 cellpadding=2 FRAME="box" BGCOLOR="C0C0C0" BORDERCOLORLIGHT="808080">';
    
    HTML_String += '<tr><th colspan=7 BGCOLOR="FFFFFF" BORDERCOLOR="000000">' + Heading + '</font></th></tr>';
    
    HTML_String += '<tr>' +
        '<th ALIGN="CENTER" BGCOLOR="FFFFFF" BORDERCOLOR="000000">Lun</th>' +
        '<th ALIGN="CENTER" BGCOLOR="FFFFFF" BORDERCOLOR="000000">Mar</th>' +
        '<th ALIGN="CENTER" BGCOLOR="FFFFFF" BORDERCOLOR="000000">Mer</th>' +
        '<th ALIGN="CENTER" BGCOLOR="FFFFFF" BORDERCOLOR="000000">Jeu</th>' +
        '<th ALIGN="CENTER" BGCOLOR="FFFFFF" BORDERCOLOR="000000">Ven</th>' +
        '<th ALIGN="CENTER" BGCOLOR="FFFFFF" BORDERCOLOR="000000">Sam</th>' +
        '<th ALIGN="CENTER" BGCOLOR="FFFFFF" BORDERCOLOR="000000">Dim</th>' +
    '</tr>';
    
    var Day_Counter = 1;
    var Loop_Counter = 1;
    for (var j = 1; j <= Rows; j++) {
    HTML_String += '<tr ALIGN="left" VALIGN="top">';
    for (var i = 1; i < 8; i++) {
    if ((Loop_Counter >= First_Day) && (Day_Counter <= Jours_par_Mois[Mois])) {
    if ((Day_Counter == Aujourdhui) && (Annee == Annee_Actuel) && (Mois == Mois_Actuel)) {
    HTML_String += '<td BGCOLOR="FFFFFF" BORDERCOLOR="000000"><strong><font color="red">' + Day_Counter + '</font></strong></td>';
    }
    else {
    HTML_String += '<td BGCOLOR="FFFFFF" BORDERCOLOR="000000">' + Day_Counter + '</td>';
    }
    Day_Counter++;
    }
    else {
    HTML_String += '<td BORDERCOLOR="C0C0C0"> </td>';
    }
    Loop_Counter++;
    }
    HTML_String += '</tr>';
    }
    HTML_String += '</table></td></tr></table>';
    cross_el=ns6? document.getElementById("Calendar") : document.all.Calendar
    cross_el.innerHTML = HTML_String;
    }
    
    
    function Check_Nums() {
    if ((event.keyCode < 48) || (event.keyCode > 57)) {
    return false;
    }
    }
    
    
    
    function On_Year() {
    var Annee = document.when.Annee.value;
    if (Annee.length == 4) {
    Choix_Mois = document.when.Mois.selectedIndex;
    Choix_Annee = Annee;
    Genere_cal(Choix_Annee, Choix_Mois);
    }
    }
    
    function On_Month() {
    var Annee = document.when.Annee.value;
    if (Annee.length == 4) {
    Choix_Mois = document.when.Mois.selectedIndex;
    Choix_Annee = Annee;
    Genere_cal(Choix_Annee, Choix_Mois);
    }
    else {
    alert('Please enter a valid Annee.');
    document.when.Annee.focus();
    }
    }
    
    
    function Defaults() {
    if (!ie4&&!ns6)
    return
    var Mid_Screen = Math.round(document.body.clientWidth / 2);
    document.when.Mois.selectedIndex = Mois_Actuel;
    document.when.Annee.value = Annee_Actuel;
    Choix_Mois = Mois_Actuel;
    Choix_Annee = Annee_Actuel;
    Genere_cal(Annee_Actuel, Mois_Actuel);
    }
    
    
    function Skip(Direction) {
    if (Direction == '+') {
    if (Choix_Mois == 11) {
    Choix_Mois = 0;
    Choix_Annee++;
    }
    else {
    Choix_Mois++;
    }
    }
    else {
    if (Choix_Mois == 0) {
    Choix_Mois = 11;
    Choix_Annee--;
    }
    else {
    Choix_Mois--;
    }
    }
    Genere_cal(Choix_Annee, Choix_Mois);
    document.when.Mois.selectedIndex = Choix_Mois;
    document.when.Annee.value = Choix_Annee;
    }