<!DOCTYPE html>
<html>
<head>
	<title>csv to sqlite viewer</title>
	<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
</head>
<body>

<table class="table">
  <thead>
    <tr class="heads">
      <th scope="col">#</th>
    </tr>
  </thead>
  <tbody class="table_body">
  
  </tbody>
</table>

<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

<script>
$.get('csvtosqlite.php',(data)=>{
	data = JSON.parse(data)
	//Set titles of table
	data['column_names'].forEach((column_name)=>{
		$('.heads').append(`<th scope="col">${column_name}`)
	})
	delete data["column_names"];
	let get_param = parseInt(<?php echo $_GET['id']?>);
	let key = 0
	Object.entries(data).forEach((item)=>{
		if(get_param==key){
			let tr = document.createElement('tr')
			let th = document.createElement('th')
			th.innerText = parseInt(item[0])+1
			tr.appendChild(th)
			Object.entries(item[1]).forEach((items)=>{
				let td = document.createElement('td')
				td.innerText = items[1]
				tr.appendChild(td)
			})
			console.log(`hola ${get_param}`)
		$('.table_body').append(tr)
		}
		key++;
	})
})

</script>
</body>
</html>