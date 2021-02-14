$("document").ready(function(){
    $("#validatebtn").click(function(){
        var emailid=$("#emailid").val();
        var pass=$("#pass").val();
        var formdata={emailid,pass};
        $.post("../php/validate.php",formdata,function(data,status){
            try{  
                data=JSON.parse(data);
                            
               if(data.status==200)
                    window.location.href="http://localhost/blog-bootstrap-php/admin.php";
               else
               {
                snippet = `<button class="btn btn-danger">${data.message}</button>`; 
                $("#response").html(snippet);
               }
            }
            catch(e){
                var snippet = `<button class="btn btn-danger">${e.message}</button>`;
                $("#response").html(snippet);
            }
        });
    });
});
