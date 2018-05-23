$(document).ready(function () {

    //Osztályzatok ---------------------------------------------------------

    var osztLista = $("#osztalyzatlista");

    //Osztalyzat lista betoltese
    function load() {
        osztLista.load("php/read.php", {targy: targy});
    }

    load();

    //Egyenleg betöltése
    function balanceLoad() {
        $("#egyenleg").load("php/balance.php");
    }

    balanceLoad();

    var oszlop, sorrend;
    var sortable = $(".sortable");
    var filter = $("#targy");
    var targy;

    sortable.attr("title", "Sorba rendezéshez kattintson!");

    filter.load("php/targy.php", {filter: "targyfilter"});
    $("#ujtargy").load("php/targy.php", {filter: "no"});
    $("#ujtipus").load("php/tipus.php");
    $("#edittargy").load("php/targy.php", {filter: "no"});
    $("#edittipus").load("php/tipus.php");

    //Keresés
    filter.change(function () {

        targy = filter.val();
        load();

    });

    //Sorrend változtatás
    sortable.click(function () {

        if (sorrend === "ASC") {
            sorrend = "DESC";
        } else {
            sorrend = "ASC";
        }

        oszlop = $(this).attr("id");

        osztLista.load("php/read.php", {targy: targy, oszlop: oszlop, sorrend: sorrend});
    });

    //Új osztályzat felvitele
    //Dátum alapértelmezett kitöltése az aktuális dátummal
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;
    var today = year + "-" + month + "-" + day;
    $("#ujdatum").attr("value", today);
    //Mentés
    $("#save").click(function () {
        var ujDatum = $("#ujdatum").val();
        var ujTargy = $("#ujtargy").val();
        var ujOsztalyzat = $("#ujosztalyzat").val();
        var ujTipus = $("#ujtipus").val();
        $.post("php/create.php",
            {ujdatum: ujDatum, ujtargy: ujTargy, ujosztalyzat: ujOsztalyzat, ujtipus: ujTipus},
            function () {
                load();
                balanceLoad()
            });
    });

    //Módosítás gomb, adatok betöltése, modal megjelenítése
    osztLista.on("click", ".edit", function () {
        var id = $(this).parent().siblings(".id").text();
        var datum = $(this).parent().siblings(".datum").text();
        var ttargy = $(this).parent().siblings(".ttargy").attr("data-id");
        var osztalyzat = $(this).parent().siblings(".osztalyzat").text();
        var tipus = $(this).parent().siblings(".tipus").attr("data-id");
        $("#editid").text(id);
        $("#editdatum").attr("value", datum);
        $("#edittargy").val(ttargy);
        $("#editosztalyzat").val(osztalyzat);
        $("#edittipus").val(tipus);
        $("#editmodal").modal("toggle");
    });

    //Módosítás mentése
    $("#editsave").click(function () {
        var id = $("#editid").text();
        var ujDatum = $("#editdatum").val();
        var ujTargy = $("#edittargy").val();
        var ujOsztalyzat = $("#editosztalyzat").val();
        var ujTipus = $("#edittipus").val();
        $.post("php/update.php",
            {id: id, ujdatum: ujDatum, ujtargy: ujTargy, ujosztalyzat: ujOsztalyzat, ujtipus: ujTipus},
            function () {
                load();
                balanceLoad()
            });
        $("#editmodal").modal("toggle");
    });

    //Bezárás mentés nélkül
    $("#editcancel").click(function () {
        $("#editmodal").modal("toggle");
    });

    //Törlés gomb, modal megjelenítése
    osztLista.on("click", ".delete", function () {
        var id = $(this).parent().siblings(".id").text();
        $("#deleteid").text(id);
        $("#deletemodal").modal("toggle");
    });

    //Törlés végrehajtása
    $("#deletebutton").click(function () {
        var id = $("#deleteid").text();
        $.post("php/delete.php", {id: id},
            function () {
                load();
                balanceLoad()
            });
    });


    //Zsebpénz-----------------------------------------------------------------

    var ujKifizetes = true;
    var zspLista = $("#zsplista");

    zspLista.on("click", ".zspedit", function () {
        $("#zspModalLabel").text("Kifizetés módosítása");
        ujKifizetes = false;
        var id = $(this).parent().siblings(".id").text();
        var datum = $(this).parent().siblings(".datum").text();
        var osszeg = $(this).parent().siblings(".osszeg").text();
        $("#zspeditid").text(id);
        $("#ujzspdatum").attr("value", datum);
        $("#ujzsposszeg").val(osszeg);
        $("#zspmodal").modal("toggle");
    });

    //Törlés gomb, modal megjelenítése
    zspLista.on("click", ".zspdelete", function () {
        var id = $(this).parent().siblings(".id").text();
        $("#zspdeleteid").text(id);
        $("#zspdeletemodal").modal("toggle");
    });

    //Kifizetés lista betöltése
    function zspLoad() {
        zspLista.load("php/zsp_read.php");
    }

    zspLoad();

    //Új kifizetés
    $("#ujzspbutton").click(function () {
        ujKifizetes = true;
        $("#ujzspdatum").attr("value", today);
        $("#ujzsposszeg").val("");
        $("#zspModalLabel").text("Új kifizetés");
        $("#zspmodal").modal("toggle");
    });

    //Mentés
    $("#zspsave").click(function () {

        var ujZspDatum = $("#ujzspdatum").val();
        var ujZspOsszeg = $("#ujzsposszeg").val();

        if (ujKifizetes) {
            $.post("php/zsp_create.php", {ujzspdatum: ujZspDatum, ujzsposszeg: ujZspOsszeg},
                function () {
                    zspLoad();
                    balanceLoad()
                });

        } else {
            var id = $("#zspeditid").text();
            $.post("php/zsp_update.php", {id: id, ujzspdatum: ujZspDatum, ujzsposszeg: ujZspOsszeg},
                function () {
                    zspLoad();
                    balanceLoad()
                });
        }

    });

    //Törlés végrehajtása
    $("#zspdeletebutton").click(function () {
        var id = $("#zspdeleteid").text();
        $.post("php/zsp_delete.php", {id: id},
            function () {
                zspLoad();
                balanceLoad();
            });
    });

});