function mostrarContrasena() {
  var tipo = document.getElementById("password");
  if (tipo.type == "password") {
    tipo.type = "text";
  } else {
    tipo.type = "password";
  }
}

function getURL() { 
var id_user = document.getElementById('id_user').value;
var tipo_user = document.getElementById('tipo_user').value;
var url = "update_permissions.php?id_user="+id_user+"&tipo_user="+tipo_user;
window.location.href = url;
}

function mostrar(id) {
  if (id == "si") {
      $("#enfermero").show();
  }
  if (id == "no") {
    $("#enfermero").hide();
}
}

function upload_image(){//Funcion encargada de enviar el archivo via AJAX
  $(".upload-msg").text('Subiendo, por favor espere...');
  var inputFileImage = document.getElementById("fileToUpload");
  var file = inputFileImage.files[0];
  var data = new FormData();
  data.append('fileToUpload',file);
  
  /*jQuery.each($('#fileToUpload')[0].files, function(i, file) {
    data.append('file'+i, file);
  });*/
        
  $.ajax({
    url: "functionality/upload_photo.php",        // Url to which the request is send
    type: "POST",             // Type of request to be send, called as method
    data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    contentType: false,       // The content type used when sending data to the server.
    cache: false,             // To unable request pages to be cached
    processData:false,        // To send DOMDocument or non processed data file it is set to false
    success: function(data)   // A function to be called if request succeeds
    {
      $(".upload-msg").html(data);
      window.setTimeout(function() {
      $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove();
      });	}, 5000);
    }
  });
  
}

function upload_image2(){//Funcion encargada de enviar el archivo via AJAX
  $(".upload-msg").text('Subiendo, por favor espere...');
  var inputFileImage = document.getElementById("fileToUpload");
  var file = inputFileImage.files[0];
  var data = new FormData();
  data.append('fileToUpload',file);
  
  /*jQuery.each($('#fileToUpload')[0].files, function(i, file) {
    data.append('file'+i, file);
  });*/
        
  $.ajax({
    url: "../functionality/upload_photo.php",        // Url to which the request is send
    type: "POST",             // Type of request to be send, called as method
    data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    contentType: false,       // The content type used when sending data to the server.
    cache: false,             // To unable request pages to be cached
    processData:false,        // To send DOMDocument or non processed data file it is set to false
    success: function(data)   // A function to be called if request succeeds
    {
      $(".upload-msg").html(data);
      window.setTimeout(function() {
      $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove();
      });	}, 5000);
    }
  });
  
}

$(document).ready(function(){

$("#mostrar-nav").on("click", function () {
  $("section").toggleClass("mostrar");
});

$('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    
    $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
});

});

