<html>
<head>
<title>
TEST
</title>                                                           
<script type="text/javascript" src="jquery.js"></script>
<link href="styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function openFormAsNew() {
  $(".shading").css("display","block");
    $(".form-container").find("input").each(function (index1){
		let data1 = $(this);
		if (data1.attr("type") == "button" || data1.attr("type") == "submit")
			return
		data1.attr("value","");//
  });
}

function openFormAsEdit(conf,selectedRow)
{
	$(".shading").css("display","block");
	$("<input type=hidden name=u_id value="+selectedRow.data("u_id")+">").appendTo(".form-container");
	let uid = selectedRow.data("u_id");
	$("input[name=u_id]").value = uid;
	$(".form-container").find("input").each(function (index1){
		let data1 = $(this);
		if (data1.attr("type") == "button" || data1.attr("type") == "submit" || data1.attr("type") == "hidden")
			return
		data1.attr("value",selectedRow.find("td[name=\""+data1.attr('name')+"\"]").text());//
	});
}

function closeForm() {
  $(".shading").css("display","none");
  $(".form-container input[type=hidden]").remove();
}

let page = 1;

$( document ).ready(function() {
	refreshTable();
	
	$(".form-container").submit(function(e) {
		
		e.preventDefault();
		var form = $(this);
		var actionUrl = form.attr('action');
		
		$.ajax({
		url: "http://localhost/addTourist.php",
		method: "POST",
		async: false,
		data: form.serialize(),
		statusCode: {
			200: function() {
			},
			404: function() {
				alert( "page not found" );
			}
		},
		
		success: function(html){
		   var res = JSON.parse(html);
		   outData = res;
		   if (outData['status']=='error')
			   alert(outData['errInfo'])
		}
		
	});
		closeForm();
		refreshTable();
	})
	
});

function getTouristTable(page)
{
	let outData;
	$.ajax({
		url: "http://localhost/getTable.php?page="+page,
		method: "GET",
		async: false,
		statusCode: {
			200: function() {
				
			},
			404: function() {
				alert( "page not found" );
			}
		},
		
		success: function(html){
		   var res = JSON.parse(html);
		   outData = res.result;
		   if (res['status']=='error')
			   alert(res['errInfo'])
		}
	});
	return outData;
}

function refreshTable()
{
	dt = getTouristTable(page);
	let tableTag = $(".mainTable");
	tableTag.find("td").parent().remove();
	for (let user of dt.users)
	{
		let row = $("<tr data-u_id="+ user.u_id +" ><td name=u_surname>"+user.u_surname+"</td><td name=u_name>"+user.u_name+"</td><td name=u_sname>"+user.u_sname+"</td><td name=u_birthday>"+user.u_birthday+"</td><td name=u_surname_en>"+user.u_surname_en+"</td><td name=u_name_en>"+user.u_name_en+"</td><td name=u_zagran_expire>"+user.u_zagran_expire+"</td><td name=u_note>"+user.u_note+"</td></tr>");
		row.click(function()
		{
			var tr = $(this);
			openFormAsEdit(tr.data("id"),tr);
		}
		);
		row.appendTo(tableTag);	
	}
}
</script>
</head>
<body>
<h1>Таблица со списком туристов</h1><br>
<table class="mainTable">
	<tr>
		<th>Фамилия</th>
		<th>Имя</th>
		<th>Отчество</th>
		<th>Дата рождения</th>
		<th>Фамилия в загранпаспорте</th>
		<th>Имя в загранпаспорте</th>
		<th>Дата истечения годности загранпаспорта</th>
		<th>Примечание</th>
	</tr>
</table>
<div class="shading">
	<div class="form-popup" id="myForm">
	  <form action="/addTourist.php" class="form-container">
		<h1>Турист</h1>

		<label for="u_surname"><b>Фамилия</b></label>
		<input type="text" placeholder="Введите Фамилию" name="u_surname" required>

		<label for="u_name"><b>Имя</b></label>
		<input type="text" placeholder="Введите Имя" name="u_name" required>

		<label for="u_sname"><b>Отчество</b></label>
		<input type="text" placeholder="Введите Отчество" name="u_sname" required>

		<label for="u_birthday"><b>Дата рождения</b></label>
		<input type="text" placeholder="Введите Дату рождения" name="u_birthday" required>

		<label for="u_surname_en"><b>Фамилия в загранпаспорте</b></label>
		<input type="text" placeholder="Введите Фамилию в загранпаспорте" name="u_surname_en" required>

		<label for="u_name_en"><b>Имя в загранпаспорте</b></label>
		<input type="text" placeholder="Введите Имя в загранпаспорте" name="u_name_en" required>

		<label for="u_zagran_expire"><b>Дата истечения годности загранпаспорта</b></label>
		<input type="text" placeholder="Введите Дату истечения годности загранпаспорта" name="u_zagran_expire" required>

		<label for="u_note"><b>Примечание</b></label>
		<input type="text"" placeholder="Введите Примечание" name="u_note" required>


		<input type="submit" class="btn" value="Сохранить">
		<input type="button" class="btn cancel" onclick="closeForm()" value="Закрыть">
	  </form>
	</div>
</div>
<input type=button value="Добавить" onclick=openFormAsNew()>
</body>
</html>

