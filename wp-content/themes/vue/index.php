<!DOCTYPE html><html lang="en">
  <head>
    <meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="icon" href="/favicon.ico"><title>MyTube</title><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700&display=swap" rel="stylesheet"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"><script src="https://apis.google.com/js/platform.js?onload=renderButton" defer></script><meta name="google-signin-client_id" content="310021421846-4atakhdcfm62jj95u4193fu2ri8h9q40.apps.googleusercontent.com">
    <link href="<?php echo get_template_directory_uri(); ?>/css/app.ceb8201e.css" rel="preload" as="style">
    <link href="<?php echo get_template_directory_uri(); ?>/js/app.7da30587.js" rel="preload" as="script">
    <link href="<?php echo get_template_directory_uri(); ?>/js/chunk-vendors.a0a905bd.js" rel="preload" as="script">
    <link href="<?php echo get_template_directory_uri(); ?>/css/app.ceb8201e.css" rel="stylesheet">
  </head>
  <body>
    <noscript><strong>We're sorry but MyTube doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><script>/**
       * Google Authentication
       * Runs every time the page loads OR as the callback for the signin button
       */
      function onSignIn(googleUser) {
        var userEntity = {};
        userEntity = JSON.parse(sessionStorage.getItem('GoogleUser'));

        var reload = false
        if(! userEntity){
          reload = true;
        }
  
        var profile = googleUser.getBasicProfile();
        var myUserEntity = {};
        
        myUserEntity.Token = googleUser.getAuthResponse().id_token;
        myUserEntity.Id = profile.getId();
        myUserEntity.Name = profile.getName();
        myUserEntity.Email = profile.getEmail();
        myUserEntity.Image = profile.getImageUrl();
        
        //Store the entity object in sessionStorage where it will be accessible from all pages of your site.
        sessionStorage.setItem('GoogleUser',JSON.stringify(myUserEntity));
        
        // If we were not logged in already, reload after sign in in order for Vue to update as expected
        if(reload){
          //window.location.href = "/";
          location.reload();
        }
        
        gapi.auth2.init();

        // gapi.load('auth2', function() {
        //   gapi.auth2.init();
        // });

      }

      
  
      function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        
        auth2.signOut().then(function () {
          sessionStorage.clear();
          console.log('User signed out.');
          location.href = "/";
        });
      }

      function renderButton() {
        gapi.signin2.render('my-signin2', {
          'scope': 'profile email',
          'width': 36,
          'height': 36,
          'longtitle': false,
          'theme': 'dark',
          'onsuccess': onSignIn,
          'onfailure': onFailure
        });

        // We need to load our auth2 module so we can sign the user out if needed
        gapi.load('auth2', function() {
          gapi.auth2.init({
              client_id: "310021421846-4atakhdcfm62jj95u4193fu2ri8h9q40.apps.googleusercontent.com",
              //This two lines are important not to get profile info from your users
              fetch_basic_profile: false,
              scope: 'email'
          });        
        });  
        
        
      }

      function onFailure(){

      }</script><div id="app"></div><script src="<?php echo get_template_directory_uri(); ?>/js/chunk-vendors.a0a905bd.js"></script><script src="<?php echo get_template_directory_uri(); ?>/js/app.7da30587.js"></script></body></html>