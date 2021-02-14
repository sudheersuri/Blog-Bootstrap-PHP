$("document").ready(function(){
    snippet = "";    
    $.GET("../php/getblogs.php",function(data){
        data=JSON.parse(data);
        i=0;
        while(i<data.length)
        {
            snippet+= '<div class="col-md-12">';
            snippet+= '<div class="blog-entry ftco-animate d-md-flex">';
            snippet+= `<a href="single.html" class="img img-2" style="background-image: url(${data.imglocation});"></a><div class="text text-2 pl-md-4"> <h3 class="mb-2"><a href="single.html">${data.title}</a></h3>`;
            snippet+=  `<div class="meta-wrap"><p class="meta"><span><i class="icon-calendar mr-2"></i>${data.dateadded}</span><span><a href="single.html"><i class="icon-folder-o mr-2"></i>Travel</a></span><span><i class="icon-comment2 mr-2"></i>5 Comment</span>`;
            snippet+= `</p></div><p class="mb-4">${data.sdesc}</p><p><a href="#" class="btn-custom">Read More <span class="ion-ios-arrow-forward"></span></a></p></div></div></div>`;
            i++;    
        }
        $j(".blogs").prepend(snippet);
    });
});