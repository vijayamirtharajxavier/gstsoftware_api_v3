var manageLedgerTable;
var manageledgeropTable;
var manageLedgerOpBal;
let table, names;


$(document).ready(function(){

var opbalurl = 'getopenbal';
url = opbalurl.replace("undefined","");


$.getJSON(url, 
function (data) {
var student = '';

// ITERATING THROUGH OBJECTS
console.log(data.data);

$.each(data.data, function (key, value) {
//CONSTRUCTION OF ROWS HAVING
// DATA FROM JSON OBJECT
student += '<tr>';
student += '<td>' + 
	value.account_name + '</td>';
	student += '<td>' + 
	value.id + '</td>';
	student += '<td><input type="text" id="obal" name="obal[]">' + 
	value.open_bal + '</td>';
	student += '<tr>';

});

$('#ledgeropTable').append(student);
});





manageLedgerOpBal = $('#old_ledgeropTable').DataTable({
"destroy":true,
"paging":   false,
"ajax": url,
"columns": [
            { "data": "account_name" },
            {"data": "id"},
            { "data": "open_bal" }
],

"columnDefs": [
  {
      "targets": 0, // your case first column
      "className": "text-left",
      "width": "100px"
 },
  
  {
      "targets": 1, // your case first column
      "className": "text-right",
      "visible":true,
      "width": "15px"
 },
  {
      "targets": 2, // your case first column
      "className": "text-right",
      "width":"20px"

      
 }
 ]
});



//Load Opbal Ledger

$("#optbl").jsGrid({
	width: "100%",
	height: "400px",
//			filtering: false,
//		editing: false,
//		sorting: true,
//		paging: true,
//	data: friends,
	
filtering: true,
editing: true,
sorting: true,
paging: true,
autoload: true,

pageSize: 15,
pageButtonCount: 5,

deleteConfirm: "Do you really want to delete the client?",


		//deleteConfirm: "Do you really want to delete the client?",
		controller: {
						loadData: function (filter) {
								var d1 = $.Deferred();                 
								$.ajax({
									 type: "GET",
									 url: 'getopenbala',
									 data: '{}',
									 contentType: "application/json; charset=utf-8",
									 dataType: "json",
								}).done(function (response) {
									console.log(response);
										d1.resolve(response);
								});

								return d1.promise();
						},
				},

	fields: [
		{ name: "account_name", type: "text", width: 100, title: "Account Name" },
		{ name: "id", type: "text", width: 10, title: "#" },
		{ opbal: "op_bal", type: "text", width: 10, title: "Opening Balance" },
		//	countries
//				{ name: "Cool", type: "checkbox", width: 40, title: "Is Cool", sorting: false },
		{ type: "control" }
	],
			rowClick: function (args) {

							$(".jsgrid-row, .jsgrid-alt-row").removeClass("highlight");
							gRow = this.rowByItem(args.item);
							gRow.addClass("highlight");
							selectRowItem = args.item;
							console.log((selectRowItem))
			 
						 







												//	$("#companyselectModal").modal('show');

													var id=selectRowItem.company_id;
												  var op_bal = selectRowItem.op_bal;
													//		var email=response.email;
													var finyear=selectRowItem.finyear;
											//		var userid = response.userid;
										//			var authkey=response.authkey;
													var compid = selectRowItem.company_id;
												 // console.log(id);
//                              var furl = 'login/log?id='+id+'&email='+email+'&finyear='+finyear+'&userid='+userid+'&authkey='+authkey;
											//		var furl = 'login/log?id='+id+'&email='+email+'&compid='+compid +'&finyear='+finyear+'&userid='+userid+'&authkey='+authkey;

												 // console.log(furl);
													//window.location.href = furl;                  
												//window.location.replace(furl);
													//	$('.form-group').removeClass('has-error').removeClass('has-success');
												//		$('.text-danger').remove(); 

													},
 
}) ;







   
   }); //Document.ready


function opsave_btn()
{
	var $table = $("ledgeropTable")
	rows = [],
	header = [];

$table.find("thead th").each(function () {
	header.push($(this).html());
});

$table.find("tbody tr").each(function () {
	var row = {};
	
	$(this).find("td").each(function (i) {
			var key = header[i],
					value = $(this).html();
			
			row[key] = value;
	});
	
	rows.push(row);
});
	
	
alert(JSON.stringify(rows));


}



function Convert() {
	var table = document.getElementById("ledgeropTable");
	var header = [];
	var rows = [];

	for (var i = 0; i < table.rows[0].cells.length; i++) {
		header.push(table.rows[0].cells[i].innerHTML);
	}

	for (var i = 1; i < table.rows.length; i++) {
		var row = {};
		for (var j = 0; j < table.rows[i].cells.length; j++) {
			row[header[j]] = table.rows[i].cells[j].innerHTML;
		}
		rows.push(row);
	}

	alert(JSON.stringify(rows));
}






function saveOpenBal()
{
var opval='';
console.log('Save Opbal Clicked');

  table = document.getElementById('ledgeropTable');
    names = [...document.getElementById('ledgeropTable').querySelectorAll("th")].map(th => th.innerText).slice(1);  
  
console.log(table);

save();
/*console.log(headers);
console.log(data);
/*
var noticeMap = $('#ledgeropTable tbody tr').map(function() {
    var $cells = $(this).children();
    //console.log($cells);
    console.log($cells.eq(0).children('input').val());

    return {
      sequence: $cells.eq(0).children('input').val(),
      noticeUID: $cells.eq(1).text()
    };
});


/*
     var myTab = document.getElementById('ledgeropTable');
    var json="";
        // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
        for (i = 1; i < myTab.rows.length; i++) {

            // GET THE CELLS COLLECTION OF THE CURRENT ROW.
            var objCells = myTab.rows.item(i).cells;

            // LOOP THROUGH EACH CELL OF THE CURENT ROW TO READ CELL VALUES.
            for (var j = 0; j < objCells.length; j++) {
               json = json + ' ' + objCells.item(j).innerHTML;
//                info.innerHTML = info.innerHTML + ' ' + objCells.item(j).innerHTML;
            }
  //          info.innerHTML = info.innerHTML + '<br />';     // ADD A BREAK (TAG).
    console.log(json);


        }

*/

    }




const save = () => {
  const vals = [...table.querySelectorAll("tr")]
    .map(row => [...row.querySelectorAll("input")]
      .map((inp, i) => ({ [names[i]]: inp.value}))
      );
  console.log(vals); // here you need to ajax to the server;
console.log(vals[2][1].OpBal);
$.ajax({
  url: 'updateOpBal',
  data: {'opdata':vals}, 
  success: function(result) {
        alert('SUCCESS');
  }
});
  }





//Add Sales Message

$("#updateOpBalForm").unbind('submit').bind('submit', function() {
	var form = $(this);
	var url = form.attr('action');
	var type = form.attr('method');
rloader = document.querySelector(".rloader");        
rloader.style.display = "block";
	$.ajax({
			url: url,
			type: type,
			data: form.serialize(),
			dataType: 'json',
			success:function(response) {
				console.log(response);
					if(response.success == true) { 
					rloader.style.display = "none";                     
									$("#add-sales-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
										'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
										response.messages + 
									'</div>');



$("#add-sales-message").fadeTo(2000, 500).slideUp(500, function(){
$("#success-alert").slideUp(500);

});


$("#updateOpBalForm").trigger("reset");
manageledgeropTable.ajax.reload(null, false);
//$("#InvoiceItems tbody tr").remove(); 
$("#cname").html("");
							}   
							else {                                  

									$("#error-product-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
										'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
										response.messages + 
									'</div>');


$("#error-sales-message").fadeTo(2000, 500).slideUp(500, function(){
$("#success-alert").slideUp(500);

});
									
									$.each(response.messages, function(index, value) {
											var key = $("#" + index);

											key.closest('.form-group')
											.removeClass('has-error')
											.removeClass('has-success')
											.addClass(value.length > 0 ? 'has-error' : 'has-success')
											.find('.text-danger').remove();                         

											key.after(value);
									});
																					
							} // /else
			} // /.success
	}); // /.ajax funciton
	return false;
});

