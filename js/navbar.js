var list=document.getElementsByClassName('nav')[0].getElementsByTagName("li");
list[0].className="nav_active";
function change(e){
	for(var i=0;i<list.length;i++){
		list[i].className="";
	}
	e.className="nav_active";
}
function changecolor(e){
	for(var i=0;i<list.length;i++){
		list[i].style.backgroundColor="white";
	}
	e.style.backgroundColor="#0080FF";
}
function deletewrong(e){
	var chinese = e.id;
	window.location="index.php?act=delete&chinese="+chinese;
}
$(document).ready(function(){
		$('#sure').click(function(){
			$.ajax({
				type:"POST",
				url:"index.php",
				dataType:"json",
				data:{
					chinese:$('#chinese').val(),
					english:$('#english').val(),
					action:1,
				},
				success:function(data){
				if(data.success){
					$("#ifRight").html(data.msg);
				}
				else{
					$("#ifRight").html("出现错误:"+data.msg);
				}
			},
				error:function(jqXHR,error){
				console.log(error);
			}
			});
		});
		$('#sure_2').click(function(){
      $.ajax({
        type:"POST",
        url:"index.php",
        dataType:"json",
        data:{
          chinese2:$('#chinese_2').val(),
          english2:$('#english_2').val(),
        },
        success:function(data){
        if(data.success){
          $("#display").html(data.msg);
		  var content = data.content.split(";");
		  console.log(content);
		  var id,chinese,english,date;
		  //为错题本列表添加数值
		  if($('#table_wronglist').css('display')=="block"){
			  $(".show_wrong_list tr").remove("tr[id!=1]");//判断之前是否显示过列表，如果显示过，则只需清空之前的所有tr元素，无需再添加表
		  }
		  $('#table_wronglist').css('display','block');//显示错词本表头
		  for(var i=0;i<content.length-1;i++){
			  content[i] = content[i].split(",");
			  id = parseInt(content[i][0]);
			  chinese = content[i][1];
			  english = content[i][2];
			  date = content[i][4];
			  $('.show_wrong_list').append("<tr><td>"+id+"</td><td>"+chinese+"</td><td>"+english+"</td><td>"+date+"</td><td><div onclick="+'"'+"deletewrong(this)"+'"'+" class="+'"'+"btn btn-warning"+'"'+" id="+chinese+">删除</div></td></tr> ");
		  }
        }
        else{
          $("#display").html("出现错误:"+data.msg);
        }
      },
        error:function(jqXHR,error){
        console.log(error);
      }
      });
    });
	$('#sure_3').click(function(){
      $.ajax({
        type:"POST",
        url:"index.php",
        dataType:"json",
        data:{
          summary:$('#summary').val(),
        },
        success:function(data){
        if(data.success){
          $("#display_2").html(data.msg);
		  var content = data.content.split(";");
		  var id,sum,date;
		  console.log(content);
		  //为个人心得列表添加数值
		  if($('#table_summarylist').css('display')=="block"){
			  $(".show_summary_list tr").remove("tr[id!=1]");//判断之前是否显示过列表，如果显示过，则只需清空之前的所有tr元素，无需再添加表
		  }
		  else	$('#table_summarylist').css('display','block');//显示个人心得列表表头
		  for(var i=0;i<content.length-1;i++){
			  content[i] = content[i].split(",");
			  console.log(content);
			  id = parseInt(content[i][0]);
			  sum = content[i][2];
			  date = content[i][1];
			  $('.show_summary_list').append("<tr><td>"+id+"</td><td>"+sum+"</td><td>"+date+"</td></tr> ");
		  }
        }
        else{
          $("#display_2").html("出现错误:"+data.msg);
        }
      },
        error:function(jqXHR,error){
        console.log(error);
      }
      });
    });
	$('#next').click(function(){
      $.ajax({
        type:"POST",
        url:"index.php",
        dataType:"json",
        data:{
          chinese:$('#chinese').val(),
        },
        success:function(data){
        if(data.success){
          $("#ifRight").html(data.msg);
		  $("#chinese").val(data.question);
        }
        else{
          $("#ifRight").html("出现错误:"+data.msg);
        }
      },
        error:function(jqXHR,error){
        console.log(error);
      }
      });
    });
	$('#add').click(function(){
		$.ajax({
			type:"POST",
        url:"index.php",
        dataType:"json",
        data:{
          chinese3:$('#chinese_3').val(),
		  english3:$('#english_3').val(),
        },
		success:function(data){
			if(data.success){
				$("#show").html(data.msg);				
			}
			else{
				$("#show").html("出现错误:"+data.msg);
			}
		},
		error:function(jqXHR,error){
        console.log(error);
      }
		});
	});
	$('#test').click(function(){
			$.ajax({
				type:"POST",
				url:"index.php",
				dataType:"json",
				data:{
					chinese4:$('#chinese_4').val(),
					english4:$('#english_4').val(),
					action:1,
				},
				success:function(data){
				if(data.success){
					$("#ifWrongRight").html(data.msg);
				}
				else{
					$("#ifWrongRight").html("出现错误:"+data.msg);
				}
			},
				error:function(jqXHR,error){
				console.log(error);
			}
			});
		});
		$('#nextWrong').click(function(){
      $.ajax({
        type:"POST",
        url:"index.php",
        dataType:"json",
        data:{
          chinese4:$('#chinese_4').val(),
        },
        success:function(data){
        if(data.success){
          $("#ifWrongRight").html(data.msg);
		  $("#chinese_4").val(data.question);
        }
        else{
          $("#ifWrongRight").html("出现错误:"+data.msg);
        }
      },
        error:function(jqXHR,error){
        console.log(error);
      }
      });
    });
	
	});