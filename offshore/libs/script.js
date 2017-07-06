
var refreshIntervalTimer;

$(function(){
	$("#cbbDatabase").hide();
	$("#cbbTable").hide();
	$("#txtStatus").hide();
	$("#gLatency").hide();
	
	$("#cbbDatabase").change(function(){
		fn.select_database($(this).val());
	});
	
	$("#cbbLatency").change(function(){
		clearInterval(refreshIntervalTimer);
		fn.run();
	});
});
var fn = {
	change_concurrent : function(){
		$("#modelChangeConcurrent").modal('show');
	},
	confirm_change_concurrent : function(){
		$("#modelConfirmChangeConcurent").find('span').html($("select[name=cbbConcurrent]").val());
		$("#modelConfirmChangeConcurent").modal('show');
	},
	do_change_concurrent : function(){
		$.ajax({
			method: "POST",
			data:{
				dbname : $("#cbbDatabase").val(),
				concurrent : $("select[name=cbbConcurrent]").val()
			},
			url: "xhr/action-change-package.php",
			dataType: 'html',
			success: function(html){
				$("#modelChangeConcurrent").modal('hide');
				$("#modelConfirmChangeConcurent").modal('hide');
				fn.alert("Complete");
			}
		});
	},
	
	empty_table : function(){
		$("#txtTableRemove").html($("#cbbDatabase").val()+"."+$("#cbbTable").val());
		$("#modelDelete").modal('show');
	},
	truncate : function(){
		$.ajax({
			method: "POST",
			data:{
				dbname : $("#cbbDatabase").val(),
				tablename : $("#cbbTable").val()
			},
			url: "xhr/action-truncate.php",
			dataType: 'html',
			success: function(html){
				$("#modelDelete").modal('hide');
				fn.alert("Table : " + $("#cbbDatabase").val()+"."+$("#cbbTable").val() + " is empty!");
			}
		});
	},
	alert : function(text){
		$("#txtAlertMessage").html(text);
		$("#modalAlert").modal('show');
	},
	run : function(){
		refreshIntervalTimer = setInterval(function(){
			$.ajax({
				method: "POST",
				data:{
					dbname : $("#cbbDatabase").val(),
					tablename : 'concurrents'
				},
				url: "xhr/action-update.php",
				dataType: 'html',
				success: function(html){
					$("#mainpanel").html(html);
					var now = new Date();
					$("#txtUpdated").html(now.toLocaleTimeString());
				}
			});
		},$("#cbbLatency").val());
	},
	select_database : function(dbname){
		if(dbname==""){
			$("#gLatency").hide();
			clearInterval(refreshIntervalTimer);
		}else{
			$.ajax({
				method: "POST",
				data:{
					dbname : $("#cbbDatabase").val()
				},
				url: "xhr/action-select-db.php",
				dataType: 'json',
				success: function(json){
					if(json.success){
						$("#gLatency").show();
						$("input[name=txtCurrentConcurrent]").val(json.concurrent);
						$("select[name=cbbConcurrent]").val(json.concurrent);
						fn.run();
					}else{
						fn.alert(json.error_message);
					}
				}
			});
		}
	},
	connect : function(){
		$.ajax({
			method: "POST",
			data:{
				password : $("#txtPassword").val()
			},
			url: "xhr/action-connect.php",
			dataType: 'json',
			success: function(json){
				if(json.success){
					$("#txtStatus").show();
					$("#txtStatus").val('Connected');
					$("#btnConnect").hide();
					$("#txtPassword").hide();
					var s = '<option value="">Select Database</option>';
					for(i in json.database){
						s += '<option>';
							s += json.database[i];
						s += '</option>';
					}
					$("#cbbDatabase").html(s);
					$("#cbbDatabase").show();

				}else{
					fn.alert(json.error_message);
				}
				
			}
		});
	}
}


