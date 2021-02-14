$("document").ready(function(){
    $("#registerbtn").click(function(){
        var emailid=$("#emailid").val();
        var username=$("#username").val();
        var pass=$("#pass").val();
        var formdata={emailid,username,pass};
        $.post("../php/register.php",formdata,function(data){
            try{  
                data=JSON.parse(data);
                            
               if(data.status==200)
               {
                $("#response").html(`<button class="btn btn-success">Registered Successfully.</button>`);
                setTimeout(function(){
                    window.location.href="../html/login.html";
                }, 2000);
               }
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
