$(document).ready(function() { 
    $("#profileli").addClass("active");

    $(".hoverg").hover(function() {
        $(".hoverg").css('cursor', 'pointer');
        $(".hoverg").css('transition', '0.2s');
        $(".hoverg").css('transform', 'scale(1.1,1.1)');
    });

    $(".hoverg").mouseleave(function() {
        $(".hoverg").css('cursor', 'default');
        $(".hoverg").css('transform', 'scale(1,1)');
    });
});

function edit(i, uid) {

	//if(i != 6) {
		if(i != 6) {
			var values = $('#td'+i).html();
			$('#td'+i).html("<input type='text' class='form-control' id='inputt' name='change' value='"+values+"'>");
			$('#td'+i+'0').html("<button type='button' id='savebuttopon' onclick='save("+i+", "+uid+")' class='btn btn-success'>Save</button>");
		} else {
			$('#td'+i).html("<form action=\"php/upload_file.php\" method=\"post\" enctype=\"multipart/form-data\"><input type=\"file\" name=\"file\" id=\"file\"><button type='submit' name=\"upload\" id='savebuttopon' class='btn btn-success'>Save</button></form>");
			$('#td'+i+'0').html("");
		}
		
		if(i != 6) {
			index = i+1;
			if(index > 6) {
				i = 0;
			}
			while(index != i) {

				$('#td'+index+'0').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");

				if(index == 6) {
					index = 0;
				} else {
					index++;
				}
			}
		} else {
			$('#td00').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
			$('#td10').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
			$('#td20').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
			$('#td30').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
			$('#td40').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
			$('#td50').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
		}
	//} else if(i == 6) {
		
		/*$('#td'+i).html("<input type=\"file\" accept=\".jpg,.png,.gif,.tif,.pdf\" name=\"fileToUpload\" id=\"fileToUpload\">");
		$('#td'+i+'0').html("<button type='button' id='savebuttopon' onclick='save("+i+", "+uid+")' class='btn btn-success'>Save</button>");
		
		$('#td00').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
		$('#td10').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
		$('#td20').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
		$('#td30').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
		$('#td40').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
		$('#td50').html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
	}*/

}

function edits(i, uid, id) {
    
        var values = $('#td'+i+'s'+id).html();
        $('#td'+i+'s'+id).html("<input type='text' class='form-control' id='inputt' name='change' value='"+values+"'>");
        $('#td'+i+'0s'+id).html("<button type='button' id='savebuttopon' onclick='saves("+i+", "+uid+", "+id+")' class='btn btn-success'>Save</button>");
    
        if(i != 6) {
            index = i+1; 
            if(index > 6) {
                i = 0;
            }
            while(index != i) {
    
                $('#td'+index+'0s'+id).html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
    
                if(index == 6) {
                    index = 0;
                } else {
                    index++;
                }
            }
        } else {
            $('#td00s'+id).html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
            $('#td10s'+id).html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
            $('#td20s'+id).html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
            $('#td30s'+id).html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
            $('#td40s'+id).html("<i class=\"fa fa-window-close\" aria-hidden=\"true\"></i>");
        }
    
    }

function save(i, uid) {
    

    var index = i;
    var userid = uid;

    var select = "";
    if(index == 0) {
        select = "username";
    } else if(index == 1) {
        select = "email";
    } else if(index == 2) {
        select = "sex";
    } else if(index == 3) {
        select = "zipcode";
    } else if(index == 4) {
        select = "city";
    } else if(index == 5) {
        select = "state";
    } else if(index == 6) {
        select = "profileimg";
    }

	if(index != 6) {
		$.ajax({
                        
        type: "POST",
            url: "php/savechanges.php?index="+select+"&userid="+userid,
            processData: false,
            contentType: "application/json",
            data: `
            {
                "change": "`+ $("#inputt").val() +`"
            }`,
            success: function(r) {
                console.log(r);
                document.location.href = "profile.php"
            },	
            error: function(r) {
                console.log(r);
            }
        })
	} else {
		
	}
    
}

function saves(i, uid, sid) {
    

    var index = i;
    var userid = uid;
    var sportid = sid;

    var select = "";
    if(index == 0) {
        select = "sport";
    } else if(index == 1) {
        select = "school";
    } else if(index == 2) {
        select = "position";
    } else if(index == 3) {
        select = "awards";
    } else if(index == 4) {
        select = "level";
    } else if(index == 5) {
        select = "statistics";
    } else if(index == 6) {
        select = "extra";
    }

    var value = $("#inputt").val();

    value = value.replace("'", "\'");
    value = value.replace('"', '\"');

    $.ajax({
                        
        type: "POST",
            url: "php/sportssavechange.php?index="+select+"&sid="+sportid,
            processData: false,
            contentType: "application/json",
            data: `
            {
                "change": "`+value+`"
            }`,
            success: function(r) {
                console.log(r);
                document.location.href = "profile.php"
            },	
            error: function(r) {
                console.log(r);
            }
        })
    
}