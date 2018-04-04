function blockAdblockUser() {

var height = $("#AdNavigation").height();
console.log('Taille ' + height);

   if ($('#AdNavigation').filter(':visible').length == 0) {

 $('#siAdblock').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                }); 

    } else if ($('#AdNavigation').filter(':hidden').length > 0) {
        // Maybe a different error if only some are hidden?
        // Redirect, show dialog, do something...
    }
}



var AUTH0_CLIENT_ID='AnEvR74LsgHDqRKJd_L8y9DEphmav3iB';
var AUTH0_DOMAIN='leskits.eu.auth0.com';

$('document').ready(function() {

    blockAdblockUser();

    var options = {
        theme: {
          logo: 'https://leskits.com/assets/img/logo-kit-full.png'
        },
        language: 'fr',
        languageDictionary: {
            title: 'leskits.com'
          },
        popup: true,
        socialButtonStyle: 'small'
      };
    var lock = new Auth0Lock(AUTH0_CLIENT_ID,AUTH0_DOMAIN,options);
    var globalProfile = localStorage.getItem('kitsProfile') && JSON.parse(localStorage.getItem('kitsProfile'));
    var globalToken = localStorage.getItem('kitsAccessToken');

    if(globalProfile && globalToken){
        login(globalProfile,globalToken);
    }
    function login(profile,token){
        if(!token || !profile){
            return;
        }

        submitRegistration(profile,token);
    }

    function submitRegistration(profil,token)
    {
     $.ajax({
      type: 'POST',
      url: 'https://leskits.com/ajaxRequest/requestRegistration.php',
      data: {'profil':JSON.stringify(profil),'token':token},
      dataType: 'json', 
      success: function(json) {
          if(json.connexion.id == 4){
            $('#errorConnexion').text(json.connexion.message);
            $('#errorConnexion').show();
            setTimeout(function(){
                $('#errorConnexion').hide();
             }, 3000);
          }else{
            localStorage.setItem('kitsAccessToken', token);
            localStorage.setItem('kitsProfile', JSON.stringify(profil));
            $('#connexionLi').hide();
            $('#profilLi').show();
            $('.owner').show();
            $('#userAvatar').attr('src',profil.picture);
            $('#userName').text(profil.name);
          }
        
        }});
      }

    function logout(){
        localStorage.removeItem('kitsAccessToken');
        localStorage.removeItem('kitsProfile');
        lock.logout({
            returnTo: 'https://leskits.com/ajaxRequest/requeteDeconnexion.php'
          });
    }
    lock.on("authenticated", function(authResult) {
        lock.getUserInfo(authResult.accessToken, function(error, profile) {
          if (error) {
            return;
          }
      login(profile,authResult.accessToken);
        });

    });
    $('#deconnexionLi').click(function(e){
        e.preventDefault();
        logout();
    });
    $('#connexionLi').click(function(e){
        e.preventDefault();
        lock.show(function(err, profile,token){
            if(err){
                return;
            }
            alert(profile);
            globalProfile = profile;
            globalToken = token;

            localStorage.setItem('token',globalToken);
            localStorage.setItem('profile',JSON.stringify(globalProfile));
        });
    })
});
