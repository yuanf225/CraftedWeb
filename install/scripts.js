$().ready(function() 
{

    // Step One
    $('#checkbox_logon').click(function() 
    {
        if (document.getElementById("checkbox_logon").checked == true) 
        {
            $("#logon_host").removeAttr('disabled');
            $("#logon_port").removeAttr('disabled');
            $("#logon_user").removeAttr('disabled');
            $("#logon_password").removeAttr('disabled');
        }
        else if(document.getElementById("checkbox_logon").checked == false) 
        {
            $("#logon_host").attr('disabled', true);
            $("#logon_port").attr('disabled', true);
            $("#logon_user").attr('disabled', true);
            $("#logon_password").attr('disabled', true);
        }
    });

    $('#checkbox_world').click(function() 
    {
        if (document.getElementById("checkbox_world").checked == true) 
        {
            $("#world_host").removeAttr('disabled');
            $("#world_port").removeAttr('disabled');
            $("#world_user").removeAttr('disabled');
            $("#world_password").removeAttr('disabled');
        }
        else if(document.getElementById("checkbox_world").checked == false) 
        {
            $("#world_host").attr('disabled', true);
            $("#world_port").attr('disabled', true);
            $("#world_user").attr('disabled', true);
            $("#world_password").attr('disabled', true);
        }
    });

    $('#checkbox_characters').click(function() 
    {
        if (document.getElementById("checkbox_characters").checked == true) 
        {
            $("#characters_host").removeAttr('disabled');
            $("#characters_port").removeAttr('disabled');
            $("#characters_user").removeAttr('disabled');
            $("#characters_password").removeAttr('disabled');
        }
        else if(document.getElementById("checkbox_characters").checked == false) 
        {
            $("#characters_host").attr('disabled', true);
            $("#characters_port").attr('disabled', true);
            $("#characters_user").attr('disabled', true);
            $("#characters_password").attr('disabled', true);
        }
    });


    // Step Five

    var realmSt = document.getElementById("realm_sendtype");
    var realmSp = document.getElementById("realm_soap");
    var realmRa = document.getElementById("realm_ra");

    realmSp.disabled = true;
    realmSp.hidden = true;

    realmRa.disabled    = true;
    realmRa.hidden      = true;

    $('#realm_sendtype').change(function(event)
    {
        if (realmSt.options[realmSt.selectedIndex].text == "RA")
        {
            realmRa.disabled = false;
            realmRa.hidden = false;

            if (realmSp.disabled == false && 
                realmSp.hidden == false)
            {
                realmSp.disabled = true;
                realmSp.hidden = true;
            }
        }
        else if (realmSt.options[realmSt.selectedIndex].text == "SOAP")
        {
            realmSp.disabled = false;
            realmSp.hidden = false;

            if (realmRa.disabled == false && 
                realmRa.hidden == false)
            {
                realmRa.disabled = true;
                realmRa.hidden = true;
            }
        }
        else if (realmSt.options[realmSt.selectedIndex].value == "none")
        {
            realmSp.disabled = true;
            realmSp.hidden = true;

            realmRa.disabled = true;
            realmRa.hidden = true;
        }
    });
});


function step1()
{
    $("#info").html("");

    var web             = "website_";
    var web_host        = document.getElementById(web +"host").value;
    var web_port        = document.getElementById(web +"port").value;
    var web_user        = document.getElementById(web +"user").value;
    var web_password    = document.getElementById(web +"password").value;
    var web_database    = document.getElementById(web +"database").value;

    var logon           = "logon_";
    var logon_host      = document.getElementById(logon +"host").value;
    var logon_port      = document.getElementById(logon +"port").value;
    var logon_user      = document.getElementById(logon +"user").value;
    var logon_password  = document.getElementById(logon +"password").value;
    var logon_database  = document.getElementById(logon +"database").value;
    var logon_checked   = document.getElementById("checkbox_logon").checked;

    var characters           = "characters_";
    var characters_host      = document.getElementById(characters +"host").value;
    var characters_port      = document.getElementById(characters +"port").value;
    var characters_user      = document.getElementById(characters +"user").value;
    var characters_password  = document.getElementById(characters +"password").value;
    var characters_database  = document.getElementById(characters +"database").value;
    var characters_checked   = document.getElementById("checkbox_characters").checked;

    var world           = "world_";
    var world_host      = document.getElementById(world +"host").value;
    var world_port      = document.getElementById(world +"user").value;
    var world_user      = document.getElementById(world +"user").value;
    var world_password  = document.getElementById(world +"password").value;
    var world_database  = document.getElementById(world +"database").value;
    var world_checked   = document.getElementById("checkbox_world").checked;


    var realmlist       = document.getElementById("realmlist").value;
    var title           = document.getElementById("title").value;
    var email           = document.getElementById("email").value;
    var domain          = document.getElementById("domain").value;
    var expansion       = document.getElementById("expansion").value;
    var paypal          = document.getElementById("paypal").value;

    var sent_submit     = "step1";
    $.post("functions.php",
    {
        step: 1,

        submit: sent_submit,

        web_host: web_host,
        web_port: web_port,
        web_user: web_user,
        web_password: web_password,
        web_database: web_database,

        logon_host: logon_host,
        logon_port: logon_port,
        logon_user: logon_user,
        logon_password: logon_password,
        logon_database: logon_database,
        logon_checked: logon_checked,

        characters_host: characters_host,
        characters_port: characters_port,
        characters_user: characters_user,
        characters_password: characters_password,
        characters_database: characters_database,
        characters_checked: characters_checked,

        world_host: world_host,
        world_port: world_port,
        world_user: world_user,
        world_password: world_password,
        world_database: world_database,
        world_checked: world_checked,

        realmlist: realmlist,
        domain: domain,
        title: title,
        expansion: expansion,
        email: email,
        paypal: paypal
    },
    function (data)
    {
        if (data != true)
        {
            $("#info").html("<p><code>"+ data +"</code></p>");
        }
        else if (data == true)
        {
            window.location = "?step=2";
        }
    });
}

function step2()
{
    $("#info").html("");

    var submit = "step2";

    $.post("functions.php", {step: 2, sent_submit: submit},
        function (data)
        {
            $("#info").html("<p><code>" + data + "</code></p>");
        }
    );
}

function step3()
{
    $("#info").html("");

    var sent_submit = "step3";

    $.post("functions.php", {step: 3, submit: sent_submit},
        function (data)
        {
            $("#info").html("<p><code>" + data + "</code></p>");
        }
    );
}

function step4()
{
    $("#info").html("");

    var sent_submit = "step4";;

    $.post("functions.php", {step: 4, submit: sent_submit},
        function (data)
        {
            $("#info").html("<p><code>" + data + "</code></p>");
        }
    );
}

function step5()
{
    var name        = document.getElementById("realm_name").value;
    var username    = document.getElementById("realm_access_username").value;
    var password    = document.getElementById("realm_access_password").value;
    var description = document.getElementById("realm_description").value;
    var sendtype    = document.getElementById("realm_sendtype").value;

    var soap_port   = document.getElementById("realm_soap_port");
    var ra_port     = document.getElementById("realm_ra_port");    
    var port        = null;

    if (ra_port.disabled == true) 
    {
        port = soap_port.value;
    }
    else if (soap_port.disabled == true) 
    {
        port = ra_port.value;
    }

    if (port == null)
    {
        port = "3443";
    }

    var sent_submit = "step5";

    $.post("functions.php",
        {
            step: 5,
            submit: sent_submit,

            realm_name: name,
            realm_access_username: username,
            realm_access_password: password,
            realm_description: description,
            realm_sendtype: sendtype,
            realm_port: port
        },
        function (data)
        {
            if (data != true)
            {
                $("#info").html("<p><code>"+ data +"</code></p>");
            }
        }
    );
}