$("document").ready(function(){
    $("#secretcodeform").hide();
    $("#resetpasswordform").hide();
    $("#mailbtn").click(function(){
        var emailid=$("#emailid").val();
        $("#mailbtn").html("Sending Mail....");
        sendMail(emailid);
    });
    $("#verifybtn").click(function(){
        var secretcode=$("#secretcode").val();
        secretcodeverification(secretcode);
    });
    $("#resetbtn").click(function(){
        var passone=$("#passone").val();
        var passtwo=$("#passtwo").val();
        if(passone==passtwo)
        {
            updatePass(passone);
        }
        else
        {
            var snippet = `<button class="btn btn-danger">Passwords dont match</button>`;
            $("#responsethree").html(snippet);
        }
    });
        function sendMail(emailid)
        {
            formdata={emailid};
            $.post("../php/forgot.php?type=sendmail",formdata,function(data){
                try{  
                    data=JSON.parse(data);
                   if(data.status==200)
                   {
                    $("#mailbtn").html("Resend Mail");
                       $("#responseone").html(`<button class="btn btn-success">Mail Has been sent</button>`);
                       setTimeout(function(){
                        $("#mailaskform").hide();
                        $("#secretcodeform").show();
                       },1500);
                   }
                   else
                   {
                    $("#mailbtn").html("Resend Mail");
                    snippet = `<button class="btn btn-danger">${data.message}</button>`; 
                    $("#responseone").html(snippet);
                   }
                }
                catch(e){
                    $("#mailbtn").html("Resend Mail");
                    var snippet = `<button class="btn btn-danger">${e.message}</button>`;
                    $("#responseone").html(snippet);
                }
            });
        }
        const secretcodeverification=(secretcode)=>{
            $.post("../php/forgot.php?type=sessioncode",{secretcode},function(data){
                try{  
                    data = JSON.parse(data);
                    if(data.status==200)
                    {
                        $("#responsetwo").html(`<button class="btn btn-success">Verification Successful</button>`);
                        setTimeout(function(){
                            $("#secretcodeform").hide();
                            $("#resetpasswordform").show();
                        },1500);
                    }
                    else
                    {   
                        $("#responsetwo").html(`<button class="btn btn-danger">Bad Request , Server error, please try agian later.</button>`);
                    }
                }
                catch(e)
                {
                    $("#responsetwo").html(`<button class="btn btn-danger">Server error, please try agian later.</button>`);
                }
               setTimeout(()=>{
                    $("#mailaskform").hide();
                    $("#secretcodeform").show();
               },1000);
        });
        }
        const updatePass=(passone)=>
        {   
            $.post("../php/forgot.php?type=updatepass",{passone},function(data)
            {
                try{
                        data = JSON.parse(data);
                        if(data.status==200)
                        {
                            snippet = `<button class="btn btn-success">Password Has been updated successfully</button>`; 
                            $("#responsethree").html(snippet);
                            setTimeout(function(){
                                window.location.href="../html/login.html";
                            },1500);
                        }
                        else
                        {
                            snippet = `<button class="btn btn-danger">${data.message}</button>`; 
                            $("#responsethree").html(snippet);
                        }
                   }
                catch(e)
                {
                var snippet = `<button class="btn btn-danger">${e.message}</button>`;
                $("#responsethree").html(snippet);
                }
            });
            
        }
});
