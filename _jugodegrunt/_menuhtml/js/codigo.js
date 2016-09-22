
$( document ).ready(function() {
	

    $('[data-toggle="tooltip"]').tooltip(); //para activar tooltip (onmouseover mensaje)

    bootstrap_equalizer();

    // para que aparezcan y desaparezcan los diferentes contenidos de ayuda
    $(".txtayuda").addClass('hidden');
    $('.toggle').click(function (event) {
    	$(".txtayuda").addClass('hidden');
        event.preventDefault();
        var target = $(this).attr('href');
        $(target).removeClass('hidden');
    });
});

// función que sirve para que se respeten las filas de Bootstrap a pesar de que los elementos tengan diferentes alturas
function bootstrap_equalizer() {
  $(".equalizer").each(function() {
    var heights = $(this).find(".watch").map(function() {
      return $(this).height();
    }).get(),

    maxHeight = Math.max.apply(null, heights);

    $(".watch").height(maxHeight);
  });
}
