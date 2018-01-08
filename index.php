<!DOCTYPE html> 
<html lang="ru"> 
<head> <meta charset="UTF-8"> 
	<title>Тестовое задание</title> 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

</head>

<body>
	<div class="jumbotron">
		<div class="container">
			<h1 class="display-3">Hello, world!</h1>
			<p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
		</div>
	</div>
	<div class="container"> 
       <br/><br/>
        <form method="post" action="res.php" id="myform" style="position:relative">
        <div id="result" style="position:absolute; top:-60%;"></div>
            <div class="form-row">
            	<div class="col-md-4 mb-3">
			      <label>First name</label>
			      <input type="text" class="form-control reset" name="name" placeholder="First name" required>
			    </div>
			    <div class="col-md-4 mb-3">
			      <label>Last name</label>
			      <input type="text" class="form-control reset" name="surname" placeholder="Last name" required>
			    </div>
			    <div class="col-md-4 mb-3">
			      <label>Age</label>
			      <input type="text" class="form-control reset" name="age" placeholder="18" required>
			    </div>

            </div>
        	<input class="btn btn-primary btn-lg" type="button" name="save" value="Сохранить" />
            <input class="btn btn-primary btn-lg" type="button" name="send" value="Выгрузить" />
        </form>




</div>

	</div>
	<footer>

	</footer>


<script>
jQuery(document).ready(function($) {

	$('#myform input[type=button]').click(function(e) {


		e.preventDefault();
		var data = $('#myform').serializeArray();

		// Отсылаем паметры
		$.ajax({
			type: "POST",
			url:$('#myform').attr('action'),
			data: $('#myform').serialize() + '&' + this.name + '=' + this.value,

			// Выводим то что вернул PHP
			success: function(data) {
		        $("#result").empty();
		        $('.reset').val('');
		        $("#result").fadeIn(10);
		        $("#result").append('<br /><strong>' + data + '</strong>')
		        			.delay(2000)
		        			.fadeOut(500);
		    },
		    error: function() {
		      	$("#result").empty();
		      	$("#result").append("Ошибка!");
		    }
		});

	});
});
</script>

</body>
</html>



