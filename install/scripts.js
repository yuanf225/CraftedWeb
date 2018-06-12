function step1()
{
    $("#info").html("");
    var realmlist   = document.getElementsByName("step1_realmlist")[0].value;
    var title       = document.getElementsByName("step1_title")[0].value;
    var host        = document.getElementsByName("step1_host")[0].value;
    var user        = document.getElementsByName("step1_user")[0].value;
    var pass        = document.getElementsByName("step1_pass")[0].value;
    var webdb       = document.getElementsByName("step1_webdb")[0].value;
    var worlddb     = document.getElementsByName("step1_worlddb")[0].value;
    var logondb     = document.getElementsByName("step1_logondb")[0].value;
    var email       = document.getElementsByName("step1_email")[0].value;
    var domain      = document.getElementsByName("step1_domain")[0].value;
    var expansion   = document.getElementsByName("step1_exp")[0].value;
    var paypal      = document.getElementsByName("step1_paypal")[0].value;

    $.post("functions.php",
            {step: 1, 
                step1_realmlist: realmlist, 
                step1_title: title, 
                step1_host: host, 
                step1_user: user, 
                step1_pass: pass, 
                step1_webdb: webdb, 
                step1_worlddb: worlddb, 
                step1_logondb: logondb,
                step1_email: email, 
                step1_domain: domain, 
                step1_exp: expansion, 
                step1_paypal: paypal},
            function (data)
            {
                if (data == true)
                {
                    window.location = "?st=2";
                }
                else
                {
                    $("#info").html("<p><code>" + data + "</code></p>");
                }
            });
}

function step2()
{
    $("#info").html("");
    $.post("functions.php", {step: 2},
            function (data)
            {
                $("#info").html("<p><code>" + data + "</code></p>");
            }
    );
}

function step3()
{
    $("#info").html("");
    $.post("functions.php", {step: 3},
            function (data)
            {
                $("#info").html("<p><code>" + data + "</code></p>");
            }
    );

}

function step4()
{
    $("#info").html("");
    $.post("functions.php", {step: 4},
            function (data)
            {
                $("#info").html("<p><code>" + data + "</code></p>");
            }
    );

}

function step5()
{
    var name    = document.getElementsByName("addrealm_name")[0].value;
    var host    = document.getElementsByName("addrealm_host")[0].value;
    var port    = document.getElementsByName("addrealm_port")[0].value;
    var desc    = document.getElementsByName("addrealm_desc")[0].value;
    var m_host  = document.getElementsByName("addrealm_m_host")[0].value;
    var m_user  = document.getElementsByName("addrealm_m_user")[0].value;
    var m_pass  = document.getElementsByName("addrealm_m_pass")[0].value;
    var a_user  = document.getElementsByName("addrealm_a_user")[0].value;
    var a_pass  = document.getElementsByName("addrealm_a_pass")[0].value;
    var sendtype = document.getElementsByName("addrealm_sendtype")[0].value;
    var chardb  = document.getElementsByName("addrealm_chardb")[0].value;
    var raport  = document.getElementsByName("addrealm_raport")[0].value;
    var soapport = document.getElementsByName("addrealm_soapport")[0].value;

    if (soapport == "")
    {
        soapport = "NULL";
    }
    if (raport == "")
    {
        raport = "NULL";
    }

    $.post("functions.php", {
        step: 5, 
        name: addrealm_name, 
        host: addrealm_host, 
        port: addrealm_port, 
        desc: addrealm_desc, 
        m_host: addrealm_m_host, 
        m_user: addrealm_m_user, 
        m_pass: addrealm_m_pass,
        a_user: addrealm_a_user, 
        a_pass: addrealm_a_pass, 
        sendtype: addrealm_sendtype, 
        chardb: addrealm_chardb, 
        raport: addrealm_raport, 
        soapport: addrealm_soapport},

            function (data)
            {
                if (data == true)
                {
                    window.location = "?st=6";
                }
                else
                {
                    $("#info").html("<p><code>" + data + "</code></p>");
                }
            }
    );
}