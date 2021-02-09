<h1><?=$test?></h1>
<?="Dies ist ein Test"?>

<div class="ui-corner-all ui-state-highlight" id="login-success" style="">
      <span>Anmeldung erfolgreich</span>
      <a href="#" id="close-login-success">close</a>
</div>

<style>

div#login-success
{
    padding: .25em;
    position: fixed;
    top: 2.5rem;
    left: 25%;
    width: 50%;
    color: #fff;
    background-color: #006400;
    border: 1px solid #152f56;
    border-radius: 3px;
}


a#close-login-success {
    position: absolute;
    right: 1em;
    color: #b4c7d9;
    text-decoration: none;
}

</style>