function getinfologinClient(){
    ajaxRequest('POST','./php_page/login_client.php/',test)
}
function getinfologinMedecin(){
    ajaxRequest('POST','./php_page/login_medecin.php/',test)
}
function test(){
    console.log("ssssssss")
}