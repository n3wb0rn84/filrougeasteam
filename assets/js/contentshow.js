//Show and Hide Content Div's
$('#acc').click(function(event){
  $('#accueil').removeClass('d-none').addClass('d-block');
  $('#collecte, #encombrants, #cooperative, #procedures').removeClass('d-block').addClass('d-none');
});

$('#proced').click(function(event){
  $('#procedures').removeClass('d-none').addClass('d-block');
  $('#accueil, #collecte, #encombrants, #cooperative').removeClass('d-block').addClass('d-none');
});

$('#encomb').click(function(event){
  $('#encombrants').removeClass('d-none').addClass('d-block');
  $('#accueil, #collecte, #procedures, #cooperative').removeClass('d-block').addClass('d-none');
});

$('#coop').click(function(event){
  $('#cooperative').removeClass('d-none').addClass('d-block');
  $('#accueil, #collecte, #encombrants, #procedures').removeClass('d-block').addClass('d-none');
});

$('#coll').click(function(event){
  $('#collecte').removeClass('d-none').addClass('d-block');
  $('#accueil, #encombrants, #procedures, #cooperative').removeClass('d-block').addClass('d-none');
});
